import './bootstrap';

// Password visibility toggle
document.addEventListener('DOMContentLoaded', function () {
    // Toggle for edit-profile
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Toggle for login
    const togglePasswordLogin = document.getElementById('togglePasswordLogin');
    const passwordLogin = document.querySelector('input[name="password"]'); // Assuming the input has name="password"

    if (togglePasswordLogin && passwordLogin) {
        togglePasswordLogin.addEventListener('click', function () {
            const type = passwordLogin.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordLogin.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Toggle for register
    const togglePasswordRegister = document.getElementById('togglePasswordRegister');
    const passwordRegister = document.querySelector('input[name="password"]'); // Assuming the input has name="password"

    if (togglePasswordRegister && passwordRegister) {
        togglePasswordRegister.addEventListener('click', function () {
            const type = passwordRegister.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordRegister.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Live search functionality
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                performSearch();
            }, 300);
        });
    }

    // Location filter functionality
    const detectLocationBtn = document.getElementById('detect-location-btn');
    const locationStatus = document.getElementById('location-status');
    const applyLocationFilterBtn = document.getElementById('apply-location-filter');
    const disableLocationFilterBtn = document.getElementById('disable-location-filter');
    const userLatInput = document.getElementById('user_lat');
    const userLngInput = document.getElementById('user_lng');
    const locationFilterBtn = document.getElementById('location-filter-btn');

    if (detectLocationBtn) {
        detectLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                locationStatus.textContent = 'Détection en cours...';
                detectLocationBtn.disabled = true;
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        userLatInput.value = lat;
                        userLngInput.value = lng;
                        locationStatus.textContent = `Position détectée: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                        detectLocationBtn.disabled = false;
                        applyLocationFilterBtn.disabled = false;
                        locationFilterBtn.textContent = '📍 Rayon: 10km'; // Update button text
                    },
                    function(error) {
                        console.error('Erreur de géolocalisation:', error);
                        locationStatus.textContent = 'Erreur: Impossible de détecter la position.';
                        detectLocationBtn.disabled = false;
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                locationStatus.textContent = 'Géolocalisation non supportée.';
            }
        });
    }

    if (disableLocationFilterBtn) {
        disableLocationFilterBtn.addEventListener('click', function() {
            userLatInput.value = '';
            userLngInput.value = '';
            locationStatus.textContent = '';
            // Submit the form to disable the filter
            const form = document.getElementById('location-form');
            form.submit();
        });
    }

    function performSearch() {
        const search = searchInput.value;
        const url = new URL(window.location);
        url.searchParams.set('search', search);
        // Keep other params like category, statut, quality, user_lat, user_lng, radius
        // Add location params if available
        if (userLatInput && userLatInput.value) {
            url.searchParams.set('user_lat', userLatInput.value);
        }
        if (userLngInput && userLngInput.value) {
            url.searchParams.set('user_lng', userLngInput.value);
        }
        const currentUrl = new URL(window.location);
        const radius = currentUrl.searchParams.get('radius') || '10';
        url.searchParams.set('radius', radius);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            updateProducts(data.products);
            updatePagination(data.pagination);
        })
        .catch(error => console.error('Error:', error));
    }

    function updateProducts(products) {
        const container = document.getElementById('products-container');
        container.innerHTML = '';
        products.forEach(product => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="card bg-white w-full max-w-sm h-full shadow-lg hover:shadow-xl transition rounded-xl overflow-hidden flex flex-col">
                  <figure class="h-56 bg-gray-200">
                    <img src="/storage/${product.images}"
                         alt="${product.title}"
                         class="w-full h-full object-cover" />
                  </figure>
                  <div class="card-body flex flex-col flex-grow justify-between">
                    <div>
                      <h2 class="text-lg font-semibold text-gray-900 truncate">
                        ${product.title}
                      </h2>
                      <p class="mt-1 text-sm text-gray-700 line-clamp-3">
                        ${product.description}
                      </p>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
                      <span class="font-medium">👤${product.user.name}</span>
                      <span class="italic text-gray-500">🏷️${product.category.name}</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                      <span class="text-sm font-semibold text-indigo-600">
                       ⭐${product.quality.name}
                      </span>
                      <span class="text-sm font-semibold text-indigo-600">
                       ${product.statut.name == 'Disponible' ? '🟢' : '🔴'}
                      </span>
                      <a href="/product/${product.id}" class="btn btn-sm btn-primary">
                        Voir plus
                      </a>
                    </div>
                  </div>
                </div>
            `;
            container.appendChild(li);
        });
    }

    function updatePagination(paginationHtml) {
        const paginationContainer = document.getElementById('pagination-container');
        paginationContainer.innerHTML = paginationHtml;
        // Intercept pagination links
        paginationContainer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const search = searchInput.value;
                url.searchParams.set('search', search);
                // Add location params if available
                if (userLatInput && userLatInput.value) {
                    url.searchParams.set('user_lat', userLatInput.value);
                }
                if (userLngInput && userLngInput.value) {
                    url.searchParams.set('user_lng', userLngInput.value);
                }
                const radiusSelect = document.querySelector('select[name="radius"]');
                if (radiusSelect) {
                    url.searchParams.set('radius', radiusSelect.value);
                }
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateProducts(data.products);
                    updatePagination(data.pagination);
                })
                .catch(error => console.error('Error:', error));
            });
        });
    }
});
