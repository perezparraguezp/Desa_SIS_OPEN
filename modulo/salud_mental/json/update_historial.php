<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");



$id_establecimiento = $_SESSION['id_establecimiento'];

$indicador = $_GET['indicador'];

if($indicador!=''){

}
$rut = trim($_GET['rut']);
if($rut!=''){
    $filtro_rut =" and paciente_establecimiento.rut='$rut' ";
    $persona_filtro = new persona($rut);
}else{
    $filtro_rut = "";
}

//filtro tope de edad

$sql = "select * from paciente_establecimiento
              where paciente_establecimiento.m_salud_mental='SI'
              and paciente_establecimiento.id_establecimiento='$id_establecimiento' $filtro_rut
              group by paciente_establecimiento.rut";

$res = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_array($res)){
    $rut = $row['rut'];
    $paciente = new persona($row['rut']);

    $sql1 = "select * from paciente_actividad_sm where rut='$rut' order by fecha_registro desc limit 1";
    $row1 = mysql_fetch_array(mysql_query($sql1));
    if($row1){
        $myID = $row1['id_profesional'];
        $fecha = $row1['fecha_registro'];
        $sql0 = "insert into historial_paciente(tipo_historial,texto,id_establecimiento,id_profesional,rut,fecha_registro) 
                values('SALUD MENTAL','REGISTRO DE ACTIVIDAD SALUD MENTAL','1','$myID','$rut','$fecha')";
        mysql_query($sql0);
    }

    $sql1 = "select * from paciente_diagnosticos_sm where rut='$rut' order by fecha_inicio desc limit 1";
    $row1 = mysql_fetch_array(mysql_query($sql1));
    if($row1){
        $myID = $row1['id_profesional'];
        $fecha = $row1['fecha_inicio'];
        $sql0 = "insert into historial_paciente(tipo_historial,texto,id_establecimiento,id_profesional,rut,fecha_registro) 
                values('SALUD MENTAL','REGISTRO DE DIAGNOSTICO SALUD MENTAL','1','$myID','$rut','$fecha')";
        mysql_query($sql0);
    }

    $sql1 = "select * from paciente_farmacos_sm where rut='$rut' order by fecha_inicio desc limit 1";
    $row1 = mysql_fetch_array(mysql_query($sql1));
    if($row1){
        $myID = $row1['id_profesional'];
        $fecha = $row1['fecha_inicio'];
        $sql0 = "insert into historial_paciente(tipo_historial,texto,id_establecimiento,id_profesional,rut,fecha_registro) 
                values('SALUD MENTAL','REGISTRO DE FARMACOS SALUD MENTAL','1','$myID','$rut','$fecha')";
        mysql_query($sql0);
    }

    $sql1 = "select * from paciente_antecedentes_sm where rut='$rut' order by fecha_ingreso desc limit 1";
    $row1 = mysql_fetch_array(mysql_query($sql1));
    if($row1){
        $myID = $row1['id_profesional'];
        $fecha = $row1['fecha_ingreso'];
        $sql0 = "insert into historial_paciente(tipo_historial,texto,id_establecimiento,id_profesional,rut,fecha_registro) 
                values('SALUD MENTAL','REGISTRO DE ANTECEDENTES SALUD MENTAL','1','$myID','$rut','$fecha')";
        mysql_query($sql0);
    }

}


?>
