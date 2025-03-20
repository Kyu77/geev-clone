<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\Statut;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Post;

class ProductController extends Controller
{
    public function index() {
      $products = Product::query()->with('user')->orderBy('created_at','desc')->paginate(6);

      return view('welcome', compact('products'));
    }

    public function show(Product $product){
        $product = $product->load('user');
        return view('show', compact('product'));

    }

    public function create(){
        $categories = Category::all();
        $qualities = Quality::all();
        $statuts = Statut::all();

        return view('create',compact("categories", "qualities", "statuts"));

    }

    public function store(CreateProductRequest $request){

        $path =  $request->file('image')->store('product','public');
        $product =  $request->validated();
        $product['images'] = $path;
        $product['user_id'] = Auth::user()->id;
        Product::query()->create($product);
        return  redirect()->route('home')->with('ok', 'Le produit à bien été ajouté !');


}
}
