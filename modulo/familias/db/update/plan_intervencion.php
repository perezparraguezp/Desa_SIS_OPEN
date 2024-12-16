<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';

$id_familia = $_POST['id_familia'];
$id_plan = $_POST['id_registro'];

$egreso = $_POST['egreso'];
$fecha = $_POST['fecha_egreso'];
$tipo = $_POST['tipo_egreso'];

$familia = new familia($id_familia);
$familia->id_profesional=$_SESSION['id_usuario'];

$sql = "update historial_plan_intervencion_familia set
                                               estado='EGRESADO',
                                               fecha_egreso='$fecha',
                                               tipo_egreso='$tipo',
                                               motivo_egreso=upper('$egreso')
where id_registro='$id_plan' and id_familia='$id_familia' ";
mysql_query($sql);

echo 'ACTUALIZADO';