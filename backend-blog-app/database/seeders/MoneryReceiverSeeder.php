<?php

namespace Database\Seeders;

use App\Models\MoneyReceiver;
use Illuminate\Database\Seeder;

class MoneryReceiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MoneyReceiver::factory()->count(30)->create();
    }
}
