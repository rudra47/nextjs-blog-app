<?php

namespace Database\Factories;

use App\Models\MoneyReceiver;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoneyReveiverFactory extends Factory
{
    protected $model = MoneyReceiver::class;

    public function definition()
    {
        return [
            'payment_method_id' => function(){
                return PaymentMethod::all()->random();
            },
            'first_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'initial_name' => $this->faker->name(),
            'btc_address' => null,
            'payment_category' => function(){
                $paymentCat = array('china','low','high');
                shuffle($paymentCat);
                return $paymentCat[0];
            },
            'country' => $this->faker->country,
            'status' => function(){
                $status = array('ACTIVE',"PENDING");
                shuffle($status);
                return $status[0];
            },
        ];
    }
}
