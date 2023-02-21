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

$label_rango_seccion_g = [
    '4 a 11 meses',
    '12 a 23 meses',
    '24 a 35 meses',
    '36 a 47 meses',
    '48 a 59 meses',
    '60 a 71 meses'
];
$rango_seccion_g = [
    'persona.edad_total>=4 and persona.edad_total<=11',//36 a 47 meses
    'persona.edad_total>=12 and persona.edad_total<=23',//48 6 a 71 meses
    'persona.edad_total>=24 and persona.edad_total<=35',//48 6 a 71 meses
    'persona.edad_total>=36 and persona.edad_total<=47',//48 6 a 71 meses
    'persona.edad_total>=48 and persona.edad_total<=59',//48 6 a 71 meses
    'persona.edad_total>=60 and persona.edad_total<=71',//48 6 a 71 meses
];
?>
<section id="seccion_g" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION G: POBLACIÓN INFANTIL EUTRÓFICA, SEGÚN RIESGO DE MALNUTRICIÓN POR EXCESO (Incluida en
                Seccion A y A1)
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_g" style="width: 70%;border: solid 1px black;" border="1">
                <tr>
                    <td rowspan="2">RESULTADO</td>
                    <td rowspan="2">TOTAL</td>
                    <td colspan="6">GRUPO DE EDAD</td>
                </tr>
                <tr>
                    <?php
                    foreach ($label_rango_seccion_g as $i => $value) {
                        echo '<td>' . $value . '</td>';
                    }
                    ?>
                </tr>
                <?php
                $estados = ['SIN RIESGO', 'CON RIESGO'];

                foreach ($estados as $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';
                    foreach ($rango_seccion_g as $i => $rango) {
                        $sql = "select
                                          sum(RIMALN='$estado' and $rango) as total
                                        from persona
                                        inner join antropometria on persona.rut=antropometria.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro
                                        ";
                        $row = mysql_fetch_array(mysql_query($sql));
                        if ($row) {
                            $total = $row['total'];
                        } else {
                            $total = 0;
                        }
                        $total_estado += $total;
                        $td .= '<td>' . $total . '</td>';

                    }
                    $tr .= '<td>' . $estado . '</td><td>' . $total_estado . '</td>' . $td;
                    $tr .= '</tr>';
                    echo $tr;
                }
                ?>
            </table>
        </div>
    </div>
</section>
