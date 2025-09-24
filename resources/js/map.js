// Map initialization for product show page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Map script loaded successfully');

    // Check if map container exists
    var mapElement = document.getElementById('map');
    if (!mapElement) {
        console.log('No map container found');
        return; // No map container found
    }

    console.log('Map container found:', mapElement);

    // Get coordinates from data attributes
    var latitude = mapElement.getAttribute('data-latitude');
    var longitude = mapElement.getAttribute('data-longitude');
    var title = mapElement.getAttribute('data-title');

    console.log('Map data:', { latitude, longitude, title });

    if (!latitude || !longitude) {
        // No coordinates available, show message
        console.log('No coordinates available, showing message');
        mapElement.innerHTML = '<div class="flex items-center justify-center h-full bg-gray-100 text-gray-600 rounded-lg"><p>📍 Aucune localisation définie</p></div>';
        return;
    }

    try {
        console.log('Initializing map with coordinates:', latitude, longitude);

        // Initialize map
        var map = L.map('map').setView([parseFloat(latitude), parseFloat(longitude)], 14);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        // Add marker with popup
        L.marker([parseFloat(latitude), parseFloat(longitude)]).addTo(map)
            .bindPopup('<b>' + title + '</b><br>Localisation du produit')
            .openPopup();

        console.log('Map initialized successfully');

    } catch (error) {
        console.error('Erreur lors de l\'initialisation de la carte:', error);
        mapElement.innerHTML = '<div class="flex items-center justify-center h-full bg-gray-100 text-gray-600 rounded-lg"><p>❌ Erreur de chargement de la carte: ' + error.message + '</p></div>';
    }
});
