document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map').setView([30.7333, 76.7794], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    const drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems
        },
        draw: {
            polygon: true,
            polyline: false,
            rectangle: false,
            circle: true,
            marker: false
        }
    });
    map.addControl(drawControl);

    // Add location control to the map
    const locationControl = L.control({position: 'topleft'});
    locationControl.onAdd = function(map) {
        const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
        const button = L.DomUtil.create('a', '', div);
        button.innerHTML = '<i class="fa-solid fa-location-crosshairs" style="line-height: 30px;"></i>';
        button.title = 'Show my location';
        button.href = '#';
        button.style.width = '30px';
        button.style.height = '30px';
        button.style.textAlign = 'center';
        button.style.fontSize = '14px';
        button.style.backgroundColor = 'white';
        button.style.color = '#D12E79';
    
        button.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            locateUser(button);
            return false;
        };
        return div;
    };
    locationControl.addTo(map);
    
    // Function to locate user
    function locateUser(button) {
        if (navigator.geolocation) {
            button.style.color = '#999'; // Visual feedback - gray out button while loading
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 17);
                    
                    // Optional: Add a marker at user's location
                    const userMarker = L.marker([lat, lng], {
                        icon: L.divIcon({
                            html: '<i class="fa-solid fa-circle-user" style="color: #D12E79; font-size: 24px;"></i>',
                            className: 'user-location-marker',
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        })
                    }).addTo(map);
                    
                    // Remove marker after 5 seconds
                    setTimeout(() => {
                        map.removeLayer(userMarker);
                    }, 5000);
                    
                    button.style.color = '#D12E79'; // Reset button color
                },
                function(error) {
                    console.error('Error getting location:', error);
                    alert('Unable to retrieve your location. Please check your location permissions.');
                    button.style.color = '#D12E79'; // Reset button color
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }

    let currentShape = null;

    // Hide both instruction messages
    function hideInstructions() {
        const messages = document.querySelectorAll('.text-sm.text-gray-600.mb-4');
        messages.forEach(msg => msg.style.display = 'none');
    }

    // Show both instruction messages
    function showInstructions() {
        const messages = document.querySelectorAll('.text-sm.text-gray-600.mb-4');
        messages.forEach(msg => msg.style.display = 'block');
    }

    map.on(L.Draw.Event.CREATED, function (e) {
        if (currentShape) {
            drawnItems.removeLayer(currentShape);
        }
        const layer = e.layer;
        currentShape = layer;
        drawnItems.addLayer(layer);
        hideInstructions();
        
        // Get coordinates based on shape type
        let coordinates;
        if (e.layerType === 'circle') {
            const center = layer.getLatLng();
            const radius = layer.getRadius();
            coordinates = {
                type: 'circle',
                center: [center.lat, center.lng],
                radius: radius
            };
        } else {
            // For polygon
            coordinates = {
                type: 'polygon',
                points: layer.getLatLngs()[0].map(latLng => [latLng.lat, latLng.lng])
            };
        }
        document.getElementById('coordinates').value = JSON.stringify(coordinates);
    });

    // Handle form submission
    document.getElementById('safeSpaceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!document.getElementById('coordinates').value) {
            alert('Please draw a shape on the map first');
            return;
        }

        const data = {
            coordinates: document.getElementById('coordinates').value,
            description: document.getElementById('description').value,
            timeActive: document.getElementById('timeActive').value
        };

        fetch('save_safe_zone.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Safe space saved successfully!');
                document.getElementById('safeSpaceForm').reset();
                if (currentShape) {
                    drawnItems.removeLayer(currentShape);
                    currentShape = null;
                }
                showInstructions();
            } else {
                alert('Error saving safe space: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving safe space. Please try again.');
        });
    });
});