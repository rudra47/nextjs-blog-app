<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoneyReceiverFactory extends Factory
{
    // protected $model = MoneyReceiver::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_method_id' => function(){
                return PaymentMethod::all()->random();
            },
            // 'payment_method_id'=> 1,
            'first_name' => $this->faker->name(),
            'middle_name' => $this->faker->name(),
            'initial_name' => $this->faker->name(),
            'btc_address' => null,
            'payment_category' => function(){
                $paymentCat = array('china','low','high');
                shuffle($paymentCat);
                return $paymentCat[0];
            },
            // 'payment_category' => 'high',
            'country' => $this->faker->country,
            // 'status' => "ACTIVE"
            'status' => function(){;
                $status = array(PaymentMethod::ACTIVE);
                shuffle($status);
                return $status[0];
            },
        ];
    }
}
