@extends("layout")


@section('title', "connexion")



@section('body')



            <h1>Page de connexion</h1>



            <form class="w-1/2 mx-auto py-20" action="" method="post">
                @csrf
                <div class="flex flex-col">
                    <label  for="email">Email</label>
                    <input type="email" class="input input-bordered w-full" name="email" id="email" />
                </div>

                <div  class="flex flex-col">
                    <label for="password">Mot de passe</label>
                    <input type="text" class="input input-bordered w-full " name="password" id="password" />
                </div>


                <button class="btn btn-primary my-4">Connexion</button>

            </form>
@endsection
