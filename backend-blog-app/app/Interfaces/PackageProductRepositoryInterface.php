<?php

namespace App\Interfaces;

interface PackageProductRepositoryInterface
{
    public function getAllPackageProduct();
    public function getPackageProductById($id);
    public function deletePackageProduct($id);
    public function createPackageProduct($request);
    public function updatePackageProduct($id, $request);
}
