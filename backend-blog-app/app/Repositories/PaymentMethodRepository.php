<?php

namespace App\Repositories;

use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Services\Utils\FileUploadService;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class  PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    protected $fileUploadService;

    public function __construct()
    {
        $this->fileUploadService = new FileUploadService();
    }

    public function getAllPaymentMethod()
    {
        return PaymentMethod::latest()->get();
    }
    public function getAllActivePaymentMethod() {
        return PaymentMethod::where('status', PaymentMethod::ACTIVE)
        ->when(request()->has('money_receiver_wise') && request()->money_receiver_wise == true, function ($query) {
            return $query->has('moneyReceivers');
        })
        ->get();
    }

    public function getPaymentMethodById($id)
    {
        return PaymentMethod::findOrFail($id);
    }

    public function getActivePaymentMethodByShortName($name)
    {
        return PaymentMethod::where('short_name', $name)->where('status', PaymentMethod::ACTIVE)->first();
    }

    public function deletePaymentMethod($id)
    {
        return PaymentMethod::destroy($id);
    }

    public function createPaymentMethod($request)
    {
        $image_name = null;

        if ($request->image) {
            $image_name = $this->fileUploadService->uploadFile($request->image, PaymentMethod::FILE_STORE_PATH, null);
        }

        return $paymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'min' => $request->min,
            'max' => $request->max,
            'surcharge' => $request->surcharge,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'image' => $image_name,
            'status' => $request->status,
        ]);
    }

    public function updatePaymentMethod($payment_method, $request)
    {
        $image_name = null;
        if ($request->image) {
            $image_name = $this->fileUploadService->uploadFile($request->image, PaymentMethod::FILE_STORE_PATH, PaymentMethod::FILE_STORE_PATH . '/' . $payment_method->image);
        }

        if ($request->name) $payment_method->name = $request->name;
        if ($request->short_name) $payment_method->short_name = $request->short_name;
        if ($request->min) $payment_method->min = $request->min;
        if ($request->max) $payment_method->max = $request->max;
        if ($request->surcharge) $payment_method->surcharge = $request->surcharge;
        $payment_method->discount_type = $request->discount_type;
        $payment_method->discount_amount = $request->discount_amount;
        if ($request->image) $payment_method->image = $image_name;
        $payment_method->save();
        return $payment_method;
    }
}
