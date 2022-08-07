<?php

namespace App\Repositories;

use App\Interfaces\PackageProductRepositoryInterface;
use App\Models\PackageProduct;

class PackageProductRepository implements PackageProductRepositoryInterface {

    public function getAllPackageProduct() {
        return PackageProduct::latest()->get();
    }

    public function getPackageProductById($id) {
        return PackageProduct::with('package')->findOrFail($id);
    }

    public function deletePackageProduct($id) {
        return PackageProduct::destroy($id);
    }

    public function createPackageProduct($request) {
        return PackageProduct::create([
            'product_id' => $request->product_id,
            'package_id' => $request->package_id,
            'quantity' => $request->quantity
        ]);
    }

    public function updatePackageProduct($id, $request) {
        $package_product = PackageProduct::findOrFail($id);
        $package_product->product_id = $request->product_id;
        $package_product->quantity = $request->quantity;
        $package_product->save();
        return $package_product;
    }
}
