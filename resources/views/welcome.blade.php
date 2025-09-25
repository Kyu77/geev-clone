@extends("layout")

@section("title", "home")


@section("body")


<div class="text-center">
<h1 class="text-2xl font-bold my-6">Page d'accueil</h1>
<form method="GET" action="{{ route('home') }}" id="filters-form">
    <!-- Champ de recherche -->
    <div class="mb-6">
        <input type="text" name="search" id="search-input" placeholder="Rechercher des produits..." class="input input-bordered w-full max-w-md" value="{{ $search }}">
    </div>
    <!--
    <p>Total utilisateurs enregistrés : {{$userCount}}</p>
    -->
    <input type="hidden" name="user_lat" id="user_lat" value="{{ $userLat }}">
    <input type="hidden" name="user_lng" id="user_lng" value="{{ $userLng }}">
    <input type="hidden" name="radius" id="radius" value="{{ $radius }}">
    <div class="flex flex-wrap justify-center gap-4 mb-6">
        <!-- Filtre Catégories-->
        <div class="dropdown dropdown-center">
            @php
                $selectedCategories = !empty($categoryIds) ? $categories->whereIn('id', $categoryIds)->pluck('name')->toArray() : [];
                $buttonTextCategories = !empty($selectedCategories) ? 'Catégories: ' . implode(', ', $selectedCategories) : '🏷️Catégories';
            @endphp
            <div tabindex="0" role="button" class="btn m-1">{{ $buttonTextCategories }}</div>
            <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
                @foreach($categories as $category)
                    <label class="label cursor-pointer hover:bg-base-200 p-2 rounded transition justify-between" onclick="document.getElementById('filters-form').submit();">
                        <input id="category-{{ $category->id }}" type="checkbox" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $categoryIds) ? 'checked' : '' }} class="checkbox checkbox-lg">
                        <span class="label-text flex-1 ml-2">{{ $category->name }}</span>
                    </label>
                @endforeach
                <div class="divider"></div>
                <button type="button" class="btn btn-xs btn-outline w-full" onclick="clearFilters('category')">Effacer tout</button>
            </div>
        </div>
        <!-- Filtre Disponibilités-->
        <div class="dropdown dropdown-center">
            @php
                $selectedStatuts = !empty($statutIds) ? $statuts->whereIn('id', $statutIds)->pluck('name')->toArray() : [];
                $buttonTextStatuts = !empty($selectedStatuts) ? 'Disponibilités: ' . implode(', ', $selectedStatuts) : '🟢/🔴Disponibilités';
            @endphp
            <div tabindex="0" role="button" class="btn m-1">{{ $buttonTextStatuts }}</div>
            <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
                @foreach($statuts as $statut)
                    <label class="label cursor-pointer hover:bg-base-200 p-2 rounded transition justify-between" onclick="document.getElementById('filters-form').submit();">
                        <input id="statut-{{ $statut->id }}" type="checkbox" name="statut[]" value="{{ $statut->id }}" {{ in_array($statut->id, $statutIds) ? 'checked' : '' }} class="checkbox checkbox-lg">
                        <span class="label-text flex-1 ml-2">{{ $statut->name }}</span>
                    </label>
                @endforeach
                <div class="divider"></div>
                <button type="button" class="btn btn-xs btn-outline w-full" onclick="clearFilters('statut')">Effacer tout</button>
            </div>
        </div>
        <!-- Filtre Qualités-->
        <div class="dropdown dropdown-center">
            @php
                $selectedQualities = !empty($qualityIds) ? $qualities->whereIn('id', $qualityIds)->pluck('name')->toArray() : [];
                $buttonTextQualities = !empty($selectedQualities) ? 'Qualités: ' . implode(', ', $selectedQualities) : '⭐Qualités';
            @endphp
            <div tabindex="0" role="button" class="btn m-1">{{ $buttonTextQualities }}</div>
            <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
                @foreach($qualities as $quality)
                    <label class="label cursor-pointer hover:bg-base-200 p-2 rounded transition justify-between" onclick="document.getElementById('filters-form').submit();">
                        <input id="quality-{{ $quality->id }}" type="checkbox" name="quality[]" value="{{ $quality->id }}" {{ in_array($quality->id, $qualityIds) ? 'checked' : '' }} class="checkbox checkbox-lg">
                        <span class="label-text flex-1 ml-2">{{ $quality->name }}</span>
                    </label>
                @endforeach
                <div class="divider"></div>
                <button type="button" class="btn btn-xs btn-outline w-full" onclick="clearFilters('quality')">Effacer tout</button>
            </div>
        </div>
        <!-- Filtre Localisation-->
        <div class="dropdown dropdown-center">
            @php
                $buttonTextLocation = ($userLat && $userLng) ? "📍 Rayon: {$radius}km" : '📍Localisation';
            @endphp
            <div tabindex="0" role="button" class="btn m-1" id="location-filter-btn">{{ $buttonTextLocation }}</div>
            <div class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm" style="z-index: 5; border: solid 0.01px">
                <div class="mb-2">
                    <button type="button" id="detect-location-btn" class="btn btn-sm btn-outline w-full">Détecter ma position</button>
                    <div id="location-status" class="text-sm mt-1 text-center"></div>
                </div>
                <label class="label">
                    <span class="label-text">Rayon (km)</span>
                    <select name="radius" class="select select-bordered select-sm w-full">
                        <option value="5" {{ $radius == 5 ? 'selected' : '' }}>5 km</option>
                        <option value="10" {{ $radius == 10 ? 'selected' : '' }}>10 km</option>
                        <option value="25" {{ $radius == 25 ? 'selected' : '' }}>25 km</option>
                        <option value="50" {{ $radius == 50 ? 'selected' : '' }}>50 km</option>
                        <option value="100" {{ $radius == 100 ? 'selected' : '' }}>100 km</option>
                    </select>
                </label>
                <div class="flex gap-1 mt-2">
                    <button type="submit" class="btn btn-sm btn-primary flex-1" id="apply-location-filter" {{ !($userLat && $userLng) ? 'disabled' : '' }}>Appliquer</button>
                    @if($userLat && $userLng)
                    <button type="button" class="btn btn-sm btn-outline" id="disable-location-filter">Désactiver</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mb-6">
        <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
    </div>
