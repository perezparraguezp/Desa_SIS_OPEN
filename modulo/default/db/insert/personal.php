<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';
include '../../../../php/objetos/persona.php';


$id_establecimiento = $_SESSION['id_establecimiento'];

$tipo_contrato   = $_POST['tipo_contrato'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$indefinido = $_POST['indefinido'];
$rut = str_replace(".","",$_POST['rut']);//limpiamos caracteres
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$horas = $_POST['horas'];

$mysql = new mysql($_SESSION['id_usuario']);
$mysql->insert_persona($rut,$nombre,$telefono,$email);
$p = new persona($rut);

if($_POST['indefinido']){
    $hasta = 'INDEFINIDO';
}
$p->insert_contrato($rut,$tipo_contrato,$desde,$hasta,$horas,$id_establecimiento);
$id_profesional = $p->getIDProfesional($rut,$id_establecimiento);
$p->insertUsuario($rut,$id_establecimiento,$tipo_contrato,$id_profesional);
list($clave, $dv) = explode("-", $rut);
if($email!=''){
    $para      = $email;
    $mensaje   = '';
    $titulo    = 'BIENVENIDO A SIS EH-OPEN';
    $mensaje   = '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Correo electrónico profesional</title>
  <style>
    /* Estilos para el contenido del correo */
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }
    .header {
      background-color: #f2f2f2;
      padding: 10px;
      text-align: center;
    }
    .logo {
      max-width: 150px;
    }
    .content {
      background-color: #fff;
      padding: 20px;
    }
    .footer {
      background-color: #f2f2f2;
      padding: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="https://desarrollo.sis-open.com/images/logo_eh_open_05x.png" alt="Logo" class="logo">
      <h1>Bienvenido a nuestra Plataforma - SIS OPEN</h1>
    </div>
    <div class="content">
      <p>Estimado(a),</p>
      <p>Te informamos que ya formas parte de la red SIS OPEN, para lo cual te adjunto tus credenciales de acceso para registrar tus atenciones.</p>
      <p>LINK DE ACCESO <a href="http://imperial.sis-open.com" target="_blank">INGRESAR</a> (imperial.sis-open.com).</p>
      <p>USUARIO: '.$rut.'</p>
      <p>CLAVE DE ACCESO: '.$clave.'</p>
      <p></p>
      <p>Favor modifica tu clave para que nadie pueda acceder a tu perfil sin tu autorización.</p>
    </div>
    <div class="footer">
      <p>©'.date("Y").' Todos los derechos reservados.</p>
    </div>
  </div>
</body>
</html>
';
    $cabeceras = 'From: soporte@eh-open.com' . "\r\n" .
        'Reply-To: soporte@eh-open.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $cabeceras .= "MIME-Version: 1.0" . "\r\n";
    $cabeceras .= "Content-type: text/html; charset=UTF-8" . "\r\n";

// Otras cabeceras opcionales (por ejemplo, para establecer la dirección de respuesta)



    mail($para, $titulo, $mensaje, $cabeceras);
}


