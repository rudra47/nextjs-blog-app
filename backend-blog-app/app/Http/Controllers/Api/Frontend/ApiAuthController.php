<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\AuthRepositoryInterface;
use Auth;
use App\Models\User;

class ApiAuthController extends Controller
{
    private $authRepository;
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function emailExistence($email)
    {
        return $this->authRepository->emailExistence($email);
    }

    public function registrationStore(Request $request)
    {
        $user = $this->authRepository->registrationStore($request);
        $token = $user->createToken('auth_token')->plainTextToken;
    
        $data = [
            'name'          => $request->name,
            'email'         => $request->email,
            'token'         => $user->token,
            'shop_name'     => $request->shop_name,
            'shop_domain'   => $request->shop_domain,
            'created_at'    => $user->created_at->format('H:ia d M, Y'),
        ];

        \Mail::to($request->email)->send(new \App\Mail\RegistrationConfirmation($data));

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function accountVarification($token)
    {
        return $this->authRepository->verifyUser($token);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password', 'shop_name'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
