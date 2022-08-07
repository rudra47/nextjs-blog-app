<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\PostageManagement;
use App\Models\Product;
use App\Models\StockManage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Hash;

class UserRepository implements UserRepositoryInterface {

    public function getAllUser() {
        return User::all();
    }

    public function getShippers() {
        return User::where('role_type', User::ROLE_SHIPPER)->get();
    }

    public function getUserById($id) {
        return User::findOrFail($id);
    }

    public function deleteUser($id) {
        return User::destroy($id);
    }

    public function createUser($request, $role_type) {
        DB::beginTransaction();
        $token = random_bytes(8);
        $token = bin2hex($token);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role_type' => $role_type,
            'password'  => Hash::make($request->password),
            'token'     => $token
        ]);

        $products = Product::where('status', Product::STATUS_ACTIVE)->get();

        $stock = [];
        foreach ($products as $key =>$product){
            $stock[$key] = [
                'product_id' => $product->id,
                'shipper_user_id' =>  $user->id,
                'product_name' => $product->name,
            ];
        }

        StockManage::insert($stock);
        PostageManagement::create([
            'shipper_user_id' => $user->id,
            ''
        ]);

        DB::commit();

        return $user;
    }

    public function updateUser($id, $request) {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return $user;
    }
}
