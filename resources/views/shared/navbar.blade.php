<div class="navbar bg-base-100">
  <!-- Logo à gauche -->
  <div class="flex-1">
    <a href="{{ route('home') }}" class="btn btn-ghost text-xl">ReDon</a>
  </div>

  <!-- Partie droite -->
  <div class="flex-none flex items-center gap-3">
    @auth
    <!-- Nom visible uniquement en desktop -->
    <h2 class="hidden md:block font-semibold">{{ auth()->user()->name }}</h2>
    @endauth

    <!-- Avatar (toujours visible) -->
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">   
          <img
            alt="Avatar"
            src="{{ auth()->check() && auth()->user()->avatar 
              ? asset('storage/' . auth()->user()->avatar) 
              : 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp' }}" /> 
        </div>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        @if(!auth()->check())
        <li>
          <a href="{{ route('login') }}" class="btn btn-primary w-full justify-center">
            🔑 Connexion
          </a>
        </li>
        <li>
          <a href="{{ route('register') }}" class="btn btn-secondary w-full justify-center">
            📝 Inscription
          </a>
        </li>
        @else
        <li>
          <a href="{{ route('profile') }}" class="btn btn-info w-full justify-center">
            👤 Profil
          </a>
        </li>
        <form action="{{ route('auth.logout') }}" method="post">
          @csrf
          @method('delete')
          <button class="btn btn-error w-full justify-center">🚪 Déconnexion</button>
        </form>
        @endif
      </ul>
    </div>
  </div>
</div>




  @auth
      <div style="margin: 1rem; width: 150px;">
      <a href="{{route('product.create')}}" class="btn btn-xs sm:btn-sm md:btn-md lg:btn-lg xl:btn-xl">Donner un objet</a>
    </div>
@endauth
