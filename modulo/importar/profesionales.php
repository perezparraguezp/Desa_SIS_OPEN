<link rel="stylesheet" type="text/css" href="http://www.jqueryeasy.com/wp-content/themes/bigfoot/style.css"
      media="screen"/>
<link rel="alternate" type="application/rss+xml" title="jQuery Easy RSS Feed" href="http://www.jqueryeasy.com/feed/"/>
<link rel="alternate" type="application/atom+xml" title="jQuery Easy Atom Feed"
      href="http://www.jqueryeasy.com/feed/atom/"/>
<link rel="pingback" href="http://www.jqueryeasy.com/xmlrpc.php"/>
<link rel="shortcut icon" href="http://www.jqueryeasy.com/wp-content/themes/bigfoot/images/favicon.ico"/>
<link rel='stylesheet' id='wp-pagenavi-css'
      href='http://www.jqueryeasy.com/wp-content/plugins/wp-pagenavi/pagenavi-css.css?ver=2.70' type='text/css'
      media='all'/>
<script type='text/javascript' src='http://www.jqueryeasy.com/wp-includes/js/l10n.js?ver=20101110'></script>
<script type='text/javascript' src='http://www.jqueryeasy.com/wp-includes/js/jquery/jquery.js?ver=1.6.1'></script>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www.jqueryeasy.com/xmlrpc.php?rsd"/>
<link rel="wlwmanifest" type="application/wlwmanifest+xml"
      href="http://www.jqueryeasy.com/wp-includes/wlwmanifest.xml"/>
<link rel='index' title='jQuery Easy' href='http://www.jqueryeasy.com/'/>
<meta name="generator" content="WordPress 3.2.1"/>
<!-- All in One SEO Pack 1.6.13.8 by Michael Torbert of Semper Fi Web Design[280,300] -->
<meta name="description"
      content="Blog donde podrás encontrar una serie artículos, tutoriales,  relacionados a la creación de aplicaciones web, utilizando las últimas tecnologías que actualmente existen como jQuery, PHP, Mysql, CSS3 y mas."/>
<meta name="keywords"
      content="aplicaciones, jquery,css,php,html,javascript,java,aplicaciones jquery,seo,android,codeinigter,xml, aplicaciones codeigniter, cursos jquery, cursos, tutoriales"/>
<link rel="canonical" href="http://www.jqueryeasy.com/"/>
<!-- /all in one seo pack -->
<link href="http://www.jqueryeasy.com/wp-content/plugins/fuzzy-seo-booster/seoqueries.css" rel="stylesheet"
      type="text/css"/>
<!-- START: Syntax Highlighter ComPress -->
<script type="text/javascript"
        src="http://www.jqueryeasy.com/wp-content/plugins/syntax-highlighter-compress/scripts/shCore.js"></script>
<script type="text/javascript"
        src="http://www.jqueryeasy.com/wp-content/plugins/syntax-highlighter-compress/scripts/shAutoloader.js"></script>
<link type="text/css" rel="stylesheet"
      href="http://www.jqueryeasy.com/wp-content/plugins/syntax-highlighter-compress/styles/shCoreDefault.css"/>
<!-- END: Syntax Highlighter ComPress -->
<style type="text/css">.recentcomments a {
        display: inline !important;
        padding: 0 !important;
        margin: 0 !important;
    }</style>
<script language="javascript" type="text/javascript"
        src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/jquery.js"></script>
<script language="javascript" type="text/javascript"
        src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/tabber.js"></script>
<script language="javascript" type="text/javascript"
        src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/superfish.js"></script>
<!--[if lt IE 7]>
<script type="text/javascript" src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/pngfix.js"></script>
<script type="text/javascript" src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/menu.js"></script>
<link rel="stylesheet" type="text/css" media="all"
      href="http://www.jqueryeasy.com/wp-content/themes/bigfoot/css/ie.css"/>
<![endif]-->
<style type="text/css">
    #demos {
        width: 100%;
        margin: 10px auto 0 auto;
        padding: 30px;
        border: 1px solid #DFDFDF;
        font: normal 12px Arial, Helvetica, sans-serif
    }

    #demos h3 {
        border-bottom: 1px solid #DFDFDF;
        padding-bottom: 7px;
        margin: 10px 0
    }

    table {
        margin-top: 15px;
        width: 100%
    }

    table td {
        padding: 7px;
        border: 1px solid #CCC
    }

    #loading {
        display: none;
    }

</style>
<hr style="margin-top: 10px;"/>
<div id="loading" style="width: 100%;text-align: center;">
    <img src="../loding.gif" width="300"/>
    <br/>
    <header>CARGANDO DATOS</header>
