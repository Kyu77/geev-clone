@extends("layout")

@section("title", "Détail du produit")


@section("body")


<div class="text-center">
<h1 style="margin:1rem">Détail du produit</h1>




<div class="card bg-base-100 w-96 shadow-sm">
    <figure>
      <img
        src="/storage/{{$product->images}}"  />
    </figure>
    <div class="card-body">
      <h2 class="card-title">{{$product->title}}</h2>
      <p>{{$product->description}}</p>
      <div class="card-actions justify-end" style="justify-content: space-between">
         <h2> {{$product->user->name}}</h2>
        <a class="btn btn-primary" href="{{route('product.edit',$product)}}" >Modifier</a>
        <form onsubmit="return confirm('etes vous sur de vouloir supprimer ce bien')" action="{{route('product.destroy', $product )}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Supprimer</button>

        </form>
      </div>
    </div>
    </div>



</div>
@endsection

