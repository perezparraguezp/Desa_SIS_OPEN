<?php
include '../../../../php/config.php';

$rut = str_replace(".","",$_POST['rut']);
$column = $_POST['columna'];

$sql = "select * from persona where rut='$rut' limit 1";


$row = mysql_fetch_array(mysql_query($sql));
if($row){
    echo $row[$column];
}else{
    echo 'NO EXISTE INFORMACION';
}