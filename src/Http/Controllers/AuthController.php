<?php

namespace Custome\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Custome\Auth\Http\Requests\LoginRequest;
use Illuminate\Contracts\Auth\StatefulGuard;

class AuthController extends Controller 
{

    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
        
    }

    public function show(){
        return view('auth::auth.login');
    } 

    public function login(LoginRequest $request){  
        $credentials = $request->only('email', 'password');
        
        if ($this->guard->attempt(
            $credentials)
        ) {
            $request->session()->regenerate();

            return redirect()->intended('home')
            ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function destroy(Request $request){

        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('login');
    }

}