<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Sell;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;

use App\Http\Controllers\Api\Frontend\ConfigurationController;
use App\Jobs\OrderAdminMailableJobQueue;
use App\Jobs\OrderCustomerProductListMailJobQueue;
use App\Jobs\PaymentMethodMailSendJob;
use App\Jobs\PaymentMethodVisaMailableJob;
use App\Models\ConditionalMoneyReceiver;
use App\Models\MoneyReceiver;
use App\Models\Offer;
use App\Models\PackageProduct;
use App\Models\PaymentMethod;
use App\Models\UserInfo;
use App\Models\VisaDetails;
use App\Services\Coupon\CouponService;
use App\Services\Order\OrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\PaymentMethodRepository;

class OrderRepository implements OrderRepositoryInterface {

    private $config;
    private $paymentMethodRepository;
    private $storeRepo;
    private $orderService;
    private $cartService;
    private $couponService;
    public function __construct()
    {
        $this->config = new ConfigurationController();

        $this->paymentMethodRepository = new PaymentMethodRepository();

        $this->storeRepo = new StoreRepository();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->checkoutService = new CheckoutService();
        $this->couponService = new CouponService();
    }

    public function userFirstOrCreate($request){
        $token = random_bytes(8);
        $token = bin2hex($token);
        return User::firstOrCreate(
            ['email' => $request->email],
            [
                'name'          => $request->fname." ".$request->lname,
                'email'         => $request->email,
                'role_type'     => User::ROLE_CUSTOMER,
                'shop_name'     => $request->storeName,
                'shop_domain'   => $request->storeDomainName,
                'token'         => $token
            ],
        );
    }
    public function orderCreate($userId, $userInfoId, $productIsApplicableForCoupon, $coupon, $totalPrice, $grandTotal, $storeData, $paymentMethodId, $packageIdCollect, $request ){
        $orderCreate =  Order::create([
            'status' => Order::ORDER_TYPE_PROCESSING,
            'user_id' => $userId,
            'user_info_id' => $userInfoId,
            'coupon_id' => $productIsApplicableForCoupon == true ? $coupon->id : null,
            'sub_total' => $totalPrice,
            'grand_total' => $grandTotal,
            'store_id' => !is_null($storeData) ? $storeData['id']: null,
            'payment_method_id' => $paymentMethodId,
            'payment_method_name' =>  $request->payment_method,
            'order_no' => $this->orderService->orderNumberAutoGenerate(),
            'package_id' => $packageIdCollect,
            'is_guest' => !is_null( $request->authUserInfoId ) ?  false: true
        ]);
        return $orderCreate;
    }
    public function userInfoCreate($user, $request){
        $userInfosCreate = UserInfo::create([
            'user_id' => $user->id,
//            'order_id' => $orderCreate->id,
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'company' => $request->company,
            'address' => $request->address,
            'apt' =>$request->apt,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip,
            'email' => $request->email,
            'board_id' => $request->board,
            'additional_information' => $request->info,
            'status' =>  UserInfo::STATUS_ACTIVE,
        ]);
        return $userInfosCreate;
    }

    public function visaDetailsCreate($request, $userInfosCreate){

        if( $request->payment_method == 'visa' && $userInfosCreate ){

            $visaDetailsCreate = VisaDetails::create([
                'userinfo_id' => $userInfosCreate->id,
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip,
                'phone_number' => $request->phone_number,
                'card_number' => $request->card_number,
                'expire_month' => $request->expire_month,
                'expire_year' => $request->expire_year,
                'cvv' => $request->cvv,
            ]);
            return $visaDetailsCreate;
        }
    }




