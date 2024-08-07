<?php

include "php/objetos/profesional.php";

$LOGIN = $_GET['LOGIN'];
if($LOGIN=='TRUE'){
    //header('Location: escritorio.php');
}
session_start();


?>
<!DOCTYPE html>
<html lang="es">

<!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 1.0
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>SELECCIONAR MODULO | EH-OPEN SOFTWARE</title>


    <!-- Favicons-->
    <link rel="icon" href="images/O.ico" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="images/O.ico">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/O.ico">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->

    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

</head>

<body class="light">
<a id="btn-modal" class="modal-trigger" href="#modal"></a>
<div id="modal" class="modal modal-fixed-footer">
</div>
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>

<!-- End Page Loading -->
<style type="text/css">
    @media only screen
    and (min-device-width : 320px)
    and (max-device-width : 568px) { /* Aquí van los estilos */
        img{
            width: 50%;
        }
    }
    a{
        border: none;
        text-decoration: none;
    }
    /*a:hover{
        background-color: red;
    }*/
    img.responsive-img, video.responsive-video {
        max-width: 90%;
    }
    .PANEL_MENU_SIS:hover{
        background-color: #e8eaf6;
        cursor: pointer;
    }
    .PANEL_MENU_SIS_INVACTIVO{
        background-color: rgba(204,204,221,0.86);
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col l6 m6 s12" style="position: relative;top: 0px;left: 0px;">
        <div class="card-panel center" >
            <div class="col l12 m12 s12">
                <div class="card-panel" style="background-color: #0a73a7;">
                    <div class="row" style="color: #ffffff";>
                        <div class="col l12 m12 s12">
                            <strong>MODULOS DISPONIBLES</strong>
                        </div>
                    </div>
                </div>
                <div class="card-panel PANEL_MENU_SIS">
                    <div class="row">
                        <div class="col l4 m4 s4">
                            <i class="mdi-action-accessibility small"></i>
                        </div>
                        <div class="col l8 m8 s8">
                            <a style="color: black" href="modulo/some/index.php" target="_blank">
                                <strong>INGRESO DE PACIENTES</strong>
                            </a>
                        </div>
                    </div>
                </div>
                <?php

                include('php/config.php');

                session_start();
                $id_establecimiento = $_SESSION['id_establecimiento'];
                $rut = $_SESSION['rut'];
                $myId = $_SESSION['id_usuario'];


                $profesional = new profesional($myId);

                $sql = "select * from modulos_ehopen 
                        order by id_modulo";

                $res = mysql_query($sql);

                while($row = mysql_fetch_array($res)){
                    $id_modulo = $row['id_modulo'];
                    $sql1 = "select * from menu_usuario 
                            where upper(rut)=upper('$rut') 
                              and id_modulo='$id_modulo' 
                              and id_establecimiento='$id_establecimiento' 
                              limit 1";
                    $row1 = mysql_fetch_array(mysql_query($sql1));
                    if($row1){
                        echo  $row['html'];
                    }else{
                        echo  $row['html'];
                    }

                }
                ?>

                <?php
                if($_SESSION['tipo_usuario']=='ADMINISTRADOR'){
                    ?>
                    <div class="card-panel PANEL_MENU_SIS">
                        <div class="row">
                            <div class="col l4 m4 s4">
                                <i class="mdi-action-settings-applications"></i>
                            </div>
                            <div class="col l8 m8 s8">
                                <a style="color: black" href="modulo/default/index.php" target="_blank">
                                    <strong>AJUSTES GENERALES</strong>
                                </a>
                            </div>
                        </div>
                    </div>
                    <BR>  <?php
                }
                ?><BR>

            </div>

            <!-- <hr class="row"> -->

            <div class="row" class="card-panel PANEL_MENU_SIS">
                <div class="col l12 s12 m12">
                    <a href="salir.php" class="btn waves-effect waves-light" style="width: 97%;">CERRAR SESSION</a>
                </div>
            </div>
            <br>
            <div>
                <div class="row">
                    Para Obtener Soporte escribanos <a href="mailto:contacto@eh-open.com">CONTACTO@EH-OPEN.COM</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col l6 m6 s12" style="position: relative;top: 0px;right: 0px;">
        <div class="card-panel">
            <div class="container center-align">
                <img src="images/aviso_carahue.png" width="70%" />
            </div>
            <div class="card-panel" style="font-size: 0.8em;">
                <div class="row">
                    <div class="col l6 ">
                        <div style="font-size: 0.7em;text-align: right;">Usuario:</div>
                        <div style="font-size: 0.7em;text-align: right;"><?PHP echo $_SESSION['tipo_usuario']; ?></div>
                    </div>
                    <div class="col l6">
                        <div   style="font-size: 0.7em;text-align: right;">Último Ingreso:</div>
                        <div  style="font-size: 0.7em;text-align: right;"><?PHP echo $_SESSION['ultimo_ingreso']; ?></div>
                    </div>
                    <br>
                </div>
                <hr class="row" />
                <div class="row">
                    <div class="col l4 center">
                        <img src="perfil.jpeg" width="75%;"/>
                    </div>
                    <div class="col l8" style="text-align: left;">
                        <?php
                        $profesional = new profesional($myId);
                        ?>
                        <div class="row">
                            <div class="col l12"><label>Nombre Completo</label></div>
                        </div>
                        <div class="row">
                            <div class="col l12"><?php echo $profesional->nombre; ?></div>
                        </div>
                        <hr class="row" />
                        <div class="row">
                            <div class="col l12"><label>Teléfono</label></div>
                        </div>
                        <div class="row">
                            <div class="col l12"><?php echo $profesional->telefono; ?></div>
                        </div>
                        <hr class="row" />
                        <div class="row">
                            <div class="col l12"><label>E-mail</label></div>
                        </div>
                        <div class="row">
                            <div class="col l12"><?php echo $profesional->email; ?></div>
                        </div>
                    </div>
                </div>
                <hr class="row" />

                <div class="row">
                    <div class="col l12">
                        <a onclick="boxEditarInfoProfesional()">EDITAR INFORMACION</a>
                    </div>

                </div>
                <script type="text/javascript">
                    function boxEditarInfoProfesional(){
                        $.post('modulo/default/formulario/editar_my_perfil.php',{
                            rut:'<?php echo $myId ?>',
                        },function(data){
                            if(data !== 'ERROR_SQL'){
                                $("#modal").html(data);
                                $("#modal").css({'width':'800px'});
                                document.getElementById("btn-modal").click();
                            }
                        });
                    }
                </script>
            </div>
        </div>
    </div>

</div>

<!-- ================================================
  Scripts
  ================================================ -->


<!-- jQuery Library -->
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.js"></script>
<!--prism-->
<script type="text/javascript" src="js/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.js"></script>

</body>

</html>