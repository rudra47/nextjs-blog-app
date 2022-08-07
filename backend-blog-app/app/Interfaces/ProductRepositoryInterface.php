<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getProduct($productType = null);
    public function deleteProduct($id);
    public function createProduct($request);
    public function updateProduct($id, $request);
    public function getProductById($id);
}