    public function orderStore($request){
        $totalPrice = 0;
        $grandTotal = 0;
        // "one time use" coupon validaiton check
        $oneTimeCouponValidate = $this->couponService->onTimeCouponValidationCheck($request->code, $request->email);
        if($oneTimeCouponValidate && $oneTimeCouponValidate->original['status'] == 'ontimeuse_coupon_error'){
            return response()->json([
                'status' => 'ontimeuse_coupon_error',
                'message' => $oneTimeCouponValidate->original['message']
            ]);
        }

        $cartResponse = $this->cartService->getCartsInfo($request);

        if($cartResponse && $cartResponse->original['status'] == 'error'){
            return response()->json([
                'status' => 'coupon_error',
                'message' => $cartResponse->original['message']
            ]);
        }
        $cart_collects = $cartResponse->original['cartCollection'];
        // package exist check
        $packageIdCollect = collect([]);
        if(count($cart_collects) > 0){
            foreach($cart_collects as $cart){
                if($cart['cartType'] == 'package'){
                    $packageIdCollect->push(array('id'=>$cart['id'],'qty'=>$cart['quantity']) );
                }
            }
        }

        // coupon applicable check and coupon appliable wise and offer wise product and package total price calculate
        $productIsApplicableForCoupon = false;
        $productIsApplicableForCoupon = $this->checkoutService->couponIsApplicableCheck($cart_collects);
        $totalPrice = $this->checkoutService->totalProductAndPackagePriceCalculate($cart_collects, $productIsApplicableForCoupon);

        $coupon = null;
        if( $productIsApplicableForCoupon ){
            $coupon = Coupon::where('code',$request->code)->first();
        }
        $grandTotal = $totalPrice;
        //store name  wise data fetch form stores database
        // here it is shop name
        $storeData = $this->storeRepo->getStoreByStoreName($request->storeName);
        if(is_null($storeData))
        return response()->json([
            'status' => 'coupon_error',
        ]);

        // configuation wise priceing calculate
        $configuration = $this->config ->index();
        $configurationData = null;
        if($configuration->original['status'] == 'success'){
            $configurationData = $configuration->original['data'];
        }

        $grandTotal = $this->configWiseGrandTotalCalculate($totalPrice, $grandTotal, $configuration);


        // in checkout page payment method sort_name wise payment data fetch
        $paymentMethod  =   $this->paymentMethodRepository->getActivePaymentMethodByShortName($request->payment_method);
        $grandTotal = $this->paymentMethodWiseGrandTotalCalculate($paymentMethod, $totalPrice, $grandTotal, $productIsApplicableForCoupon);

        DB::beginTransaction();
        try {
            $user = $this->userFirstOrCreate($request);

            // user infos created
            $userInfosCreate = $this->userInfoCreate($user, $request);

            // order create
            $orderCreate = $this->orderCreate($user->id, $userInfosCreate->id, $productIsApplicableForCoupon, $coupon, $totalPrice, $grandTotal, $storeData,  $paymentMethod['id'], $packageIdCollect, $request );

            //if payment method is visa then visa info create
            $visaDetailsCreate = null;
            $visaDetailsCreate= $this->visaDetailsCreate($request, $userInfosCreate);

            // make reusable cart product in array
            $cartItemsArray = array();
            $cartItemsArray = $this->cartWiseProductAndPackageMakeListWithStoreForSellIsOptional($cartItemsArray ,$cart_collects, $productIsApplicableForCoupon, $orderCreate );

            //money receiver
            $moneyReceiver = $this->serialWiseMoneyReceiverAssign($paymentMethod, $grandTotal);

            //email send
            $this->afterProductOrderMailSend($paymentMethod, $request, $orderCreate, $userInfosCreate, $visaDetailsCreate, $grandTotal, $cartItemsArray, $coupon, $configurationData, $moneyReceiver, $sendMailTime=4);

            // cartItems
            $orderCreate->update([
                'cart_items' => json_encode($cartItemsArray, true),
                'money_receiver_id' =>  $moneyReceiver->id
            ]);

            // moneyReceiver track
            $moneyReceiver->update([
                'receivers_track' => Carbon::now()
            ]);

            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'status' => 'exception_error',
                'message' => 'Something is wrong',
                'getMessage' => $e->getMessage()
            ]);
        }


        return response()->json([
            'status' => 'success',
            'order_id' => $orderCreate->id,
        ]);


    }

    public function afterProductOrderMailSend($paymentMethod, $request, $orderCreate, $userInfosCreate, $visaDetailsCreate, $grandTotal, $cartItemsArray, $coupon, $configurationData, $moneyReceiver,  $sendMailTime){
        $template_name = "emails.orders.".strtolower($paymentMethod->short_name)."_mail_send";
        try {
            if( strtolower($request->payment_method) == 'visa' ){
                $emailJob = (new PaymentMethodVisaMailableJob($request->email,$orderCreate, $userInfosCreate, $visaDetailsCreate, $grandTotal))->delay(Carbon::now()->addSeconds($sendMailTime));
                dispatch($emailJob);

            }else{
                $emailJob = (new PaymentMethodMailSendJob($request->email, $template_name, $grandTotal, $moneyReceiver, $request->storeDomainName, $paymentMethod, $orderCreate))->delay(Carbon::now()->addSeconds($sendMailTime));
                dispatch($emailJob);
            }
        } catch (\Exception  $e) {
            //throw $th;
        }
        try {
            if(strtolower( $paymentMethod->short_name ) == 'wu' || strtolower( $paymentMethod->short_name ) == 'mg'){
                $emailJob = (new PaymentMethodMailSendJob("info@mymonsterlabs.com", $template_name, $grandTotal, $moneyReceiver, $request->storeDomainName, $paymentMethod, $orderCreate))->delay(Carbon::now()->addSeconds($sendMailTime));
                dispatch($emailJob);
            }
        } catch (\Exception  $e) {
            //throw $th;
        }
        try {

            if( strtolower($request->payment_method) != 'visa' ){
                $emailJob = (new OrderCustomerProductListMailJobQueue($request->email, $request->storeDomainName, $paymentMethod, $orderCreate, $userInfosCreate, $cartItemsArray, $coupon, $configurationData))->delay(Carbon::now()->addSeconds($sendMailTime));
                dispatch($emailJob);
            }
        } catch (\Exception  $e) {
            //throw $th;
        }

        try {

            $data = array(
                'email' => 'info@mymonsterlabs.com',
                'subject' => '[Monster Labs]New customer order (' . $orderCreate->order_no . ')- ' . $orderCreate->created_at,

            );
            $emailJob = (new OrderAdminMailableJobQueue($data ,$request->storeDomainName, $paymentMethod, $orderCreate, $userInfosCreate, $cartItemsArray, $coupon, $configurationData, $visaDetailsCreate))->delay(Carbon::now()->addSeconds($sendMailTime));
            dispatch($emailJob);

            // Mail::to($data['email'])->send(new OrderAdminMailable($data ,$request->storeDomainName, $paymentMethod, $orderCreate, $userInfosCreate, $cartItemsArray, $coupon, $configurationData, $visaDetailsCreate));
        } catch (\Exception $th) {
            //throw $th;
        }

        try {

            $data = array(
                'email' => 'recheck@sectorbravo1.com',
                'subject' => '[Monster Labs]New customer order (' . $orderCreate->order_no . ')- ' . $orderCreate->created_at,

            );
            $emailJob = (new OrderAdminMailableJobQueue($data ,$request->storeDomainName, $paymentMethod, $orderCreate, $userInfosCreate, $cartItemsArray, $coupon, $configurationData, $visaDetailsCreate))->delay(Carbon::now()->addSeconds($sendMailTime));
            dispatch($emailJob);

        } catch (\Exception $th) {
            //throw $th;
        }



    }

    public function serialWiseMoneyReceiverAssign($paymentMethod, $grandTotal){
        //conditional monney receiver logic
        $paymentCategory = null;
        if($grandTotal > 550 && $grandTotal <= 1200 ){
            $paymentCategory = MoneyReceiver::PAYMENT_CATEGORY_CHINA;
        } else if ($grandTotal >= 400 && $grandTotal <= 550) {
            $paymentCategory =MoneyReceiver::PAYMENT_CATEGORY_HIGH;
        } else {
            $paymentCategory =MoneyReceiver::PAYMENT_CATEGORY_LOW;
        }

        $conditionally_money_receivers = ConditionalMoneyReceiver::with('money_receiver')
        ->where('status', ConditionalMoneyReceiver::ACTIVE)->latest()->get();

        $money_receiver_ids = [];
        // this condition only apply for mg and wu, in admin panel (mg, wu) conditional money receiver handel
        if(count($conditionally_money_receivers) > 0) {
            foreach($conditionally_money_receivers as $conditionally_money_receiver) {

                if( $paymentMethod->id == $conditionally_money_receiver->money_receiver->payment_method_id
                && strtolower( $conditionally_money_receiver->money_receiver->payment_category) == strtolower($paymentCategory)
                ) {
                    if($conditionally_money_receiver->use_limit > $conditionally_money_receiver->count) {
                        if(!in_array($conditionally_money_receiver->money_receiver_id, $money_receiver_ids)) {
                            $money_receiver_ids[] = $conditionally_money_receiver->money_receiver_id;
                        }
                    }else {
                        $conditionally_money_receiver->status = ConditionalMoneyReceiver::DEACTIVE;
                        $conditionally_money_receiver->save();
                    }
                }

            }
        }
        // return $money_receiver_ids;

        if(count($money_receiver_ids) > 0){
            $moneyReceiver = MoneyReceiver::whereIn('id',$money_receiver_ids);
        }else{
              //money receiver
            $moneyReceiver = MoneyReceiver::where('payment_method_id',$paymentMethod->id);
        }

        if( in_array(strtolower($paymentMethod['short_name']), array(strtolower(MoneyReceiver::PAYMENT_METHOD_WU), strtolower(MoneyReceiver::PAYMENT_METHOD_MG) ) )  ){
            $moneyReceiver = $moneyReceiver->where('payment_category',$paymentCategory);
        }


        $moneyReceiver = $moneyReceiver ->where('status','active')
        ->orderBy('receivers_track','asc')->first();


        if(isset($moneyReceiver) && count($money_receiver_ids) > 0){

            $singleCondMonRec = ConditionalMoneyReceiver::where('money_receiver_id',$moneyReceiver->id)->first();
            $singleCondMonRec->update([
                'count' => $singleCondMonRec->count + 1
            ]);

            // return $singleConditionalMoneyReceiver;
        }
        // return array(
        //     'moneyReceiver' => $moneyReceiver,
        //     'money_receiver_ids' => $money_receiver_ids,
        // );
        return $moneyReceiver;
    }

    public function configWiseGrandTotalCalculate($totalPrice, $grandTotal, $configuration){

        if(!is_null($configuration) && $configuration->original['status'] == 'success' ){
            $configurationData = $configuration->original['data'];
            if($totalPrice < $configurationData['min_order_amount'] ){
                return response()->json([
                    'status' => 'error'
                ]);
            }
            // if total price is less then avoid_shipping_change then shipping cost is added in total price
            if($totalPrice < $configurationData['avoid_shipping_charge_for']){
                $grandTotal = $grandTotal +  $configurationData['shipping_charge'];
            }
        }
        return $grandTotal;
    }

    public function paymentMethodWiseGrandTotalCalculate($paymentMethod, $totalPrice, $grandTotal, $productIsApplicableForCoupon){
        // payment method wise priceing calculate
        if(!is_null($paymentMethod)){

            if( !is_null($paymentMethod['surcharge']) && ($totalPrice >= $paymentMethod['min']  && $totalPrice <= $paymentMethod['max'] ) ){
                $grandTotal = $grandTotal + $paymentMethod['surcharge'];
            }else if( !is_null($paymentMethod['discount_type'])  && ($totalPrice >= $paymentMethod['min']  && $totalPrice <= $paymentMethod['max'] )  ){
                if( !$productIsApplicableForCoupon ){
                    if( $paymentMethod['discount_type'] == PaymentMethod::PERCENTAGE ){
                        if( !is_null($paymentMethod['discount_amount'])){
                            $percentageAmount = ( $grandTotal * $paymentMethod['discount_amount']  )/100;
                            $grandTotal = $grandTotal - $percentageAmount;
                        }
                    }else{
                        //discount_amount = doller
                        if( !is_null($paymentMethod['discount_amount'])){
                            $grandTotal = $grandTotal - $paymentMethod['discount_amount'];
                        }

                    }
                }
            }
        }
        return $grandTotal;
    }


    public function cartWiseProductAndPackageMakeListWithStoreForSellIsOptional($cartItemsArray ,$cart_collects, $productIsApplicableForCoupon, $orderCreate = null ){
        $checkoutService = new CheckoutService();
          //cart items store into sell table
          foreach($cart_collects as $item){

            if( $item['cartType'] == 'product' ){
                if($productIsApplicableForCoupon){
                    // this product coupon apply
                    if( $item['activeCoupon'] == true ){
                        $price =  $item['price'] *  $item['quantity'];

                        $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, true, true, false  );
                        if( !is_null($orderCreate) ){

                            $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'],$item['cartType'] ,0, $price);
                        }

                    }else{

                        if(count($item->offers) > 0){
                            $offerItem = $item->offers[0];
                            if($offerItem['offer_type'] == 'single_product'){

                                $price = $checkoutService->singleProductAndPackagePriceCalculate($item);
                                // ##################################
                                $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false, false  );

                                if( !is_null($orderCreate) ){

                                    $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'],$item['cartType'] ,0, $price);
                                }

                            }
                            else if($offerItem['offer_type'] == 'buy_and_get'){
                                if($offerItem['offer_variation'] == Offer::FREE  ){

                                    $price = $checkoutService->singleProductAndPackagePriceCalculate($item);
                                    // #################

                                    $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false,  Offer::FREE  );
                                    if( !is_null($orderCreate) ){

                                        $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'],$item['cartType'] ,0, $price);
                                    }


                                    if( count($offerItem->products) > 0  && ( $item['quantity'] >=  $offerItem['buy_quantity'] )){
                                        $freeProductQty = $checkoutService->freeProductQuantityCalculate($item);
                                        $offerFreePoducts = $offerItem->products[0];

                                        $cartItemsArray = $this-> freeProductAddedIntoProductOrPackage($cartItemsArray, $item, $offerFreePoducts['id'], $offerFreePoducts['name'], $freeProductQty, $price=0 );
                                        if( !is_null($orderCreate) ){

                                            $this->productPlacedForSell($offerFreePoducts['id'], $orderCreate->id, $freeProductQty, $item['id'], $item['cartType'] , 1, null);
                                        }

                                    }

                                }
                                else if($offerItem['offer_variation'] == Offer::DISCOUNT ){

                                    $price = $checkoutService->singleProductAndPackagePriceCalculate($item);
                                    // ###############################

                                    $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false, false  );
                                    if( !is_null($orderCreate) ){

                                        $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'],$item['cartType'] ,0, $price);
                                    }

                                }
                            }
                        }else{
                            $price = $checkoutService->singleProductAndPackagePriceCalculate($item);

                            $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false, false  );
                            if( !is_null($orderCreate) ){

                                $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'], $item['cartType'] ,0, $price);
                            }

                        }
                    }
                }
                else{
                    // coupon not apply so offer check and sell table data insert
                      // this product offer exist check
                    if(count($item->offers) > 0){
                        $offerItem = $item->offers[0];
                        if($offerItem['offer_type'] == 'single_product'){

                            $price = $checkoutService->singleProductAndPackagePriceCalculate($item);
                            // ##################################
                            $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false, false  );
                            if( !is_null($orderCreate) ){

                                $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'],$item['cartType'] ,0, $price);
                            }
                        }
                        else if($offerItem['offer_type'] == 'buy_and_get'){
                            if($offerItem['offer_variation'] == Offer::FREE  ){

                                $price = $checkoutService->singleProductAndPackagePriceCalculate($item);
                                // #################

                                $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false,  Offer::FREE  );

                                // $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity']);
                                if( !is_null($orderCreate) ){

                                    $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'], $item['cartType'] ,0, $price);
                                }

                                if( count($offerItem->products) > 0  && ( $item['quantity'] >=  $offerItem['buy_quantity'] )){
                                    $freeProductQty = $checkoutService->freeProductQuantityCalculate($item);
                                    $offerFreePoducts = $offerItem->products[0];

                                    $cartItemsArray = $this-> freeProductAddedIntoProductOrPackage($cartItemsArray, $item, $offerFreePoducts['id'], $offerFreePoducts['name'], $freeProductQty, $price=0 );
                                    if( !is_null($orderCreate) ){

                                        $this->productPlacedForSell($offerFreePoducts['id'], $orderCreate->id, $freeProductQty, $item['id'], $item['cartType'] , 1, null);
                                    }
                                }

                            }
                            else if($offerItem['offer_variation'] == Offer::DISCOUNT ){

                                $price = $checkoutService->singleProductAndPackagePriceCalculate($item);
                                // ###############################

                                $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false, false  );
                                if( !is_null($orderCreate) ){

                                    $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'], $item['cartType'] ,0, $price);
                                }

                            }
                        }
                    }else{
                        $price = $checkoutService->singleProductAndPackagePriceCalculate($item);

                        $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false, false  );
                        if( !is_null($orderCreate) ){

                            //offer not applicable in this product
                            $this->productPlacedForSell($item['id'], $orderCreate->id, $item['quantity'], $item['id'],$item['cartType'] ,0, $price);
                        }


                    }

                }
            }
            else if( $item['cartType'] == 'package' ){

                $packageProducts = PackageProduct::with(['product' =>function($query){
                    $query->select('id','name');
                }])->where('package_id', $item['id'])->get();


                if(count($item->offers) > 0){
                    $offerItem = $item->offers[0];
                    if($offerItem['offer_variation'] == Offer::FREE  ){
                        $price = $checkoutService->singleProductAndPackagePriceCalculate($item);

                        $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false,  Offer::FREE  );

                        if($packageProducts->count() > 0){
                            foreach($packageProducts as $product){

                                    $cartItemsArray = $this->productsForPackage($cartItemsArray, $item,$product->product->id, $product->product->name, ($item['quantity'] * $product->quantity) );

                                    // $this->productPlacedForSell($product->product_id, $orderCreate->id, $item['quantity'] * $product->quantity);
                                    if( !is_null($orderCreate) ){

                                        $this->productPlacedForSell($product->product_id, $orderCreate->id, $item['quantity'] * $product->quantity, $item['id'],$item['cartType'] ,0, $price);
                                    }


                            }
                        }

                        if( count($offerItem->products) > 0  && ( $item['quantity'] >=  $offerItem['buy_quantity'] )){
                            $freeProductQty = $checkoutService->freeProductQuantityCalculate($item);
                            $offerFreePoducts = $offerItem->products[0];

                            $cartItemsArray = $this-> freeProductAddedIntoProductOrPackage($cartItemsArray, $item, $offerFreePoducts['id'], $offerFreePoducts['name'], $freeProductQty, $price=0 );

                            // $this->productPlacedForSell($offerFreePoducts['id'], $orderCreate->id, $freeProductQty);
                            if( !is_null($orderCreate) ){

                                $this->productPlacedForSell($offerFreePoducts['id'], $orderCreate->id, $freeProductQty, $item['id'],$item['cartType'] ,1, null);
                            }
                        }

                    }
                    else if($offerItem['offer_variation'] == Offer::DISCOUNT ){
                        $price = $checkoutService->singleProductAndPackagePriceCalculate($item);

                        $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false,  false );
                        if($packageProducts->count() > 0){
                            foreach($packageProducts as $product){


                                $cartItemsArray = $this->productsForPackage($cartItemsArray, $item,$product->product->id, $product->product->name, ($item['quantity'] * $product->quantity) );

                                // $this->productPlacedForSell($product->product_id, $orderCreate->id, $item['quantity'] * $product->quantity);
                                if( !is_null($orderCreate) ){

                                    $this->productPlacedForSell($product->product_id, $orderCreate->id, $item['quantity'] * $product->quantity, $item['id'],$item['cartType'] ,0, $price);
                                }

                            }
                        }
                    }

                }else{
                    $price = $checkoutService->singleProductAndPackagePriceCalculate($item);

                    $cartItemsArray = $this-> cartItemProductAndPackageMakeInArray($cartItemsArray, $item['id'], $item['cartType'] ,$item['name'], $item['quantity'], $price, false, false,  false );

                    //offer not applicable in this product
                    if($packageProducts->count() > 0){
                        foreach($packageProducts as $product){


                            $cartItemsArray = $this->productsForPackage($cartItemsArray, $item,$product->product->id, $product->product->name, ($item['quantity'] * $product->quantity) );

                            // $this->productPlacedForSell($product->product_id, $orderCreate->id, $item['quantity'] * $product->quantity);
                            if( !is_null($orderCreate) ){

                                $this->productPlacedForSell($product->product_id, $orderCreate->id, $item['quantity'] * $product->quantity, $item['id'],$item['cartType'] ,0, $price);
                            }
                        }
                    }

                }
            }
        }
        return $cartItemsArray;
    }

    public function cartItemProductAndPackageMakeInArray($cartItemsArray, $itemid, $itemCartType , $itemName, $itemQuentity, $price, $activeCoupon, $allowCoupon, $offer_variation  ){
            // ##################################
            $cartItemsArray[$itemid] = array(
            'id' => $itemid,
            'cartType' => $itemCartType,
            'name' => $itemName,
            'quantity' => $itemQuentity,
            'price' => $price ,
            'activeCoupon' => $activeCoupon ,
            'allowCoupon' => $allowCoupon ,
            'offer_variation' => $offer_variation,
            'offer_products' => array(),
            'package_products' => array(),
        );
        return $cartItemsArray;
    }

    public function freeProductAddedIntoProductOrPackage($cartItemsArray, $singleCart, $offerFreePoductsId, $offerFreePoductsName, $freeProductQty, $price ){
        // #############################
        $freeProduct = array(
            'id' => $offerFreePoductsId,
            'name' => $offerFreePoductsName,
            'quantity' => $freeProductQty,
            'price' => $price
        );
        array_push($cartItemsArray[$singleCart['id']]['offer_products'] ,$freeProduct);

        return $cartItemsArray;
    }

    public function productsForPackage($cartItemsArray, $singleCart, $packageProductId, $packageProductName, $packgeProductquantity ){

        $packageProduct = array(
            'id' => $packageProductId,
            'name' => $packageProductName,
            'quantity' => $packgeProductquantity,
            'price' => 0
        );
        array_push($cartItemsArray[$singleCart['id']]['package_products'] ,$packageProduct);

    return $cartItemsArray;
    }


    public function productPlacedForSell($productId, $orderId, $productQty, $productOrPackgeId, $cartType, $isFree=0, $price){
        $sellCreate = Sell::create([
            'product_id' => $productId,
            'order_id' => $orderId,
            'qty' => $productQty,
            'package_product_grp_id' => $productOrPackgeId,
            'is_product_package' => $cartType,
            'is_free' => $isFree,
            'price' => $price,
        ]);
    }

    public function showOrderById($id){
        $order = Order::when(request()->userinfo == true, function($query){
            $query->with('userInfo');
        })->when(request()->coupon == true, function($query){
            $query->with('coupon');
        })->when(request()->moneyreceiver == true, function($query){
            $query->with('moneyReceiver');
        })
        ->when(request()->paymentmethod == true, function($query){
            $query->with('paymentMethod');
        })->find($id);
        return $order;
    }


}
