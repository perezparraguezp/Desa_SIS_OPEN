<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$fecha = $_POST['fecha_registro'];
$comentario = $_POST['obs'];
$id_profesional = $_POST['id_profesional'];
$id_familia = $_POST['id_familia'];
$vdi = $_POST['vdi']==''?'NO':'SI';
$pauta = $_POST['plan']==''?'NO':'SI';
$riesgo = $_POST['riesgo'];



$sql2 = "insert into registro_familia_historico(id_familia,id_profesional,fecha_registro,obs,vdi,pauta,riesgo) 
values('$id_familia','$id_profesional','$fecha',upper('$comentario'),'$vdi','$pauta','$riesgo')";//eliminamos al paciente de otros grupos familiares

mysql_query($sql2);