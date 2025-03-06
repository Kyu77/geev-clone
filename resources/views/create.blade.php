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


<div style="margin: 0.5rem">
    <select class="select" name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div style="margin: 0.5rem">
    <select class="select" name="quality_id">
        @foreach($qualities as $quality)
            <option value="{{ $quality->id }}">{{ $quality->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <select class="select" name="statut_id">
        @foreach($statuts as $statut)
            <option value="{{ $statut->id }}">{{ $statut->name }}</option>
        @endforeach
    </select>
</div>

<div class="text-center" style="margin: 2rem">
    <button type="submit" class="btn btn-info">Créer votre produit</button>
    
</div>

</form>
</div>
@endsection
