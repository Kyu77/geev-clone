@extends("layout")


@section('title', "connexion")



@section('body')



            <h1>Page de connexion</h1>



            <form class="w-1/2 mx-auto py-20" action="" method="post">
                @csrf
                <x-input name="email"  label="Email" type="email" value="{{old('email')}}"></x-input>
                <x-input name="password"   label="Mot de passe" type="password" value="{{old('password')}}"></x-input>

                <button type="submit" class="btn btn-primary my-4">Connexion</button>

            </form>
@endsection
