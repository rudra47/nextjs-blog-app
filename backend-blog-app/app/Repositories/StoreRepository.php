<?php

namespace App\Repositories;

use App\Interfaces\StoreRepositoryInterface;
use App\Models\Store;
use Illuminate\Support\Str;

class StoreRepository implements StoreRepositoryInterface
{
    public function getAllStore() {
        return Store::latest()->get();
    }

    public function getStoreById($id) {
        return Store::findOrFail($id);
    }
    public function getStoreByStoreName($name) {
        return Store::where("name",$name)->first();
    }

    public function deleteStore($id) {
        return Store::destroy($id);
    }

    public function createStore($request) {
        return $store = Store::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    public function updateStore($id, $request) {
        $store = Store::findOrFail($id);
        $store->name = $request->name;
        $store->slug = Str::slug($request->name);
        $store->save();
        return $store;
    }
}
