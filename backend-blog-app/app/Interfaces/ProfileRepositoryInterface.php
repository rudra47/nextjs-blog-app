<?php

namespace App\Interfaces;

interface ProfileRepositoryInterface
{
    public function getUserInfoById($id);
    public function storeShippingDetails($request, $id);
    
}
