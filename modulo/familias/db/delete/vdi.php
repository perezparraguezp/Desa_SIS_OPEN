<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';


$id_profesional = $_POST['id_profesional'];
$id_registro = $_POST['id_registro'];
$id_familia = $_POST['id_familia'];
$json = $_POST['json'];

$sql1 = "insert into delete_tables(tabla,columna,id,json,id_usuario)
values('historial_vdi_familia','id_registro','$id_registro','$json','$id_profesional')";
mysql_query($sql1);

$sql2 = "delete from historial_vdi_familia where id_registro='$id_registro' ";//eliminamos al paciente de otros grupos familiares
mysql_query($sql2);