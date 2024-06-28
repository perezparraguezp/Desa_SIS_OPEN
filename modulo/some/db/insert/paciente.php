<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$rut = str_replace(",","",$_POST['rut']);
$rut = str_replace(".","",$rut);
$nombre = $_POST['nombre'];
$nacimiento = $_POST['nacimiento'];
$sexo = $_POST['sexo'];
$pueblo = $_POST['pueblo'];
$nanea = $_POST['nanea'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$ficha = $_POST['ficha'];
$carpeta_familiar = $_POST['carpeta_familiar'];
$comuna = $_POST['comuna'];

$id_sector_interno = $_POST['id_sector_centro'];


$mysq = new mysql($_SESSION['id_usuario']);
$mysq->insert_persona($rut,$nombre,$telefono,$email);
$mysq->update_persona_column($rut,'direccion',$direccion);
$mysq->update_persona_column($rut,'comuna',$comuna);
$mysq->update_persona_column($rut,'fecha_nacimiento',$nacimiento);
$mysq->update_persona_column($rut,'sexo',$sexo);
$mysq->update_persona_column($rut,'nanea',$nanea);
$mysq->update_persona_column($rut,'pueblo',$pueblo);
$mysq->update_persona_column($rut,'numero_ficha',$ficha);
$mysq->update_persona_column($rut,'carpeta_familiar',$carpeta_familiar);
$mysq->insert_paciente_establecimiento($rut,$id_sector_interno);
$mysq->limpiarModulos($rut);

$modulos = $_POST['modulo'];
foreach ($modulos as $i => $menu){
    $mysq->updateModuloPaciente($rut,'m_infancia','SI');
}
//por defecto agregar infantil
$mysq->updateModuloPaciente($rut,'m_infancia','SI');