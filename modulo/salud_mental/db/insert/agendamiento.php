<?php
include '../../../../php/config.php';

$myId = $_SESSION['id_usuario'];

$rut = str_replace(".","",$_POST['rut']);
$modulo = $_POST['modulo'];
$mes = $_POST['mes_cita'];
$anio = $_POST['anio_cita'];
$profesional = $_POST['profesional_cita'];

$sql = "insert into agendamiento(rut,anio_proximo_control,mes_proximo_control,id_profesional,profesional,modulo) 
        values('$rut','$anio','$mes','$myId','$profesional','$modulo')";
mysql_query($sql)or die('YA EXISTE UNA AGENDA PREVIA PARA LA FECHA INDICADA');

echo 'AGENDAMIENTO ASIGNADO';