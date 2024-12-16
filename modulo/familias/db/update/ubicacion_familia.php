<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';

$id_familia = $_POST['id_familia'];
$lat = $_POST['lat'];
$long = $_POST['long'];
$familia = new familia($id_familia);

$familia->updateSQL('ubicacion_x',$lat);
$familia->updateSQL('ubicacion_y',$long);
echo 'ACTUALIZADO';