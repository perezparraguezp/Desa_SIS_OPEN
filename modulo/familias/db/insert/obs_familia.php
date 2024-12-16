<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$fecha_registro = $_POST['fecha_registro'];
$comentario = $_POST['obs_general'];
$id_profesional = $_POST['id_profesional'];
$id_familia = $_POST['id_familia'];



$sql2 = "insert into obs_familia(id_familia,id_profesional,fecha_registro,texto) 
values('$id_familia','$id_profesional',current_date(),upper('$comentario'))";//eliminamos al paciente de otros grupos familiares


mysql_query($sql2);