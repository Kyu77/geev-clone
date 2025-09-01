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
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\Response;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::withCount('products')->get();
        $categoryId = $request->query('category');

        $products = Product::query()
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $userCount = User::count();

        return view('welcome', compact('products','categories', 'categoryId', 'userCount'));
    }

    public function show(Product $product)
    {
        $product->increment('view_count');
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


    public function edit(Request $request, Product $product) {

        if ($request->user()->cannot('update', $product)) {
            abort(403);
        }

        $categories = Category::all();
        $qualities = Quality::all();
        $statuts = Statut::all();
        return view('edit', compact('product', 'categories', 'qualities', 'statuts'));
    }


    public function update( UpdateProductRequest  $request, Product $product) {


        if ($request->user()->cannot('update', $product)) {
            abort(403);
        }

        $updatedProduct = $request->validated();

        if ($request->hasFile('image')) {
            $path =  $request->file('image')->store('product', 'public');
            $updatedProduct['images'] = $path;
            // supprime lancien image du disk public
            Storage::disk('public')->delete($product->images);
        }


        // update the product in the database
         $product->update($updatedProduct);
        return  redirect()->route('home')->with('ok', 'Le produit à bien été modifié');

    }


    public function destroy(Request $request, Product $product) {

        if ($request->user()->cannot('delete', $product)) {
            abort(403);
        }

        // supprime lancien image du disk public
        Storage::disk('public')->delete($product->images);
        $product->delete();
        return  redirect()->route('home')->with('ok', 'Le produit à bien été sup');
    }
}
