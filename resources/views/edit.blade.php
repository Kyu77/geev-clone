@extends('layout')
@section('title',"Modifier votre produit")

@section('body')

<div class="container">
    <h1 class="text-center text-2xl font-bold my-6">Modifier votre produit</h1>
    <form class="w-75 mx-auto my-5" method="post" action="" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <x-input name="title" label="Nom de l'objet" value="{{ $product->title }}" />
        <x-input name="image" label="Image" type="file" />
        <x-input name="description" label="Description" type="textarea">{{ $product->description }}</x-input>

        <div class="my-2">
            <select class="select" name="category_id">
                @foreach($categories as $category)
                    <option {{ $category->id === $product->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="my-2">
            <select class="select" name="quality_id">
                @foreach($qualities as $quality)
                    <option {{ $quality->id === $product->quality_id ? 'selected' : '' }} value="{{ $quality->id }}">{{ $quality->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="my-2">
            <select class="select" name="statut_id">
                @foreach($statuts as $statut)
                    <option {{ $statut->id === $product->statut_id ? 'selected' : '' }} value="{{ $statut->id }}">{{ $statut->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Latitude / Longitude --}}
        <div class="my-2">
            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
            <input type="text" name="latitude" id="latitude" value="{{ $product->latitude }}" class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="my-2">
            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
            <input type="text" name="longitude" id="longitude" value="{{ $product->longitude }}" class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-info px-4 py-2 rounded-lg">Modifier le produit</button>
        </div>
    </form>
</div>

@endsection
