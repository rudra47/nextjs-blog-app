<?php

namespace App\Repositories;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\Ticket;
use App\Models\UserInfo;
use Illuminate\Support\Str;
use Auth;

class ProfileRepository implements ProfileRepositoryInterface {
    public function getUserInfoById($user_id) {
        return UserInfo::where('user_id', $user_id)->first();
    }
    
    public function storeShippingDetails($request, $user_id) {
        return UserInfo::create([
            'user_id'                => $user_id,
            'first_name'             => $request->first_name,
            'last_name'              => $request->last_name,
            'company'                => $request->company,
            'address'                => $request->address,
            'apt'                    => $request->apt,
            'city'                   => $request->city,
            'state'                  => $request->state,
            'zip_code'               => $request->zip_code,
            'email'                  => $request->email,
            'board_id'               => $request->board_id,
            'additional_information' => $request->additional_information,
            'status'                 => UserInfo::STATUS_ACTIVE
        ]);
    }
}
