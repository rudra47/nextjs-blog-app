<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function orderStore($request);
    public function showOrderById($id);

}
