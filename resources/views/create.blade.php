@extends('layout')

@section('title', "Créer votre produit à donner")

@section('body')

    {{-- Titre de la page --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold my-6">Créer votre produit à donner</h1>
    </div>

    {{-- Card centrée --}}
    <div class="flex justify-center items-center min-h ">
        <div class="bg-white w-full max-w-lg shadow-lg rounded-xl p-6">

            <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Nom de l'objet --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Nom de l'objet</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500"
                           required>
                </div>

                {{-- Image --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image"
                           class="mt-1 w-full border rounded-lg p-2 cursor-pointer focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500"
                              required>{{ old('description') }}</textarea>
                </div>

                {{-- Catégorie --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="category_id" id="category_id"
                            class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500"
                            required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Qualité --}}
                <div>
                    <label for="quality_id" class="block text-sm font-medium text-gray-700">Qualité</label>
                    <select name="quality_id" id="quality_id"
                            class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500"
                            required>
                        @foreach($qualities as $quality)
                            <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Statut --}}
                <div>
                    <label for="statut_id" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut_id" id="statut_id"
                            class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500"
                            required>
                        @foreach($statuts as $statut)
                            <option value="{{ $statut->id }}">{{ $statut->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Boutons --}}
                <div class="flex flex-col items-center gap-3 pt-4">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg w-40">
                        Créer le produit
                    </button>

                    <a href="{{ route('home') }}" onclick="return isFormEmpty()">
                        <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg w-35">
                            Retour
                        </button>
                    </a>
                </div>


            </form>
        </div>
    </div>

@endsection
