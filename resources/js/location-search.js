// Location search functionality using Nominatim API
document.addEventListener('DOMContentLoaded', function() {
    console.log('Location search script loaded successfully');

    const locationInputs = document.querySelectorAll('#location_search');
    const latitudeInputs = document.querySelectorAll('#latitude');
    const longitudeInputs = document.querySelectorAll('#longitude');
    const errorElements = document.querySelectorAll('#location_error');

    console.log('Found location inputs:', locationInputs.length);
    console.log('Found latitude inputs:', latitudeInputs.length);
    console.log('Found longitude inputs:', longitudeInputs.length);
    console.log('Found error elements:', errorElements.length);

    // Rate limiting: prevent API calls more frequently than once per 500ms
    let lastApiCall = 0;
    const API_DELAY = 500;

    locationInputs.forEach((locationInput, index) => {
        const latitudeInput = latitudeInputs[index];
        const longitudeInput = longitudeInputs[index];
        const errorElement = errorElements[index];

        console.log('Setting up location input:', index, {
            locationInput: !!locationInput,
            latitudeInput: !!latitudeInput,
            longitudeInput: !!longitudeInput,
            errorElement: !!errorElement
        });

        // Initialize with existing coordinates if available
        if (latitudeInput && longitudeInput && latitudeInput.value && longitudeInput.value) {
            console.log('Found existing coordinates, attempting reverse geocoding');
            // Only try to reverse geocode if location input is empty
            if (!locationInput.value || locationInput.value.trim() === '') {
                console.log('Location input is empty, attempting reverse geocoding');
                reverseGeocode(latitudeInput.value, longitudeInput.value, locationInput);
            } else {
                console.log('Location input already has value, skipping reverse geocoding');
            }
        }

        // Handle input events
        locationInput.addEventListener('blur', function() {
            console.log('Location input blurred with value:', this.value);
            handleLocationSearch(this.value, latitudeInput, longitudeInput, errorElement, locationInput);
        });

        locationInput.addEventListener('change', function() {
            console.log('Location input changed with value:', this.value);
            handleLocationSearch(this.value, latitudeInput, longitudeInput, errorElement, locationInput);
        });

        // Add input event for real-time search
        locationInput.addEventListener('input', function() {
            // Debounce input to avoid too many API calls - increased delay for longer city names
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                if (this.value.length >= 3) {
                    console.log('Location input changed (debounced) with value:', this.value);
                    handleLocationSearch(this.value, latitudeInput, longitudeInput, errorElement, locationInput);
                }
            }, 1000); // Increased from 300ms to 1000ms to allow typing longer city names
        });
    });

    function handleLocationSearch(query, latitudeInput, longitudeInput, errorElement, locationInput) {
        if (!query.trim()) {
            clearLocation(latitudeInput, longitudeInput, errorElement);
            return;
        }

        // Rate limiting
        const now = Date.now();
        if (now - lastApiCall < API_DELAY) {
            setTimeout(() => {
                handleLocationSearch(query, latitudeInput, longitudeInput, errorElement, locationInput);
            }, API_DELAY - (now - lastApiCall));
            return;
        }

        lastApiCall = now;

        // Show loading state
        if (locationInput) {
            locationInput.disabled = true;
            locationInput.placeholder = 'Recherche en cours...';
        }
        hideError(errorElement);

        console.log('Searching for:', query); // Debug log

        // Call Nominatim API
        searchLocation(query, latitudeInput, longitudeInput, errorElement, locationInput);
    }

    function searchLocation(query, latitudeInput, longitudeInput, errorElement, locationInput) {
        // Add country restriction for better results in France
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&addressdetails=1&countrycodes=FR`;

        console.log('API URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'User-Agent': 'GeevClone/1.0'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('API Response:', data);

            if (locationInput) {
                locationInput.disabled = false;
                locationInput.placeholder = 'Ex: Paris, 75000, Lyon...';
            }

            if (data && data.length > 0) {
                // Find the best result (prefer city/town over other types)
                let bestResult = data[0];
                for (let result of data) {
                    if (result.type === 'city' || result.type === 'town' || result.type === 'village') {
                        bestResult = result;
                        break;
                    }
                }

                if (latitudeInput && longitudeInput) {
                    latitudeInput.value = bestResult.lat;
                    longitudeInput.value = bestResult.lon;
                }

                // Update input with found location for better UX
                const cityName = bestResult.address?.city || bestResult.address?.town || bestResult.address?.village || bestResult.display_name.split(',')[0];
                if (locationInput) {
                    locationInput.value = cityName;

                    // Add visual indication that location was found
                    locationInput.style.borderColor = '#10b981'; // Green border
                    locationInput.style.borderWidth = '3px'; // Thicker border
                }

                console.log('Location found:', cityName, bestResult.lat, bestResult.lon);
                hideError(errorElement);
            } else {
                console.log('No results found for:', query);
                showError(errorElement, 'Ville introuvable. Vérifiez l\'orthographe ou essayez un code postal.');
                clearLocation(latitudeInput, longitudeInput, errorElement);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la recherche:', error);
            if (locationInput) {
                locationInput.disabled = false;
                locationInput.placeholder = 'Ex: Paris, 75000, Lyon...';
            }
            showError(errorElement, 'Erreur de connexion. Vérifiez votre connexion internet et réessayez.');
            clearLocation(latitudeInput, longitudeInput, errorElement);
        });
    }

    function reverseGeocode(lat, lon, locationInput) {
        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&addressdetails=1`;

        fetch(url, {
            headers: {
                'User-Agent': 'GeevClone/1.0'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.display_name) {
                // Extract city name from the reverse geocoding result
                const cityName = data.address?.city || data.address?.town || data.address?.village || data.display_name.split(',')[0];
                locationInput.value = cityName;

                // Add visual indication that location was found (for existing products)
                locationInput.style.borderColor = '#10b981'; // Green border
                locationInput.style.borderWidth = '3px'; // Thicker border
            }
        })
        .catch(error => {
            console.error('Erreur reverse geocoding:', error);
        });
    }

    function showError(errorElement, message) {
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            console.log('Error displayed:', message);
        }
    }

    function hideError(errorElement) {
        if (errorElement) {
            errorElement.classList.add('hidden');
        }
    }

    function clearLocation(latitudeInput, longitudeInput, errorElement) {
        if (latitudeInput) latitudeInput.value = '';
        if (longitudeInput) longitudeInput.value = '';
        hideError(errorElement);

        // Clear visual success indicators
        const locationInputs = document.querySelectorAll('#location_search');
        locationInputs.forEach(locationInput => {
            // Reset styles
            locationInput.style.borderColor = '';
            locationInput.style.borderWidth = '';
        });
    }
});
