@extends("layout")


@section('title', "Inscription")



@section('body')


<div class="container">
            <h1 class="text-center">Page inscription</h1>


            <form class="w-1/2 mx-auto py-20" action="" method="post">
                @csrf
                   <x-input name="name" label="Nom d'utilisateur" value="{{old('name')}}"/>
                   <x-input name="email" label="Adresse email" type="email" value="{{old('email')}}"/>
                   <x-input name="password" label="Mot de passe" type="password" value="{{old('password')}}"/>

                <button type="submit" class="btn btn-primary my-4">Inscription</button>

            </form>
        </div>
@endsection
