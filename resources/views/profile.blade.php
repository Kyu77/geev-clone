@extends('layout')

@section('title', 'Profil')

@section('body')
<div class="card card-side bg-base-100 shadow-sm">
  <figure>
    <img
      src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.webp"
      alt="Movie" />
  </figure>
  <div class="card-body">
    <h2 class="card-title">{{ auth()->user()->name }}</h2>
    <p>{{ auth()->user()->email }}</p>
    <div class="card-actions justify-end">
      <button class="btn btn-primary">Modifier</button>
    </div>
  </div>
</div>

<div class="mt-8">
  <h3 class="text-xl font-bold mb-4">Mes Produits</h3>
  @if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($products as $product)
        <div class="card bg-white shadow-lg hover:shadow-xl transition rounded-xl overflow-hidden flex flex-col">
          <figure class="h-48 bg-gray-200">
            @php
              $img = $product->images;
            @endphp
            <img src="{{ asset('storage/' . $img) }}"
              alt="{{ $product->title }}"
              class="w-full h-full object-cover" />
          </figure>
          <div class="card-body flex flex-col flex-grow justify-between">
            <div class="text-center">
              <h2 class="text-lg font-semibold text-gray-900 truncate">
                {{ $product->title }}
              </h2>
              <p class="mt-1 text-sm text-gray-700 line-clamp-3">
                {{ $product->description }}
              </p>
            </div>
            <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
              <span class="italic text-gray-500">🏷️ {{ $product->category->name }}</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <span class="text-sm font-semibold text-indigo-600">
                ⭐ {{ $product->quality->name }}
              </span>
              <span class="text-sm font-semibold text-indigo-600">
                {{ is_object($product->statut) && $product->statut->name == 'Disponible' ? '🟢' : '🔴' }}
              </span>
            </div>
            <div class="mt-6 flex flex-col items-center gap-3">
              <h2 class="text-sm text-gray-700">
                Consultations : {{ $product->view_count }}
              </h2>
              <a class="btn btn-primary w-32" href="{{ route('product.show', $product) }}">Voir</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-gray-500">Aucun produit publié pour le moment.</p>
  @endif
</div>
@endsection
