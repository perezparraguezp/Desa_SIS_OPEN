<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$rut = $_POST['rut'];//rut paciente
$rut = str_replace(".","",$rut);
$nombre = $_POST['nombre'];
$nacimiento = $_POST['nacimiento'];
$sexo = $_POST['sexo'];
$pueblo = $_POST['pueblo'];
$nanea = $_POST['nanea'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$id_familia = $_POST['id_familia'];


$mysq = new mysql($_SESSION['id_usuario']);
$mysq->insert_persona($rut,$nombre,$telefono,$email);

$mysq->update_persona_column($rut,'fecha_nacimiento',$nacimiento);
$mysq->update_persona_column($rut,'sexo',$sexo);
$mysq->update_persona_column($rut,'nanea',$nanea);
$mysq->update_persona_column($rut,'pueblo',$pueblo);

$sql0 = "select * from integrante_familia where rut='$rut' limit 1";
$row0 = mysql_fetch_array(mysql_query($sql0));
if($row0){
    //existe en otra familia
    echo 'ERROR 1';//DUPLICADO
}else{
    $sql1 = "delete from integrante_familia where rut='$rut' ";//eliminamos al paciente de otros grupos familiares
    $sql2 = "insert into integrante_familia(id_familia,rut,fecha_registro) values('$id_familia','$rut',current_date())";//eliminamos al paciente de otros grupos familiares

    mysql_query($sql1);
    mysql_query($sql2);
    ECHO 'Integrante Asignado Correctamente!';
}

