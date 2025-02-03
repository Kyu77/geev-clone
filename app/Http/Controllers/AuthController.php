<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view("auth.login");
    }


    public function login(LoginRequest  $request) {
       $registered = Auth::attempt($request->validated());
       if($registered){
        session()->regenerate();
       }
        return redirect()->route('home')->with('ok','Vous etes bien connecté !');
    }


    public function showRegister() {
        return view("auth.register");
    }

    public function register(RegisterRequest $request) {
        User::query()->create($request->validated());
        return redirect()->route('login')->with('ok','Vous etes bien inscrit !');


    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home')->with('ok','Vous etes bien déconnecté !');
    }
}
