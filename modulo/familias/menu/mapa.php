<?php
error_reporting(0);
$lat = $_GET['lat'];
$long = $_GET['long'];
$id_familia = $_GET['id_familia'];
$direccion = $_GET['direccion'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal con Google Maps</title>
    <!-- Asegúrate de reemplazar TU_API_KEY por tu clave de Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_zUciThMErBFgkBIDx1ekdCcR6PUDKMI&libraries=places" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        #map {
            height: 400px;
            width: 100%;
        }

        /* Estilos para botones */
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
        #searchInput {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h2>Ubica el marcador en el mapa</h2>
<label>INGRESE UNA DIRECCION <input id="searchInput" type="text" value="<?php echo $direccion; ?>" placeholder="Ingresa una dirección o lugar" /></label>
<div id="map"></div>
<button id="confirmLocation" class="btn">Confirmar ubicación</button>
<p id="coords">Coordenadas: (latitud, longitud)</p>

<script>
    var map, marker, latLng;

    // Inicializar el mapa en el modal
    function initMap() {
        // Coordenadas iniciales (ejemplo: Santiago, Chile)

        latLng = { lat: <?php echo $lat; ?>, lng: <?php echo $long; ?> };

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: latLng
        });

        // Crear el marcador y hacerlo "arrastrable"
        marker = new google.maps.Marker({
            position: latLng,
            map: map,
            draggable: true
        });

        var input = document.getElementById('searchInput');
        var autocomplete = new google.maps.places.Autocomplete(input);

        // Limitar los resultados de búsqueda a un área geográfica específica (opcional)
        autocomplete.setComponentRestrictions({
            country: ['cl'] // Cambiar el código del país si es necesario
        });

        // Evento que se dispara cuando se selecciona una dirección del autocomplete
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                alert("El lugar no tiene detalles de geometría");
                return;
            }

            // Centrar el mapa y mover el marcador a la nueva ubicación
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            latLng = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };
            updateCoordinates();
        });
        // Evento que se dispara cuando se arrastra el marcador
        marker.addListener('dragend', function() {
            var position = marker.getPosition();
            latLng = { lat: position.lat(), lng: position.lng() };
            updateCoordinates();
        });


        updateCoordinates();
    }

    // Actualizar las coordenadas en el texto dentro del modal
    function updateCoordinates() {
        document.getElementById('coords').textContent = `Coordenadas: (${latLng.lat.toFixed(5)}, ${latLng.lng.toFixed(5)})`;
        updateUbicacion();
    }


    // Confirmar la ubicación y obtener las coordenadas finales
    function updateUbicacion(){
        $.post('../db/update/ubicacion_familia.php', {
            id_familia: '<?php echo $id_familia ?>',
            lat:latLng.lat.toFixed(5),
            long:latLng.lng.toFixed(5)
        }, function (data) {

        });
    }
    initMap();
</script>
</body>
</html>
