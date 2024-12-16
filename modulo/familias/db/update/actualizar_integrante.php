<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';
include '../../../../php/objetos/persona.php';

$rut = $_POST['rut'];//rut paciente
$id_familia = $_POST['id_familia'];//rut paciente
$valor = $_POST['valor'];//rut paciente


$familia = new familia($id_familia);
$persona = new persona($rut);

$persona->updateSQL('parentesco',$valor);

echo 'ACTUALIZADO';