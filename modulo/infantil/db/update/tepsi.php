<?php
include "../../../../php/config.php";
include "../../../../php/objetos/persona.php";

$myID = $_SESSION['id_usuario'];
$val = $_POST['val'];

$val = $_POST['val'];
$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);
$paciente->update_tepsi($val,$fecha_registro);
if($val=='NORMAL'){
    $paciente->update_tepsi_lenguaje($val,$fecha_registro);
    $paciente->update_tepsi_motrocidad($val,$fecha_registro);
    $paciente->update_tepsi_coordinacion($val,$fecha_registro);
}
echo "ACTUALIZADO";