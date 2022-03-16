<?php
include '../../../../php/config.php';
include '../../../../php/objetos/profesional.php';
include '../../../../php/objetos/persona.php';

$id_profesional = $_POST['id_profesional'];
$tipo = $_POST['tipo'];

$profesional = new profesional($id_profesional);

$profesional->updateDatosProfesional('tipo_contrato',$tipo);
$profesional->updateDatosUsuario('tipo_usuario',$tipo);
echo "Datos Actualizados";