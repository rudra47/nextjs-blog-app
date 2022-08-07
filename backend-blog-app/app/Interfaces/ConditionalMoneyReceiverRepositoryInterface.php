<?php

namespace App\Interfaces;

interface ConditionalMoneyReceiverRepositoryInterface
{
    public function conditionalMoneyReceiverAlive();
    public function getConditionalMoneyReceiverById($id);
    public function createMoneyReceiverCondition($request);
    public function updateMoneyReceiverCondition($id, $request);
}
