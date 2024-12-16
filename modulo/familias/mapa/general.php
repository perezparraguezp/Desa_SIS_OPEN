<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");
include("../../../php/objetos/familia.php");
$tipo = $_POST['tipo'];
if($tipo!='TODOS'){
    $sql = "select * from familia 
where ubicacion_x!='' and estado_evaluacion like '%$tipo%'";
}else{
    $sql = "select * from familia 
where ubicacion_x!='' ";
}


$res = mysql_query($sql);
$listado = "";
$cantidad = 0;
$ULTIMO = "lat: -38.74447, lng: -72.95462";

while($row = mysql_fetch_array($res)){
    $familia = new familia($row['id_familia']);
    $NOMBRE_FAMILIA = $row['nombre_familia'];

    if($cantidad>0){
        $listado.=",";
    }
    $listado .= "createMarker({lat: ".$row['ubicacion_x'].", lng: ".$row['ubicacion_y']."}, '".$familia->estadoFamilia()."', '".$NOMBRE_FAMILIA."', '".$familia->getSQL('telefono_familia')."', '".$familia->estadoFamilia()."'),";
    $ULTIMO = "lat: ".$row['ubicacion_x'].", lng: ".$row['ubicacion_y']."";
}
?>

    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
<div id="map"></div>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: {<?php echo $ULTIMO; ?>} // Centra en Nueva Imperial
        });

        // Crear los marcadores con diferentes colores
        var markers = [
            <?php echo $listado; ?>
        ];

        // Aplicar el cluster
        var markerCluster = new MarkerClusterer(map, markers, {
            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        });
    }

    function createMarker(position, color,Familia, Telefono, Estado) {
        var iconBase = {
            'ALTO': 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
            'BAJO': 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
            'MEDIO': 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png',
            '': 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        };

        const marker = new google.maps.Marker({
            position: {
                lat: position.lat,
                lng: position.lng
            },
            icon: iconBase[color],
            map: map // Asegúrate de asociar el marcador al mapa
        });
        if(Estado===''){
            Estado="SIN EVALUAR";
        }
        if(Telefono===''){
            Telefono="SIN REGISTRO";
        }

        // Añadir un evento 'click' al marcador
        marker.addListener('click', function () {
            // Crear un InfoWindow con contenido dinámico
            const infoWindow = new google.maps.InfoWindow({
                content: '<h3>Familia: <strong>'+Familia+'</strong></h3><p>Estado: <strong>'+Estado+'</strong><br />Telefono: <strong>'+Telefono+'</strong></p>'
            });
            infoWindow.open(map, marker); // Abrir el InfoWindow en el marcador
        });

        return marker;
    }
    initMap();
</script>
