<?php

namespace App\Interfaces;

interface PackageRepositoryInterface
{
    public function getAllPackage($home_page = false);
    public function deletePackage($id);
    public function createPackage($request);
    public function updatePackage($id, $request);
}
 
