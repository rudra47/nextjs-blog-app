<?php

namespace App\Interfaces;

interface PaymentMethodRepositoryInterface
{
    public function getAllPaymentMethod();
    public function getAllActivePaymentMethod();
    public function deletePaymentMethod($id);
    public function createPaymentMethod($request);
    public function updatePaymentMethod($id, $request);
    public function getActivePaymentMethodByShortName($name);
    public function getPaymentMethodById($id);
}