</div>
<div id="demos">
    <h3>CARGAR ARCHIVO EXCEL</h3>
    <hr/>
    <form name="frmload" method="post" action="profesionales.php" enctype="multipart/form-data">
        <input type="file" name="file"/>
        <br/>
        <hr/>
        <br/>
        <input type="submit" style="background-color: #438eb9;color: white;padding: 10px;"
               value="----- IMPORTAR LISTADO DE PACIENTES -----" onclick=""/>
    </form>
    <div id="show_excel">
        <?php
        include("../../php/config.php");

        error_reporting(0);


        if (@$_FILES['file']['name'] != '') {
            ?>
            <script type="text/javascript">
                $('#loading').show()
            </script>
            <?php

            require_once 'reader/Classes/PHPExcel/IOFactory.php';

            //Funciones extras

            function get_cell($cell, $objPHPExcel)
            {
                //select one cell
                $objCell = ($objPHPExcel->getActiveSheet()->getCell($cell));
                //get cell value
                return $objCell->getvalue();
            }

            function pp(&$var)
            {
                $var = chr(ord($var) + 1);
                return true;
            }

            $name = $_FILES['file']['name'];
            $tname = $_FILES['file']['tmp_name'];
            $type = $_FILES['file']['type'];

            if ($type == 'application/vnd.ms-excel') {
                // Extension excel 97
                $ext = 'xls';
            } else if ($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                // Extension excel 2007 y 2010
                $ext = 'xlsx';
            } else {
                // Extension no valida
                echo -1;
                exit();
            }

            //$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha);

            $xlsx = 'Excel2007';
            $xls = 'Excel5';

            //creando el lector
            $objReader = PHPExcel_IOFactory::createReader($$ext);

            //cargamos el archivo
            $objPHPExcel = $objReader->load($tname);

            $dim = $objPHPExcel->getActiveSheet()->calculateWorksheetDimension();

            // list coloca en array $start y $end
            list($start, $end) = explode(':', $dim);

            if (!preg_match('#([A-Z]+)([0-9]+)#', $start, $rslt)) {
                return false;
            }
            list($start, $start_h, $start_v) = $rslt;
            if (!preg_match('#([A-Z]+)([0-9]+)#', $end, $rslt)) {
                return false;
            }
            list($end, $end_h, $end_v) = $rslt;
            $error = '';
            for ($v = $start_v; $v <= $end_v; $v++) {
                //empieza lectura horizontal
                $fechas = "";
                $coma = 0;
                if ($v != 1) {
                    $fila = array();
                    $rut = '';

                    for ($h = $start_h; ord($h) <= ord($end_h); pp($h)) {
                        $cellValue = get_cell($h . $v, $objPHPExcel);//valido que exista datos en la celda

                        if ($h == "B") {
                            $dato = $cellValue;
                            $rut = $cellValue;
                        } else {
                            $dato = $cellValue;
                        }
                        $fila[$h] = $dato;
                    }

                    if ($rut != '') {
                        if (valida_rut($rut) == true) {
                            $nombre = $fila['A'];
                            $rut = str_replace(".", "", $fila['B']);
                            list($clave, $dv) = explode('-', $rut);
                            $correo = $fila['C'];
                            $telefono = $fila['D'];
                            $tipo = $fila['E'];

                            $id_establecimiento = 1;
                            $duplicado = false;
                            $sql0 = "select * from persona where rut='$rut' limit 1";

                            $row0 = mysql_fetch_array(mysql_query($sql0));
                            if ($row0) {
                                //no se puede sobre escribir los datos personales de un paciente
                                $error .= '<div style="padding: 5px;background-color: #ff898b;margin-bottom: 2px;border: solid 2px red;">EL RUT INGRESADO SE ENCUENTRA DUPLICADO, ERROR EN LA FILA ' . $v . ', NO SE PUEDE REGISTRAR</div>';
                            } else {

                                $sql1 = "insert into persona(rut,nombre_completo,telefono,email) 
                                  values('$rut',upper('$nombre'),'$telefono','$correo')";

                                mysql_query($sql1);

                                $sql2 = "insert into personal_establecimiento(rut,id_establecimiento,fecha_inicio,indefinido,tipo_contrato) 
                                  values('$rut','$id_establecimiento',current_date(),'SI',UPPER('$tipo'))";
                                mysql_query($sql2);
                                $row2 = mysql_fetch_array(mysql_query("select * from personal_establecimiento where rut='$rut' limit 1"));
                                $id_profesional = $row2['id_profesional'];

                                $sql3 = "insert into usuarios(rut,clave,tipo_usuario,id_profesional) 
                                  values('$rut','$clave',UPPER('$tipo'),'$id_profesional')";
                                mysql_query($sql3);

                                if ($correo != '') {
                                    $para = $correo;

                                    $titulo = 'BIENVENIDO A SIS EH-OPEN';
                                    $mensaje = '<!DOCTYPE html>
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
                                                          <p>Estimado(a) '.$nombre.',</p>
                                                          <p>Te informamos que ya formas parte de la red SIS OPEN, para lo cual te adjunto tus credenciales de acceso para registrar tus atenciones.</p>
                                                          <p>LINK DE ACCESO <a href="http://imperial.sis-open.com" target="_blank">INGRESAR</a> (imperial.sis-open.com).</p>
                                                          <p>USUARIO: ' . $rut . '</p>
                                                          <p>CLAVE DE ACCESO: ' . $clave . '</p>
                                                          <p></p>
                                                          <p>Favor modifica tu clave para que nadie pueda acceder a tu perfil sin tu autorización.</p>
                                                        </div>
                                                        <div class="footer">
                                                          <p>©' . date("Y") . ' Todos los derechos reservados.</p>
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

                                $error .= '<div style="padding: 5px;background-color: #d7efff;margin-bottom: 2px;border: solid 2px blue;">CAMBIOS REGISTRADOS CORRECTAMENTE FILA  ' . $v . ', PERSONA REGISTRADA EN SECTOR ' . $sql1 . '</div>';
                            }
                        } else {
                            $error .= '<div style="padding: 5px;background-color: #ff898b;margin-bottom: 2px;border: solid 2px red;">EL RUT INGRESADO NO ES VALIDO EN LA FILA ' . $v . ', NO SE PUEDE REGISTRAR</div>';
                        }
                    } else {
                        $error .= '<div style="padding: 5px;background-color: #ff898b;margin-bottom: 2px;border: solid 2px red;">NO EXISTE RUT EN LA FILA ' . $v . ', NO SE PUEDE REGISTRAR</div>';
                    }
                }//fin if cabecera de excel
            }
            echo $error;

        }

        ?>
        <script type="text/javascript">
            $('#loading').css({
                'display': 'none'
            })
        </script>
        <?php

        ?>
    </div>
</div>