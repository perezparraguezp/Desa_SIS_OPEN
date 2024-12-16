<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$fecha = $_POST['fecha_registro'];
$fecha_termino = $_POST['fecha_termino'];
$comentario = $_POST['comentario'];
$id_profesional = $_POST['id_profesional'];
$id_familia = $_POST['id_familia'];



$sql2 = "insert into historial_plan_intervencion_familia(id_familia,id_profesional,fecha_registro,comentario,estado,fecha_termino) 
values('$id_familia','$id_profesional','$fecha',upper('$comentario'),'VIGENTE','$fecha_termino')";//eliminamos al paciente de otros grupos familiares


mysql_query($sql2);