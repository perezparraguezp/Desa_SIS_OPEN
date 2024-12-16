<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa con Clustering</title>
    <!-- Cargar API de Google Maps y MarkerClusterer -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_zUciThMErBFgkBIDx1ekdCcR6PUDKMI&callback=initMap" async defer></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        #clusterButton {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 5;
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<h1>Mapa con Clustering</h1>
<div id="clusterButton">
    <button id="toggleCluster" class="btn">Desactivar Clustering</button>
</div>
<div id="map"></div>

<script>
    var map, markerCluster, markers = [], clusteringEnabled = true;

    function initMap() {
        var center = { lat: -33.4489, lng: -70.6693 }; // Santiago, Chile
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: center
        });

        // Crear varios marcadores en distintas ubicaciones
        var locations = [
            { lat: -33.4489, lng: -70.6693 },
            { lat: -33.4569, lng: -70.6825 },
            { lat: -33.4423, lng: -70.6505 },
            { lat: -33.4615, lng: -70.6316 },
            { lat: -33.4523, lng: -70.6569 },
            { lat: -33.4500, lng: -70.6700 }
        ];

        // Crear marcadores para cada ubicación
        for (var i = 0; i < locations.length; i++) {
            var marker = new google.maps.Marker({
                position: locations[i],
                map: map
            });
            markers.push(marker);
        }

        // Inicializar el clustering
        markerCluster = new MarkerClusterer(map, markers, {
            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        });

        // Configurar el botón para activar/desactivar clustering
        document.getElementById('toggleCluster').addEventListener('click', function() {
            if (clusteringEnabled) {
                // Desactivar clustering
                markerCluster.clearMarkers();
                markers.forEach(function(marker) {
                    marker.setMap(map);
                });
                this.textContent = 'Activar Clustering';
            } else {
                // Activar clustering
                markers.forEach(function(marker) {
                    marker.setMap(null); // Esconder marcadores individuales
                });
                markerCluster.addMarkers(markers);
                this.textContent = 'Desactivar Clustering';
            }
            clusteringEnabled = !clusteringEnabled;
        });
    }
</script>
</body>
</html>