</form>
<!--
<table class="table-auto w-full mt-6">
    <thead>
        <tr>
            <th class="border px-4 py-2">Nom de la catégorie</th>
            <th class="border px-4 py-2">Nombre de produits</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td class="border px-4 py-2">{{ $category->name }}</td>
            <td class="border px-4 py-2">{{ $category->products_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

-->

<ul class="flex flex-wrap" style="justify-content: center;">

<div class="mb-4">
    <button type="button" class="btn btn-outline btn-sm" onclick="clearAllFilters()">Effacer tous les filtres</button>
</div>

<ul id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @foreach ($products as $product)
  <li>
    <div class="card bg-white w-full max-w-sm h-full shadow-lg hover:shadow-xl transition rounded-xl overflow-hidden flex flex-col">

      {{-- Image produit (fixée à la même hauteur pour tous) --}}
      <figure class="h-56 bg-gray-200">
        @php
          $img = $product->images;
        @endphp
        <img src="{{ asset('storage/' . $img) }}"
             alt="{{ $product->title }}"
             class="w-full h-full object-cover" />
      </figure>

      {{-- Contenu card --}}
      <div class="card-body flex flex-col flex-grow justify-between">

        {{-- Titre + description --}}
        <div>
          <h2 class="text-lg font-semibold text-gray-900 truncate">
            {{ $product->title }}
          </h2>
          <p class="mt-1 text-sm text-gray-700 line-clamp-3">
            {{ $product->description }}
          </p>
        </div>

        {{-- Infos utilisateur / catégorie --}}
        <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
          <span class="font-medium">👤{{ $product->user->name }}</span>
          <span class="italic text-gray-500">🏷️{{ $product->category->name }}</span>
        </div>

        {{-- Bloc qualité + bouton action alignés en bas --}}
        <div class="mt-4 flex items-center justify-between">
          <span class="text-sm font-semibold text-indigo-600">
           ⭐{{ $product->quality->name }}
          </span>
          <span class="text-sm font-semibold text-indigo-600">
           {{ $product->statut->name == 'Disponible' ? '🟢' : '🔴' }}
          </span>

          <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-primary">
            Voir plus
          </a>
        </div>
      </div>
    </div>
  </li>
  @endforeach
</ul>

<script>
function clearFilters(type) {
    const checkboxes = document.querySelectorAll(`input[name="${type}[]"]`);
    checkboxes.forEach(checkbox => checkbox.checked = false);
}

function clearAllFilters() {
    clearFilters('category');
    clearFilters('statut');
    clearFilters('quality');
    document.getElementById('search-input').value = '';
    // Clear location
    document.getElementById('user_lat').value = '';
    document.getElementById('user_lng').value = '';
    document.getElementById('radius').value = '5'; // Reset to default
    // Update button text
    document.getElementById('location-filter-btn').textContent = '📍Localisation';
    // Auto-submit to apply
    document.getElementById('filters-form').submit();
}

document.addEventListener('DOMContentLoaded', function() {
    // Location detection
    const detectBtn = document.getElementById('detect-location-btn');
    const statusDiv = document.getElementById('location-status');
    const applyBtn = document.getElementById('apply-location-filter');
    const disableBtn = document.getElementById('disable-location-filter');
    const latInput = document.getElementById('user_lat');
    const lngInput = document.getElementById('user_lng');
    const radiusSelect = document.querySelector('select[name="radius"]');
    const locationBtn = document.getElementById('location-filter-btn');

    if (detectBtn) {
        detectBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                statusDiv.textContent = 'Détection en cours...';
                navigator.geolocation.getCurrentPosition(function(position) {
                    latInput.value = position.coords.latitude;
                    lngInput.value = position.coords.longitude;
                    statusDiv.textContent = 'Position détectée!';
                    applyBtn.disabled = false;
                    locationBtn.textContent = `📍 Rayon: ${radiusSelect.value}km`;
                }, function(error) {
                    statusDiv.textContent = 'Erreur de détection: ' + error.message;
                });
            } else {
                statusDiv.textContent = 'Géolocalisation non supportée.';
            }
        });
    }

    if (disableBtn) {
        disableBtn.addEventListener('click', function() {
            latInput.value = '';
            lngInput.value = '';
            statusDiv.textContent = '';
            applyBtn.disabled = true;
            locationBtn.textContent = '📍Localisation';
            // Submit form to clear location filter
            document.getElementById('filters-form').submit();
        });
    }

    // Update location button text on radius change
    if (radiusSelect) {
        radiusSelect.addEventListener('change', function() {
            if (latInput.value && lngInput.value) {
                locationBtn.textContent = `📍 Rayon: ${this.value}km`;
            }
        });
    }
});
</script>







</ul>
<div id="pagination-container">
{{$products->links()}}
</div>
</div>
@endsection
