@extends ('layout')
@section('title',"Créer votre produit à donner")

@section('body')

<div class="container">
    <h1 class="text-center">Créer votre produit à donner</h1>
    <form class="w-75 mx-auto my-5"  method="post" action="" enctype="multipart/form-data">
    @csrf
    <x-input name="title" label="Nom de l'objet" value="{{old('title')}}"/>
    <x-input name="image" label="Image" type="file"  value="{{old('image')}}"/>
    <x-input name="description" label="Description" type="textarea" value="{{old('description')}}"/>

    <button class="btn btn-info">Créer</button>


</form>
</div>
@endsection
