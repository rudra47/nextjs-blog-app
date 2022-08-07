<?php

namespace App\Interfaces;

interface OrderManagementRepositoryInterface
{
    public function getAllOrder($request);
    public function getOrderById($id);
    public function getOrderByOrderNo($order_no);
    public function orderDetails($id);
    public function assignShipper($request, $order_id);
    public function reAssignShipper($request, $order_id);
    public function freeBio($request, $order_id);
    public function deleteProduct($sell_id, $order_id);
}
