<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';

$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";


$id_establecimiento = $_SESSION['id_establecimiento'];

$id_centro = $_POST['id'];
if ($id_centro != '') {
    $filtro_centro = " and id_centro_interno='$id_centro' ";
    $sql0 = "select * from centros_internos 
                              WHERE id_centro_interno='$id_centro' limit 1";
    $row0 = mysql_fetch_array(mysql_query($sql0));
    $nombre_centro = $row0['nombre_centro_interno'];
} else {
    $nombre_centro = 'TODOS LOS CENTROS';
    $filtro_centro = '';
}

$sexo = [
    "persona.sexo='M' ",
    "persona.sexo='F' "
];
?>

<section id="seccion_d" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION D: POBLACIÓN EN CONTROL EN EL SEMESTRE CON CONSULTA NUTRICIONAL, SEGÚN ESTRATEGIA
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_d" style="width: 50%;border: solid 1px black;" border="1">
                <tr>
                    <td>NIÑO/A CON CONSULTA NUTRICIONAL EN</td>
                    <td>TOTAL</td>
                </tr>
                <tr>
                    <td>DEL 5TO MES</td>
                    <td></td>
                </tr>
                <tr>
                    <td>DE LOS 3 AÑOS Y 6 MESES</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</section>
