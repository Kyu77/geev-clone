@extends('layout')

@section('title', 'Détail du produit')

@section('body')

    <div class="text-center">
        <h1 class="text-2xl font-bold my-6">Détail du produit</h1>
    </div>

    <div class="flex justify-center items-center min-h"> 
        {{-- Card centrée --}}
        <div class="card bg-white w-full max-w-sm shadow-lg hover:shadow-xl transition rounded-xl overflow-hidden flex flex-col relative">

            {{-- Image produit --}}
            <figure class="h-56 bg-gray-200">
                @php
                    $img = $product->images;
                @endphp
                <img src="{{ asset('storage/' . $img) }}"
                    alt="{{ $product->title }}"
                    class="w-full h-full object-cover" />
            </figure>

       {{-- Contenu card --}}
      <div class="card-body flex flex-col flex-grow justify-between">

        {{-- Titre + description --}}
<div class="text-center">
    <h2 class="text-lg font-semibold text-gray-900 truncate">
        {{ $product->title }}
    </h2>
    <p class="mt-1 text-sm text-gray-700 line-clamp-3">
        {{ $product->description }}
    </p>
</div>


                {{-- Infos utilisateur / catégorie --}}
                <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                    <span class="font-medium">👤 {{ $product->user->name }}</span>
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

                {{-- Zone centrée : nombre de consultations + boutons --}}
                <div class="mt-6 flex flex-col items-center gap-3">

                    <h2 class="text-sm text-gray-700">
                        Nombre de consultations : {{ $product->view_count }}
                    </h2>

                    @can('update',$product)
                        <a class="btn btn-primary w-32" href="{{ route('product.edit', $product) }}">Modifier</a>
                        <form onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bien ?')"
                            action="{{ route('product.destroy', $product) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-error w-25">Supprimer</button>
                        </form>
                    @endcan

                    <a href="{{ route('home') }}">
                        <button class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 w-25">
                            Retour
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
