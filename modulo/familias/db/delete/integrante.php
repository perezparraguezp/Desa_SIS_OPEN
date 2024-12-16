<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';

$rut = $_POST['rut'];//rut paciente
$id_familia = $_POST['id_familia'];//rut paciente


$sql = "delete from integrante_familia where rut='$rut' and id_familia='$id_familia' ";

mysql_query($sql);