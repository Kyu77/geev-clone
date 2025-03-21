@extends("layout")

@section("title", "home")


@section("body")


<div class="text-center">
<h1 style="margin:1rem">Page d'accueil</h1>
<ul class="flex flex-wrap" style="justify-content: center;">
    @foreach ($products as $product )
<li style="margin:0.5rem">
<div class="card bg-base-100 w-96 shadow-sm">
    <figure>
      <img
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

