let map;
let userLocation;

function get_location() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    document.getElementById("lats").value = position.coords.latitude;
    document.getElementById("long").value = position.coords.longitude;

    userLocation = [position.coords.latitude, position.coords.longitude];
    initializeMap();
}

function initializeMap() {
    // Initialize the map
    map = L.map('map').setView(userLocation, 14);

    // Add the base map layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add markers and draw lines
    addMarkerAndDrawLine('hospital', 'red');
    addMarkerAndDrawLine('police_station', 'blue');
    addMarkerAndDrawLine('petrol_pump', 'green');
}

function addMarkerAndDrawLine(placeType, color) {
    let placeMarker;
    let placeLatLng;

    // Fetch the nearest place of the specified type
    fetchNearestPlace(placeType)
        .then(nearestPlace => {
            if (nearestPlace) {
                // Extract latitude and longitude
                placeLatLng = [nearestPlace.Latitude, nearestPlace.Longitude];

                // Add marker for the place
                placeMarker = L.marker(placeLatLng, {
                    icon: L.divIcon({
                        className: 'custom-marker',
                        html: `<div style="background-color: ${color}" class="marker-color"></div>`,
                    })
                }).addTo(map);

                // Draw a line from user location to the place
                let polyline = L.polyline([userLocation, placeLatLng], { color: color }).addTo(map);

                // Adjust the map bounds to include the user location and place
                map.fitBounds([userLocation, placeLatLng]);

                // Add a popup for the place marker
                placeMarker.bindPopup(`<b>${placeType}</b><br>${nearestPlace.Name}`).openPopup();

                // Display the result below the map
                displayResult(nearestPlace);
            }
        })
        .catch(error => console.error(error));
}

function displayResult(nearestPlace) {
    const resultHtml = `
        <p>The nearest ${nearestPlace.placeType} is: ${nearestPlace.name}</p>
        <p>Address: ${nearestPlace.address}</p>
        <p>Phone Number: ${nearestPlace.phone_number}</p>
        <p>Distance: ${nearestPlace.distance} km</p>
    `;
    document.getElementById('result').innerHTML = resultHtml;
}

function fetchNearestPlace(placeType) {
    const latitude = document.getElementById('lats').value;
    const longitude = document.getElementById('long').value;
    placeType = placeType || document.getElementsByName('place_type')[0].value;

    return fetch(`nearest.php?latitude=${latitude}&longitude=${longitude}&place_type=${placeType}`)
        .then(response => response.json())
        .catch(error => console.error(error));
}

function findNearestPlace() {
    fetchNearestPlace()
        .then(nearestPlace => {
            // Check if there's an error in the response
            if (nearestPlace.error) {
                document.getElementById('result').innerHTML = `<p>Error: ${nearestPlace.error}</p>`;
            } else {
                // Display the result
                displayResult(nearestPlace);
            }
        })
        .catch(error => console.error(error));

    // Prevent the form from submitting and reloading the page
    return false;
}

function displayResult(nearestPlace) {
    const resultHtml = `
        <p>The nearest ${nearestPlace.placeType} is: ${nearestPlace.name}</p>
        <p>Address: ${nearestPlace.address}</p>
        <p>Phone Number: ${nearestPlace.phone_number}</p>
        <p>Distance: ${nearestPlace.distance} km</p>
    `;
    document.getElementById('result').innerHTML = resultHtml;
}
