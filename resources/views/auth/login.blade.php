@extends("layout")


@section('title', "connexion")



@section('body')



            <h1>Page de connexion</h1>



            <form class="w-1/2 mx-auto py-20" action="" method="post">
                @csrf
                <x-input name="email"  label="Email" type="email" value="{{old('email')}}"></x-input>
                <div class="relative">
                    <x-input name="password" label="Mot de passe" type="password" value="{{old('password')}}"></x-input>
                    <button type="button" id="togglePasswordLogin" class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center justify-center h-full text-sm cursor-pointer">
                        👁️
                    </button>
                </div>
                

                <button type="submit" class="btn btn-primary my-4">Connexion</button>

            </form>

            <div class="text-center">
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>
@endsection
