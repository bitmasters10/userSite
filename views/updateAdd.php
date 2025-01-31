<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/updateAdd.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
   
    <title>Update Address</title>
</head>
<body>

    <div id="map"></div>
    <div id="sidebar">
        <h3>Selected Location</h3>
        <label>Address:</label>
        <input type="text" id="address" readonly />
        <button id="sendUpdated">Update Address</button>
        
        <input type="hidden" id="latitude" />
        <input type="hidden" id="longitude" />
    </div>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;
        var geocoder = L.Control.geocoder({ defaultMarkGeocode: false })
            .on('markgeocode', function(e) {
                var latlng = e.geocode.center;
                updateMarker(latlng, e.geocode.name);
            }).addTo(map);

        map.on('click', function(e) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${e.latlng.lat}&lon=${e.latlng.lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    var address = data.display_name || "Unknown Location";
                    updateMarker(e.latlng, address);
                });
        });

        document.getElementById("sendUpdated").addEventListener("click", function() {
            
        const address = localStorage.getItem('updatedAddress');
        const latitude = localStorage.getItem('updatedLatitude');
        const longitude = localStorage.getItem('updatedLongitude');
        
        if (address && latitude && longitude) {
            window.location.href = `dashboard.php?address=${encodeURIComponent(address)}&latitude=${latitude}&longitude=${longitude}`;
        }
    });


        function updateMarker(latlng, address) {
            if (marker) marker.setLatLng(latlng).setPopupContent(address).openPopup();
            else marker = L.marker(latlng).bindPopup(address).addTo(map).openPopup();

            document.getElementById('address').value = address;
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;

            localStorage.setItem('updatedAddress', address);
            localStorage.setItem('updatedLatitude', latlng.lat);
            localStorage.setItem('updatedLongitude', latlng.lng);

            console.log(document.getElementById('latitude').value);
            console.log(document.getElementById('longitude').value);
            
        }
    </script>

</body>
</html>
