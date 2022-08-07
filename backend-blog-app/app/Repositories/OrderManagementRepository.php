<?php

namespace App\Repositories;

use App\Interfaces\OrderManagementRepositoryInterface;
use App\Models\Order;
use App\Models\OrderAssign;
use App\Models\Sell;
use App\Models\SellAssign;
use Illuminate\Support\Facades\DB;

class OrderManagementRepository implements OrderManagementRepositoryInterface
{
    public function getAllOrder($request)
    {
        $order = Order::with('shipper');
        if ((isset($request->from_date) && isset($request->to_date)) || isset($request->shipper_id)){
            $order->whereIn('id', function ($query) use ($request){
                $query->select('order_id')->from('order_assigns');
                if (isset($request->shipper_id))
                    $query->where('shipper_user_id', $request->shipper_id);
                if (isset($request->from_date) && isset($request->to_date))
                    $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
            });
        }

        return $order->get();
    }

    public function getOrderByOrderNo($order_no)
    {
        return Order::with(['coupon', 'paymentMethod', 'userInfo'])->where('order_no', $order_no)->first();
    }

    public function getOrderById($id)
    {
        return Order::findOrFail($id);
    }

    public function orderDetails($id)
    {
        return Sell::with(['product', 'shipper'])->where('order_id', $id)->get();
    }

    public function assignShipper($request, $order_id)
    {
        DB::beginTransaction();

        $order_assign = OrderAssign::create([
            'order_id' => $order_id,
            'shipper_user_id' => $request->shipper
        ]);
        $sellAssignData = [];
        foreach ($request->sell_ids as $sell_id){
            $sell = Sell::find($sell_id);

            $data = [
                'order_id' => $order_id,
                'order_assign_id' => $order_assign->id,
                'sell_id' => $sell_id,
                'shipper_user_id' => $request->shipper,
                'product_id' => $sell->product_id,
                'qty' => $sell->qty,
            ];
            $sellAssignData[] = $data;

            $sell->is_assigned = 1;
            $sell->is_set_shipper = 1;
            $sell->shipper_id = $request->shipper;
            $sell->save();
        }
        SellAssign::insert($sellAssignData);

        DB::commit();
    }

    public function reAssignShipper($request, $order_id)
    {
        DB::beginTransaction();

        $last_order_assign_step = OrderAssign::where('order_id', $order_id)->orderBy('id', 'desc')->first()->assign_step;

        $order_assign = OrderAssign::create([
            'order_id' => $order_id,
            'shipper_user_id' => $request->shipper,
            'assign_step' => $last_order_assign_step + 1
        ]);
        $sellAssignData = [];
        foreach ($request->sell_ids as $sell_id){
            $sell = Sell::find($sell_id);

            $data = [
                'order_id' => $order_id,
                'order_assign_id' => $order_assign->id,
                'sell_id' => $sell_id,
                'shipper_user_id' => $request->shipper,
                'product_id' => $sell->product_id,
                'qty' => $sell->qty,
            ];
            $sellAssignData[] = $data;

            $sell->is_set_shipper = 1;
            $sell->shipper_id = $request->shipper;
            $sell->save();
        }
        SellAssign::insert($sellAssignData);

        DB::commit();
    }

    public function freeBio($request, $order_id)
    {
        return $orderShipper = Sell::create([
            'order_id' => $order_id,
            'package_product_grp_id' => $request->product_id,
            'product_id' => $request->product_id,
            'qty' => $request->quantity,
            'freebio' => 1,
        ]);
    }

    public function deleteProduct($sell_id, $order_id)
    {
        $sell = Sell::find($sell_id);
        $order = Order::find($order_id);

        $json = json_decode($order->cartItems, true); //return an array

        foreach ($json as $key => $value) {
            if ($value['id'] == $sell->product_id) {
                unset($json[$key]);
            }
            if ($value['cartType'] == 'package' && count($value['package_products']) > 0) {
                foreach ($value['package_products'] as $key2 => $package_product) {
                    if ($package_product['id'] == $sell->product_id) {
                        unset($json[$key]['package_products'][$key2]);
                    }
                }
            }
        }
        $cartItem = json_encode($json);
        $order->update(['cartItems' => $cartItem]);
        $sell->delete();
    }
}
