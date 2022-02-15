<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';

$rut = $_POST['rut'];//rut paciente
$id = $_POST['id'];


$sql = "delete from paciente_farmacos_sm where id_registro='$id' and rut='$rut' limit 1";
mysql_query($sql);