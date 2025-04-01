<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';
include '../../../../php/objetos/familia.php';
session_start();

$rut = $_POST['profesional_cita'];
$id_familia = $_POST['rut'];
$texto = $_POST['mensaje'];


$persona = new persona($rut);
$profesional  = new persona($_SESSION['rut']);
$familia = new familia($id_familia);
$para      = $persona->email;

$mensaje   = '';
$titulo    = 'CASO DERIVADO - CODIGO FAMILIA '.$familia->codigo_familia;
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
      <h1>Mensaje desde Plataforma - SIS OPEN - MODULO FAMILIA</h1>
    </div>
    <div class="content">
      <p>Estimado(a),</p>
      <p>Te informamos que se ha derivado un caso con el siguiente mensaje:</p>
      <p>'.$texto.'</p>
      <p>El caso fue derivado por el profesional: '.$profesional->nombre.'</p>
      
      <p>LINK DE ACCESO <a href="http://imperial.sis-open.com" target="_blank">INGRESAR</a> (imperial.sis-open.com).</p>
      
      <p>No responder este mensaje, dado que es un mensaje enviado automaticamente por plataforma.</p>
  
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

echo 'MENSAJE ENVIADO AL PROFESIONAL';