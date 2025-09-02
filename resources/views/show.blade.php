@extends('layout')

@section('title', 'Détail du produit')

@section('body')

    <div class="text-center">
        <h1 style="margin:1rem">Détail du produit</h1>

        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                @php
                  $decoded = json_decode($product->images, true);
                  if ($decoded !== null) {
                    if (is_array($decoded)) {
                      $img = $decoded[0];
                    } else {
                      $img = $decoded;
                    }
                  } else {
                    $img = $product->images;
                  }
                @endphp
                <img src="{{ asset('storage/' . $img) }}" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $product->title }}</h2>
                <p>{{ $product->description }}</p>
                <div class="card-actions justify-end" style="justify-content: space-between">
                    <h2> {{ $product->user->name }}</h2>
                    <h2> {{$product->category->name}}</h2>
                   

                    @can('update',$product)
                    <a class="btn btn-primary" href="{{ route('product.edit', $product) }}">Modifier</a>
                    <form onsubmit="return confirm('êtes vous sur de vouloir supprimer ce bien')"
                        action="{{ route('product.destroy', $product) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-error">Supprimer</button>
                    </form>
                    @endcan
                </div> 
                <h2>Nombre de consultations : {{ $product->view_count }}</h2>
                 
                    <a href="{{route('home')}}">
                        <button class="btn">
                    Retour
                </button>
                </a>
                
                
            </div>
        </div>

    </div>
@endsection
