<?php
include "../../../../php/config.php";
include "../../../../php/objetos/persona.php";


$myID = $_SESSION['id_usuario'];
$obs = $_POST['obs'];
$rut = $_POST['rut'];
$tipo = $_POST['tipo_visita'];
if($tipo=='ASISTENTE'){
    $tipo = 'VDI';
}else{
    $tipo = 'NO-VDI';
}
$fecha_registro = $_POST['fecha_registro'];
$persona = new persona($rut);
$dias = $persona->calcularEdadDias($fecha_registro);

$sql = "insert into historial_paciente(rut,tipo_historial,fecha_registro,texto,id_profesional,edad_dias,modulo,id_establecimiento) 
values('$rut','VID','$fecha_registro',upper('$obs'),'$myID','$dias','INFANTIL','1')";
mysql_query($sql);
$persona->updateSQL('fecha_vdi',$fecha_registro);

echo "ACTUALIZADO";