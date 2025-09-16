<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

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

    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Un lien de réinitialisation a été envoyé à votre email.'])
            : back()->withErrors(['email' => 'Impossible d\'envoyer le lien de réinitialisation.']);
    }

    public function showResetForm(Request $request, $token = null) {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
