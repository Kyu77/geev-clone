<div class="navbar bg-base-100">
    <div class="flex-1">
      <a href="{{route('home')}}" class="btn btn-ghost text-xl">Geev</a>
    </div>
    <div class="flex-none">
      <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img
              alt="Tailwind CSS Navbar component"
              src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
          </div>
        </div>
        <ul
          tabindex="0"
          class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            @guest
                    <li><a href="{{route('register')}}">Inscription</a></li>
                    <li><a href="{{route('login')}}">Connexion</a></li>
            @endguest
            @auth
                            <li><a>Profil</a></li>

                <form action="{{route('auth.logout')}}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-info">Deconnexion</button>
                </form>
            @endauth

        </ul>
      </div>
    </div>
  </div>

  @auth
      <div class="d-flex align-items-center justify-content-between">
      <a href="{{route('product.create')}}" class="btn btn-warning">Donner un objet</a>
    </div>
@endauth
