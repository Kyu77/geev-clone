@extends ('layout')
@section('title',"Créer votre produit à donner")

@section('body')

<div class="container">
    <h1 class="text-center">edit votre produit à donner</h1>
    <form class="w-75 mx-auto my-5"  method="post" action="" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <x-input name="title" label="Nom de l'objet" value="{{$product->title}}"/>
    <x-input name="image" label="Image" type="file"/>
    <x-input name="description" label="Description" type="textarea">{{$product->description}}</x-input>


<div style="margin: 0.5rem">
    <select class="select" name="category_id">
        @foreach($categories as $category)
            <option {{$category->id === $product->category_id ? 'selected' : '' }}  value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div style="margin: 0.5rem">
    <select class="select" name="quality_id">
        @foreach($qualities as $quality)
            <option  {{$quality->id === $product->quality_id ? 'selected' : '' }}  value="{{ $quality->id }}">{{ $quality->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <select class="select" name="statut_id">
        @foreach($statuts as $statut)
            <option {{$statut->id === $product->statut_id ? 'selected' : '' }} value="{{ $statut->id }}">{{ $statut->name }}</option>
        @endforeach
    </select>
</div>

<div class="text-center" style="margin: 2rem">
    <button type="submit" class="btn btn-info">modifier votre produit</button>

</div>

</form>
</div>
@endsection
