<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';
$rut = $_POST['rut'];
$column = $_POST['column'];
$value = $_POST['value'];
$fecha = $_POST['fecha_registro'];
$amigable = $_POST['amigable'];
$p = new persona($rut);
$p->update_consejeria_ad($column,$value,$amigable,$fecha);
echo 'ACTUALIZADO';