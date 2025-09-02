<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $products = $user->products()->with(['category', 'quality', 'statut'])->get();
        return view('profile', compact('products'));
    }
}
