<?php
include "../../../../php/config.php";
include "../../../../php/objetos/persona.php";


$myID = $_SESSION['id_usuario'];
$val = $_POST['val'];
$fecha_registro = $_POST['fecha_registro'];

$column = $_POST['column'];
$rut = $_POST['rut'];
$reeval = $_POST['reeval'];
$paciente = new persona($rut);
$paciente->update_Psicomotor($column,$val,$fecha_registro);

if($reeval === 'SI'){
    $edad_paciente = $paciente->calcularEdadFecha($fecha_registro);
    $fecha_dias = $paciente->calcularEdadDias($fecha_registro);

    $sql3 = "insert into historial_psicomotor(id_profesional,fecha_registro,rut,indicador,valor_indicador,edad_paciente,edad_dias) 
                  values('$myID','$fecha_registro','$rut',upper('$column [RE-EVAL]'),upper('$val'),'$edad_paciente','$fecha_dias')";
    mysql_query($sql3);
    $sql4 = "delete from historial_psicomotor where fecha_registro='$fecha_registro' 
    and indicador=upper('$column') and rut='$rut' ";
//    echo $sql4;
    mysql_query($sql4);
}





echo "ACTUALIZADO";