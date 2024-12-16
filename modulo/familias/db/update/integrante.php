<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';
include '../../../../php/objetos/persona.php';

$rut = $_POST['rut'];//rut paciente
$rut = str_replace(".","",$rut);
$nombre = $_POST['nombre'];
$nacimiento = $_POST['nacimiento'];
$sexo = $_POST['sexo'];
$pueblo = $_POST['pueblo'];
$nanea = $_POST['nanea'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$id_familia = $_POST['id_familia'];
$obs = $_POST['obs_personal'];

$persona = new persona($rut);

if($persona->existe){
    $mysq = new mysql($_SESSION['id_usuario']);

    $mysq->update_persona_column($rut,'fecha_nacimiento',$nacimiento);
    $mysq->update_persona_column($rut,'nombre_completo',$nombre);
    $mysq->update_persona_column($rut,'sexo',$sexo);
    $mysq->update_persona_column($rut,'nanea',$nanea);
    $mysq->update_persona_column($rut,'pueblo',$pueblo);
    $mysq->update_persona_column($rut,'telefono',$telefono);
    $mysq->update_persona_column($rut,'email',$email);
    $mysq->update_persona_column($rut,'obs_personal',$obs);

}



