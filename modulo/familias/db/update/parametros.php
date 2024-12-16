<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';

$id_familia = $_POST['id_familia'];
$column = $_POST['column'];
$value = $_POST['value'];
$fecha = $_POST['fecha_registro'];
$familia = new familia($id_familia);
$familia->id_profesional=$_SESSION['id_usuario'];
$familia->updateParametroFamilia($column,$value,$fecha);
echo 'ACTUALIZADO';