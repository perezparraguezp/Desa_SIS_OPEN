<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';

$rut = $_POST['rut'];//rut paciente
$colum = $_POST['colum'];
$fecha = $_POST['fecha_registro'];
$valor = $_POST['valor'];

$persona = new persona($rut);
$persona->updateSM_Diagnostico($colum,$valor,$fecha);
$texto = 'SE HA REALIZADO UN CAMBIO EN REGISTRO '.$colum." POR EL VALOR ".$valor;

$persona->addHistorial_SM_Diagnostico($texto);
