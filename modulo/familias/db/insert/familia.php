<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';




$id_sector_centro = $_POST['id_sector_centro'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$id_establecimiento = $_SESSION['id_establecimiento'] ;
$sector_familia = $_SESSION['sector_familia'] ;
$codigo = $_POST['codigo_familia'] ;

$sql = "insert into familia(nombre_familia,direccion_familia,id_sector,id_establecimiento,ubicacion_x,ubicacion_y,sector_familia,codigo_familia)
values(upper('$nombre'),upper('$direccion'),'$id_sector_centro','$id_establecimiento','-38.74447','-72.95462','$sector_familia','$codigo')";

mysql_query($sql)or die("ERROR_SQL: INSERT FAMILIA");