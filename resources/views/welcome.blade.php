@extends("layout")

@section("title", "home")


@section("body")


<div class="text-center">
<h1 style="margin:1rem">Page d'accueil</h1>

<div class="dropdown dropdown-center">
    <div tabindex="0" role="button" class="btn m-1">Catégories</div>
    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5">
        <li><a href="{{ $products }}">Toutes les catégories</a></li>
        @foreach($categories as $category)
            <li>
                <a href="{{ $products, ['category' => $category->id] }}"
                   class="{{ request('category') == $category->id ? 'font-bold' : '' }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

  <div class="dropdown dropdown-center">
    <div tabindex="0" role="button" class="btn m-1">Catégories</div>
    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5">
      <li><a>Item gre</a></li>
      <li><a>Item 2</a></li>
    </ul>
  </div>

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

