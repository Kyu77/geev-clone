@extends("layout")

@section('title', "Mot de passe oublié")

@section('body')
    <h1>Mot de passe oublié</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="w-1/2 mx-auto py-20" action="{{ route('password.email') }}" method="post">
        @csrf
        <x-input name="email" label="Email" type="email" value="{{ old('email') }}"></x-input>

        <button type="submit" class="btn btn-primary my-4">Envoyer le lien de réinitialisation</button>
    </form>

    <div class="text-center">
        <a href="{{ route('login') }}">Retour à la connexion</a>
    </div>
@endsection
