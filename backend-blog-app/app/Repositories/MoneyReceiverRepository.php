<?php

namespace App\Repositories;

use App\Interfaces\MoneyReceiverRepositoryInterface;
use App\Models\MoneyReceiver;
use Illuminate\Support\Str;

class  MoneyReceiverRepository implements MoneyReceiverRepositoryInterface
{
    public function getAllMoneyReceiver() {
        return MoneyReceiver::with(['paymentMethod'])->latest()->get();
    }

    public function getMoneyReceiverById($id) {
        return MoneyReceiver::findOrFail($id);
    }

    public function deleteMoneyReceiver($id) {
        return MoneyReceiver::destroy($id);
    }

    public function createMoneyReceiver($request) {
        return MoneyReceiver::create([
            'first_name'        => $request->first_name,
            'middle_name'       => $request->middle_name,
            'initial_name'      => $request->initial_name,
            'country'           => $request->country,
            'btc_address'       => $request->btc_address,
            'payment_category'  => $request->payment_category,
            'payment_method_id' => $request->payment_method_id,
        ]);
    }

    public function updateMoneyReceiver($id, $request) {
        $moneyReceiver = MoneyReceiver::findOrFail($id);
        $moneyReceiver->name = $request->name;
        $moneyReceiver->slug = Str::slug($request->name);
        $moneyReceiver->save();
        return $moneyReceiver;
    }
}
