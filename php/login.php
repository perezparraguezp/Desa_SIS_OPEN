<?php

$hostname = "localhost";
$database = "sisopenc_desarrollo";
$username = "sisopenc_desa";
$password = "Ehopen2022$$";

if (!($conexion = mysql_connect($hostname, $username, $password))) {
    echo "Error conectando a la base de datos.";
    exit();
}

if (!mysql_select_db($database, $conexion)) {
    echo "Error seleccionando la base de datos.";
    exit();
}

$password = $_POST['password'];
$username = str_replace(".","",$_POST['username']);

$sql = "select * from usuarios inner join personal_establecimiento on usuarios.rut=personal_establecimiento.rut
            where usuarios.rut='$username' and clave='$password'
            limit 1";

$row = mysql_fetch_array(mysql_query($sql));
if($row){
    session_start();

    $_SESSION['id_usuario'] = $row['id_profesional'];
    $_SESSION['rut'] = $row['rut'];
    $_SESSION['id_establecimiento'] = $row['id_establecimiento'];
    $_SESSION['tipo_usuario'] = $row['tipo_contrato'];
    $_SESSION['ultimo_ingreso'] = $row['ultimo_ingreso'];

    $_SESSION['login'] = 'true';
    //actualizamos las edades
    mysql_query("UPDATE usuarios SET ultimo_ingreso=now() where rut='$username' ");

    header('Location: ../i.php?LOGIN=TRUE');
}else{
    header('Location: ../index.php?LOGIN=FALSE');
}

