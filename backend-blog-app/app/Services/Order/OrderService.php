<?php
namespace App\Services\Order;

use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderService{

    public function orderNumberAutoGenerate(){
        return Carbon::now()->format('s').Carbon::now()->format('m').Str::random(6);
    }
}
