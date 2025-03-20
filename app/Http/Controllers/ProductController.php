<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProductRequest;
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
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with('user')->orderBy('created_at', 'desc')->paginate(6);

        return view('welcome', compact('products'));
    }

    public function show(Product $product)
    {
        $product = $product->load('user');
        return view('show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        $qualities = Quality::all();
        $statuts = Statut::all();

        return view('create', compact("categories", "qualities", "statuts"));
    }

    public function store(CreateProductRequest $request)
    {

        $path =  $request->file('image')->store('product', 'public');
        $product =  $request->validated();
        $product['images'] = $path;
        $product['user_id'] = Auth::user()->id;
        Product::query()->create($product);
        return  redirect()->route('home')->with('ok', 'Le produit à bien été ajouté !');
    }


    public function edit(Product $product) {
        $categories = Category::all();
        $qualities = Quality::all();
        $statuts = Statut::all();
        return view('edit', compact('product', 'categories', 'qualities', 'statuts'));
    }


    public function update( UpdateProductRequest  $request, Product $product) {


        $updatedProduct = $request->validated();

        if ($request->hasFile('image')) {
            $path =  $request->file('image')->store('product', 'public');
            $updatedProduct['images'] = $path;
            // supprime lancien image du disk public
            Storage::disk('public')->delete($product->images);
        }


        // update the product in the database
         $product->update($updatedProduct);
        return  redirect()->route('home')->with('ok', 'Le produit à bien été mod');

    }


    public function destroy(Product $product) {
        // supprime lancien image du disk public
        Storage::disk('public')->delete($product->images);
        $product->delete();
        return  redirect()->route('home')->with('ok', 'Le produit à bien été sup');
    }
}
