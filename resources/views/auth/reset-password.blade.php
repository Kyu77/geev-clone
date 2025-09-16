@extends("layout")

@section('title', "Réinitialiser le mot de passe")

@section('body')
    <h1>Réinitialiser le mot de passe</h1>

    <form class="w-1/2 mx-auto py-20" action="{{ route('password.update') }}" method="post">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-input name="email" label="Email" type="email" value="{{ old('email', $request->email) }}"></x-input>
        <x-input name="password" label="Nouveau mot de passe" type="password"></x-input>
        <x-input name="password_confirmation" label="Confirmer le mot de passe" type="password"></x-input>

        <button type="submit" class="btn btn-primary my-4">Réinitialiser le mot de passe</button>
    </form>

    <div class="text-center">
        <a href="{{ route('login') }}">Retour à la connexion</a>
    </div>
@endsection
