<?php
include "../../php/config.php";


$sql1 = "select * from historial_parametros_pscv 
where indicador='vfg' order by id_historial asc";
$res1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($res1)){
    $valor = $row1['valor'];
    $rut = $row1['rut'];

    $sql2 = "update parametros_pscv set vfg='$valor' where rut='$rut' ";
    mysql_query($sql2);
    echo $sql2;
}
