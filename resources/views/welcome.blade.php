@extends("layout")

@section("title", "home")


@section("body")


<div class="text-center">
<h1 style="margin:1rem">Page d'accueil</h1>
<!--
<p>Total utilisateurs enregistrés : {{$userCount}}</p>
-->
<!-- Filtre Catégories-->
<div class="dropdown dropdown-center">
    @php
        $selectedCategories = !empty($categoryIds) ? $categories->whereIn('id', $categoryIds)->pluck('name')->toArray() : [];
        $buttonTextCategories = !empty($selectedCategories) ? 'Catégories: ' . implode(', ', $selectedCategories) : '🏷️Catégories';
    @endphp
    <div tabindex="0" role="button" class="btn m-1">{{ $buttonTextCategories }}</div>
    <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
        <form method="GET" action="{{ route('home') }}">
            @foreach($statutIds as $id)
                <input type="hidden" name="statut[]" value="{{ $id }}">
            @endforeach
            @foreach($qualityIds as $id)
                <input type="hidden" name="quality[]" value="{{ $id }}">
            @endforeach
            @foreach($categories as $category)
                <label class="label cursor-pointer">
                    <span class="label-text">{{ $category->name }}</span>
                    <input type="checkbox" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $categoryIds) ? 'checked' : '' }} class="checkbox">
                </label>
            @endforeach
            <button type="submit" class="btn btn-sm mt-2">Filtrer</button>
        </form>
    </div>
</div>
<!-- Filtre Disponibilités-->
<div class="dropdown dropdown-center">
    @php
        $selectedStatuts = !empty($statutIds) ? $statuts->whereIn('id', $statutIds)->pluck('name')->toArray() : [];
        $buttonTextStatuts = !empty($selectedStatuts) ? 'Disponibilités: ' . implode(', ', $selectedStatuts) : '🟢/🔴Disponibilités';
    @endphp
    <div tabindex="0" role="button" class="btn m-1">{{ $buttonTextStatuts }}</div>
    <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
        <form method="GET" action="{{ route('home') }}">
            @foreach($categoryIds as $id)
                <input type="hidden" name="category[]" value="{{ $id }}">
            @endforeach
            @foreach($qualityIds as $id)
                <input type="hidden" name="quality[]" value="{{ $id }}">
            @endforeach
            @foreach($statuts as $statut)
                <label class="label cursor-pointer">
                    <span class="label-text">{{ $statut->name }}</span>
                    <input type="checkbox" name="statut[]" value="{{ $statut->id }}" {{ in_array($statut->id, $statutIds) ? 'checked' : '' }} class="checkbox">
                </label>
            @endforeach
            <button type="submit" class="btn btn-sm mt-2">Filtrer</button>
        </form>
    </div>
</div>
<!-- Filtre Qualités-->
<div class="dropdown dropdown-center">
    @php
        $selectedQualities = !empty($qualityIds) ? $qualities->whereIn('id', $qualityIds)->pluck('name')->toArray() : [];
        $buttonTextQualities = !empty($selectedQualities) ? 'Qualités: ' . implode(', ', $selectedQualities) : '⭐Qualités';
    @endphp
    <div tabindex="0" role="button" class="btn m-1">{{ $buttonTextQualities }}</div>
    <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
        <form method="GET" action="{{ route('home') }}">
            @foreach($categoryIds as $id)
                <input type="hidden" name="category[]" value="{{ $id }}">
            @endforeach
            @foreach($statutIds as $id)
                <input type="hidden" name="statut[]" value="{{ $id }}">
            @endforeach
            @foreach($qualities as $quality)
                <label class="label cursor-pointer">
                    <span class="label-text">{{ $quality->name }}</span>
                    <input type="checkbox" name="quality[]" value="{{ $quality->id }}" {{ in_array($quality->id, $qualityIds) ? 'checked' : '' }} class="checkbox">
                </label>
            @endforeach
            <button type="submit" class="btn btn-sm mt-2">Filtrer</button>
        </form>
    </div>
</div>
<!--
<table class="table-auto w-full mt-6">
    <thead>
        <tr>
            <th class="border px-4 py-2">Nom de la catégorie</th>
            <th class="border px-4 py-2">Nombre de produits</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td class="border px-4 py-2">{{ $category->name }}</td>
            <td class="border px-4 py-2">{{ $category->products_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

-->

<ul class="flex flex-wrap" style="justify-content: center;">

<ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @foreach ($products as $product)
  <li>
    <div class="card bg-white w-full max-w-sm h-full shadow-lg hover:shadow-xl transition rounded-xl overflow-hidden flex flex-col">

      {{-- Image produit (fixée à la même hauteur pour tous) --}}
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
        <div>
          <h2 class="text-lg font-semibold text-gray-900 truncate">
            {{ $product->title }}
          </h2>
          <p class="mt-1 text-sm text-gray-700 line-clamp-3">
            {{ $product->description }}
          </p>
        </div>

        {{-- Infos utilisateur / catégorie --}}
        <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
          <span class="font-medium">👤{{ $product->user->name }}</span>
          <span class="italic text-gray-500">🏷️{{ $product->category->name }}</span>
        </div>

        {{-- Bloc qualité + bouton action alignés en bas --}}
        <div class="mt-4 flex items-center justify-between">
          <span class="text-sm font-semibold text-indigo-600">
           ⭐{{ $product->quality->name }}
          </span>
          
          <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-primary">
            Voir plus
          </a>
        </div>
      </div>
    </div>
  </li>
  @endforeach
</ul>







</ul>
{{$products->links()}}
</div>
@endsection
