<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_methods = [
            0 => [
                'name' => 'Bit Coin(BTC)',
                'short_name' => 'btc'
            ],
            1 => [
                'name' => 'Visa/Master',
                'short_name' => 'visa'
            ],
            2 => [
                'name' => 'Western Union',
                'short_name' => 'wu'
            ],
            3 => [
                'name' => 'Money Gram',
                'short_name' => 'mg'
            ],
            4 => [
                'name' => 'Amex Gift Card',
                'short_name' => 'amex'
            ],
            5 => [
                'name' => 'Abra',
                'short_name' => 'abra'
            ],
            6 => [
                'name' => 'Cash In Mail',
                'short_name' => 'cim'
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($payment_methods as $key => $payment_method) {
            \App\Models\PaymentMethod::create([
                'name' => $payment_method['name'],
                'short_name' => $payment_method['short_name'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
