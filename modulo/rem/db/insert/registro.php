<?php
include '../../../../php/config.php';
session_start();
$profesional = $_SESSION['rut'];

$formulario = $_POST['formulario'];
$seccion = $_POST['seccion'];
$lugar = $_POST['lugar'];

$rut = str_replace(".","",$_POST['rut']);
$fecha = $_POST['fecha_registo'];
$sexo = $_POST['sexo'];
$edad = $_POST['edad'];
$pueblo = $_POST['pueblo'];
$migrante = $_POST['migrante'];
$sql = "select * from usuarios where rut='$profesional' limit 1";
$row = mysql_fetch_array(mysql_query($sql));
if($row){
    $profesion = $row['tipo_usuario'];
}else{
    $profesion = '';
}


$valor = $_POST;

$valor =  json_encode($valor);

$sql = "insert into registro_rem(profesion,lugar,rut_profesional,rut_paciente,fecha_registro,sexo,edad,pueblo,migrante,valor,tipo_form,seccion_form) 
values(upper('$profesion'),upper('$lugar'),upper('$profesional'),upper('$rut'),'$fecha','$sexo','$edad','$pueblo','$migrante','$valor','$formulario','$seccion')";
//echo $sql;
mysql_query($sql);

