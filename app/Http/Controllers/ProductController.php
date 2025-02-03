<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        return view("home");
    }

    public function create(){
        return view('create');
    }

    public function store(CreateProductRequest $request){
        $path =  $request->file('images')->store('product','public');
        $product =  $request->validated();
        $product['images'] = $path;
        $product['user_id'] = Auth::user()->id;
        Product::query()->create($product);
        return redirect()->route('home')->with('ok', 'Le produit à bien été ajouté !');
}
}
