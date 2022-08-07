<?php

namespace App\Interfaces;

interface MoneyReceiverRepositoryInterface
{
    public function getAllMoneyReceiver();
    public function getMoneyReceiverById($id);
    public function deleteMoneyReceiver($id);
    public function createMoneyReceiver($request);
    public function updateMoneyReceiver($id, $request);
}
