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


$label_rango_seccion_f = [
    '36 a 47 meses',
    '48 6 a 71 meses',
    '6 a 9 años',
];
$rango_seccion_f = [
    'persona.edad_total>=36 and persona.edad_total<=47',//36 a 47 meses
    'persona.edad_total>=48 and persona.edad_total<=71',//48 6 a 71 meses
    'persona.edad_total>=(12*6) and persona.edad_total<=(12*9)',//desde los 8 a 9 años
];
?>
<section id="seccion_f" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION F: POBLACIÓN INFANTIL SEGÚN DIAGNÓSTICO DE PRESIÓN ARTERIAL (Incluida en Seccion A y A1)
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_f" style="width: 50%;border: solid 1px black;" border="1">
                <tr>
                    <td rowspan="2">CLASIFICACION</td>
                    <td rowspan="2">TOTAL</td>
                    <td colspan="3">GRUPO DE EDAD</td>
                </tr>
                <tr>
                    <?php
                    foreach ($label_rango_seccion_f as $i => $value) {
                        echo '<td>' . $value . '</td>';
                    }
                    ?>
                </tr>
                <?php
                $estados = ['NORMAL', 'PRE-HIPERTENSION', 'ETAPA 1', 'ETAPA 2'];

                foreach ($estados as $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';
                    foreach ($rango_seccion_f as $i => $rango) {
                        $sql = "select
                                          sum(presion_arterial='$estado' and $rango) as total
                                        from persona
                                        inner join antropometria on persona.rut=antropometria.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno 
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro ";
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
