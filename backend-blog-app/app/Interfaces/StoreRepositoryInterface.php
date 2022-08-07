<?php

namespace App\Interfaces;

interface StoreRepositoryInterface
{
    public function getAllStore();
    public function getStoreById($id);
    public function deleteStore($id);
    public function createStore($request);
    public function updateStore($id, $request);
    public function getStoreByStoreName($name);
}
