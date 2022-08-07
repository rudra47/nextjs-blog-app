<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppAuthController
{
    public function login()
    {
        return view('auth.app.login');
    }

    public function loginAction(Request $request)
    {
        $request->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
//        dd(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember')));
        if (Auth::guard()->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/app/dashboard');
        }
//        $this->guard()->attempt(
//            $this->credentials($request), $request->boolean('remember')
        return redirect()->route('app.login');
    }

    public function logout()
    {
        if(Auth::guard('admin')->check()) // this means that the admin was logged in.
        {
            Auth::guard('admin')->logout();
            return redirect()->route('app.login');
        }
    }
}
