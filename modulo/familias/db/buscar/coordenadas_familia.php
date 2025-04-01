<?php

include '../../../../php/config.php';


$id_familia = $_POST['id_familia'];

$sql = "select * from familia where id_familia='$id_familia' limit 1";
$row = mysql_fetch_array(mysql_query($sql));
if($row){
    $lat = $row['ubicacion_x'];
    $lon = $row['ubicacion_y'];
    if($lat!='' && $lon!=''){
        $html = 'https://www.google.com/maps?q='.$lat.','.$lon;
    }else{
        $html = '';
    }
    echo $html;
}else{
    echo 'ERROR';
}

