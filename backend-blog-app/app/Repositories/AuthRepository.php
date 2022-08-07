<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use App\Models\TicketDiscussion;
use Illuminate\Support\Str;
use Auth;
use Hash;

class AuthRepository implements AuthRepositoryInterface {

    public function emailExistence($email)
    {
        return User::where('email', $email)->count();
    }

    public function verifyUser($token)
    {
        return User::where('token', $token)->update([
            'email_verified_at' => now()
        ]);
    }

    public function registrationStore($request) {
        $token = random_bytes(8);
        $token = bin2hex($token);

        return User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'shop_name'     => $request->shop_name,
            'shop_domain'   => $request->shop_domain,
            'password'      => Hash::make($request->password),
            'token'         => $token
        ]);
    }
}
