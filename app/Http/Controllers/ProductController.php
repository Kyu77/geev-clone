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
        $statuts = Statut::all();
        $qualities = Quality::all();
        $categoryIds = $request->query('category', []);
        if (!is_array($categoryIds)) $categoryIds = $categoryIds ? [$categoryIds] : [];
        $statutIds = $request->query('statut', []);
        if (!is_array($statutIds)) $statutIds = $statutIds ? [$statutIds] : [];
        $qualityIds = $request->query('quality', []);
        if (!is_array($qualityIds)) $qualityIds = $qualityIds ? [$qualityIds] : [];
        $search = $request->query('search', '');

        $userLat = $request->query('user_lat');
        $userLng = $request->query('user_lng');
        $radius = $request->query('radius', 10); // Default 10 km

        $products = Product::query()
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                return $query->whereIn('category_id', $categoryIds);
            })
            ->when(!empty($statutIds), function ($query) use ($statutIds) {
                return $query->whereIn('statut_id', $statutIds);
            })
            ->when(!empty($qualityIds), function ($query) use ($qualityIds) {
                return $query->whereIn('quality_id', $qualityIds);
            })
            ->when($userLat && $userLng && $radius, function ($query) use ($userLat, $userLng, $radius) {
                return $query->nearLocation($userLat, $userLng, $radius);
            })
            ->with(['user', 'category', 'statut', 'quality'])
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Filter by distance if location params are provided
        if ($userLat && $userLng && $radius) {
            $products->getCollection()->transform(function ($product) use ($userLat, $userLng, $radius) {
                if ($product->latitude && $product->longitude) {
                    $distance = $product->getDistance($userLat, $userLng, $product->latitude, $product->longitude);
                    $product->distance = $distance;
                    return $distance <= $radius ? $product : null;
                }
                return null;
            })->filter(); // Remove nulls
        }

        // Fix statut attribute to be the related Statut object, not string
        foreach ($products as $product) {
            if (is_string($product->statut)) {
                $product->statut = $product->statut()->first();
            }
        }

        $userCount = User::count();

        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => $products->links()->toHtml(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]);
        }

        return view('welcome', compact('products','categories', 'categoryIds', 'userCount', 'statuts', 'statutIds', 'qualities', 'qualityIds', 'search', 'userLat', 'userLng', 'radius'));
    }

    public function show(Product $product)
    {
        $product->increment('view_count');
        $product = $product->load('user', 'category', 'statut', 'quality');

        // Fix statut attribute to be the related Statut object, not string
        if (is_string($product->statut)) {
            $product->statut = $product->statut()->first();
        }

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
        $product = $request->validated();
        $product['user_id'] = Auth::id();
        $product['images'] = $path ?? null;

        // Handle location: store the location_search value in the location field
        if ($request->has('location_search')) {
            $product['location'] = $request->input('location_search');
        }

        Product::create($product);

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

       // Handle location: store the location_search value in the location field
       if ($request->has('location_search')) {
           $updatedProduct['location'] = $request->input('location_search');
       }

    if ($request->hasFile('image')) {
        $path =  $request->file('image')->store('product', 'public');
        Storage::disk('public')->delete($product->images);
        $updatedProduct['images'] = $path;
    }

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
