<?php

namespace App\Repositories;

use App\Interfaces\PackageRepositoryInterface;
use App\Models\Package;
use App\Services\Utils\FileUploadService;
use Illuminate\Support\Str;

class PackageRepository implements PackageRepositoryInterface {

    private $fileService;

    public  function  __construct(FileUploadService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getAllPackage($home_page=false) {
        $package = Package::with(['offers'=>function($query){
            $query->where('status','active');
        }])->latest();
        if ($home_page){
            return $package->take(4)->get();
        }
        return $package->get();

    }

    public function deletePackage($package) {
        $package->delete();
        if ($package->image) {
            try {
                $this->fileService->delete(Package::FILE_STORE_PATH.'/'.$package->image);
            }catch (\Exception $e) {}
        }
    }

    public function createPackage($request) {
        $package = $request->except('_token');
        $package['slug'] = Str::slug($package['name']);
        if ($request->image) {
            try {
                $this->fileService->delete(Package::FILE_STORE_PATH.'/'.$package['image']);
            }catch (\Exception $e) {}
            $package['image'] = $this->fileService->uploadFile($request->file('image'), Package::FILE_STORE_PATH, null);
        }
        Package::insert($package);
    }

    public function updatePackage($package, $request) {
        if($request->name) $package->name = $request->name;
        if($request->message) $package->message = $request->message;
        if($request->price) $package->price = $request->price;
        if($request->regular_price) $package->regular_price = $request->regular_price;
        if($request->image) {
            try {
                $this->fileService->delete(Package::FILE_STORE_PATH.'/'.$package->image);
            }catch (\Exception $e) {}
            $package->image= $this->fileService->uploadFile($request->file('image'), Package::FILE_STORE_PATH, null);
        }else{
            $package->image = $package->image;
        }
        $package->save();
        return $package;
    }
    public function getSinglePackageById($id){
        return  Package::find($id);
    }
}
