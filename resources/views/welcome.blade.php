@extends("layout")

@section("title", "home")


@section("body")


<div class="text-center">
<h1 style="margin:1rem">Page d'accueil</h1>

<p>Total utilisateurs enregistrés : {{$userCount}}</p>

<div class="dropdown dropdown-center">
    <div tabindex="0" role="button" class="btn m-1">Catégories</div>
    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5">
        <li><a href="{{ route('home') }}">Toutes les catégories</a></li>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('home', ['category' => $category->id]) }}"
                   class="{{ request('category') == $category->id ? 'font-bold' : '' }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

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



<ul class="flex flex-wrap" style="justify-content: center;">

    @foreach ($products as $product )
<li style="margin:0.5rem">
<div class="card bg-base-100 w-96 shadow-sm">
    <figure>
      <img style=" max-width: 250px;  min-width: 250px;   w   "
        src="storage/{{$product->images}}"  />
    </figure>
    <div class="card-body">
      <h2 class="card-title">{{$product->title}}</h2>
      <p>{{$product->description}}</p>
      <div class="card-actions justify-end" style="justify-content: space-between">
         <h2> {{$product->user->name}}</h2>
         <h2> {{$product->category->name}}</h2>

        <a class="btn btn-primary" href="{{route('product.show',$product)}}" >Voir plus</a>
      </div>
    </div>
    </div>
</li>
    @endforeach
</ul>
{{$products->links()}}
</div>
@endsection

