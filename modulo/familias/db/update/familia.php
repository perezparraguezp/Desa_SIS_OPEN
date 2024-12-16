<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';

$familia = new familia($_POST['id_familia']);


$id_sector_centro = $_POST['id_sector_centro'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$codigo = $_POST['codigo_familia'];

$sector_familia = $_POST['sector_familia'] ;

$familia->updateSQL('nombre_familia',$nombre);
$familia->updateSQL('direccion_familia',$direccion);
$familia->updateSQL('sector_familia',$sector_familia);

$familia->updateSQL('id_sector',$id_sector_centro);
$familia->updateSQL('codigo_familia',$codigo);