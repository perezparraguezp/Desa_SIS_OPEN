<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$fecha = $_POST['fecha_registro'];
$comentario = $_POST['comentario'];
$id_profesional = $_POST['id_profesional'];
$id_familia = $_POST['id_familia'];



$sql2 = "insert into historial_vdi_familia(id_familia,id_profesional,fecha_registro,comentario) 
values('$id_familia','$id_profesional','$fecha',upper('$comentario'))";//eliminamos al paciente de otros grupos familiares


mysql_query($sql2);