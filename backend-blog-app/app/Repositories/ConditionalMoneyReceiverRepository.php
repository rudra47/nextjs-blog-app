<?php

namespace App\Repositories;

use App\Interfaces\ConditionalMoneyReceiverRepositoryInterface;
use App\Models\ConditionalMoneyReceiver;
use Carbon\Carbon;

class ConditionalMoneyReceiverRepository implements ConditionalMoneyReceiverRepositoryInterface
{

    public function conditionalMoneyReceiverAlive()
    {

        $conditionally_money_receivers = ConditionalMoneyReceiver::where('status', ConditionalMoneyReceiver::DEACTIVE)->latest()->get();
        foreach ($conditionally_money_receivers as $conditionally_money_receiver) {
            $current_datetime = strtotime(Carbon::now());
            $mny_expire_date = strtotime(Carbon::parse($conditionally_money_receiver->expire_date));
            // if($conditionally_money_receiver->expire_date < Carbon::now()->format('Y-m-d') ) {
            if ($mny_expire_date < $current_datetime) {
                $conditionally_money_receiver->expire_date = Carbon::now()->addDays($conditionally_money_receiver->days);
                $conditionally_money_receiver->status = ConditionalMoneyReceiver::ACTIVE;
                $conditionally_money_receiver->count = 0;
                $conditionally_money_receiver->save();
            }
        }
    }

    public function getConditionalMoneyReceiverById($id)
    {
        return ConditionalMoneyReceiver::find($id);
    }

    public function getConditionalMoneyReceiverByMoneyReceiverId($money_receiver_id)
    {
        return ConditionalMoneyReceiver::where('money_receiver_id', $money_receiver_id)->first();
    }

    public function createMoneyReceiverCondition($request)
    {
        return ConditionalMoneyReceiver::create([
            'money_receiver_id' => $request->money_receiver_id,
            'days' => $request->days,
            'use_limit' => $request->use_limit,
            'status' => $request->status,
        ]);
    }

    public function updateMoneyReceiverCondition($id, $request)
    {
        $moneyReceiver = ConditionalMoneyReceiver::findOrFail($id);
        $moneyReceiver->money_receiver_id = $request->money_receiver_id;
        $moneyReceiver->days = $request->days;
        $moneyReceiver->use_limit = $request->use_limit;
        $moneyReceiver->status = $request->status;
        $moneyReceiver->save();

        return $moneyReceiver;
    }
}
