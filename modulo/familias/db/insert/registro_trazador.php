<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';
include '../../../../php/objetos/familia.php';

$fecha = $_POST['fecha_registro'];
$id_familia = $_POST['id_familia'];
$trazadores = $_POST['trazador'];
$obs = $_POST['obs'];



$familia = new familia($id_familia);
session_start();
$familia->id_profesional = $_SESSION['id_usuario'];

$listado = '';
foreach ($trazadores as $id_trazador => $valor){
    $listado.=";".$id_trazador.";";
}

$familia->insertTrazador($listado,$fecha,$obs);

