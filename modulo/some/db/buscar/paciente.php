<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';

$rut = str_replace(",","",$_POST['rut']);
$rut = str_replace(".","",$rut);

$mysq = new mysql($_SESSION['id_usuario']);

$mysq->buscarRUT($rut);
if($mysq->result==true){
    echo 'DUPLICADO';
}else{
    echo 'DISPONIBLE';
}