<?php
include "../../../../php/config.php";
include "../../../../php/objetos/persona.php";

$val = $_POST['val'];
$column = $_POST['column'];
$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];

if($val!=''){
    $paciente = new persona($rut);
    $paciente->update_Antropometria($column,$val,$fecha_registro);

    echo "ACTUALIZADO";
}
