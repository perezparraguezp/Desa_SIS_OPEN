
<?php
include "../../php/config.php";
include "../../php/objetos/profesional.php";

$menu = $_POST['menu'];

session_start();


$myId = $_SESSION['id_usuario'];

$id_establecimiento = $_SESSION['id_establecimiento'];


$profesional = new profesional($_SESSION['id_usuario']);


?>
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2"
            style="background-image: url(sis_rem.png);width: 100%;">
            <div class="row" style="height: 60px;">

            </div>
        </li>
        <li id="menu_2" onclick="loadMenu_REM('menu_2','registro_atencion','')"class="bold"><a href="#" class="waves-effect waves-cyan"><i class="mdi-action-account-child"></i> Registro REM</a></li>
        <li id="menu_5" onclick="loadMenu_REM('menu_5','registro_touch','')"class="bold"><a href="#" class="waves-effect waves-cyan"><i class="mdi-maps-pin-drop"></i> REGISTRO TOUCH</a></li>
        <li id="menu_3" onclick="loadMenu_REM('menu_3','informe','')"class="bold"><a href="#" class="waves-effect waves-cyan"><i class="mdi-action-account-child"></i> INFORMES REM</a></li>
        <li id="menu_4" onclick="loadMenu_REM('menu_4','ubicacion','')"class="bold"><a href="#" class="waves-effect waves-cyan"><i class="mdi-maps-pin-drop"></i> Ubicaciones REM</a></li>

        <li class="bold"><a href="../../php/salir.php" class="waves-effect waves-cyan"><i class="mdi-action-lock"></i> CERRAR SESSIÓN </a></li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only darken-2"><i class="mdi-navigation-menu" ></i></a>
</aside>