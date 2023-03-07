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

$rango_seccion_j = [
    'persona.edad_total_dias>=0 and persona.edad_total_dias<30*12', //menor 1 AÑO
    'persona.edad_total_dias>=(30*12*1) and persona.edad_total_dias<(30*12*2)',//
    'persona.edad_total_dias>=(30*12*2) and persona.edad_total_dias<(30*12*3)',//
    'persona.edad_total_dias>=(30*12*3) and persona.edad_total_dias<(30*12*4)',//
    'persona.edad_total_dias>=(30*12*4) and persona.edad_total_dias<(30*12*5)',//
    'persona.edad_total_dias>=(30*12*5) and persona.edad_total_dias<(30*12*6)',//
    'persona.edad_total_dias>=(30*12*6) and persona.edad_total_dias<(30*12*7)',//
    'persona.edad_total_dias>=(30*12*7) and persona.edad_total_dias<(30*12*8)',//
    'persona.edad_total_dias>=(30*12*8) and persona.edad_total_dias<(30*12*9)',//

    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.pueblo!='NO'",//PUEBLOS ORIGINARIOS
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//MIGRANTES

    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//DISCAPACIDAD
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//MEJOR NIÑEZ
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//SENAME
];

$label_rango_seccion_j = [
    '< 1 AÑO>', //menor 1 mes
    '1 AÑO',//
    '2 AÑO',//
    '3 AÑO',//
    '4 AÑO',//
    '5 AÑO',//
    '6 AÑO',//
    '7 AÑO',//
    '8 AÑO',//
    '9 AÑO',//
];
?>
<section id="seccion_j" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION J: POBLACIÓN EN CONTROL, SEGÚN RIESGO ODONTOLÓGICO Y DAÑO POR CARIES
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_c" style="width: 100%;border: solid 1px black;" border="1">
                <tr>
                    <td rowspan="3" colspan="2">INDICADOR ODONTOLÓGICO Y PARÁMETROS DE MEDICIÓN</td>
                    <td rowspan="2" colspan="3">TOTAL</td>
                    <td colspan="<?php echo (count($rango_seccion_j) - 2) * 2; ?>">GRUPOS DE EDAD  Y SEXO</td>
                    <td colspan="2" rowspan="2">PUEBLOS ORIGINARIOS</td>
                    <td colspan="2" rowspan="2">POBLACION MIGRANTE</td>
                    <td colspan="2" rowspan="2">USUARIOS CON DISCAPACIDAD</td>
                    <td colspan="2" rowspan="2">NIÑOS Y NIÑAS RED MEJOR NIÑEZ</td>
                    <td colspan="2" rowspan="2">NIÑOS Y NIÑAS RED SENAME</td>
                </tr>
                <tr>
                    <?php
                    foreach ($label_rango_seccion_j as $i => $label) {
                        ?>
                        <td COLSPAN="2"><?php echo $label; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td style="background-color: #fdff8b">AMBOS</td>
                    <td style="background-color: #fdff8b">HOMBRES</td>
                    <td style="background-color: #fdff8b">HOMBRES</td>
                    <?php
                    $label_sexo = ['HOMBRE', 'MUJER'];
                    foreach ($rango_seccion_j as $i => $rango) {

                        foreach ($label_sexo as $s => $value) {
                            ?>
                            <td><?php echo $value; ?></td>
                            <?php
                        }

                    }
                    ?>
                </tr>
                <tr>
                    <td colspan="2">TOTAL DE NIÑOS(AS) EN CONTROL CON ENFOQUE DE RIESGO ODONTOLÓGICO</td>
                </tr>
                <tr>
                    <td>EVALUACIÓN DE RIESGO SEGÚN PAUTA CERO</td>
                    <?php
                    $estados = ['ALTO RIESGO ', 'BAJO RIESGO ', 'TOTAL'];
                    $tr = '';
                    foreach ($estados as $estado) {
                        $total_estado = 0;
                        $td = '';
                        foreach ($rango_seccion_j as $i => $rango) {
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
                        $tr .= '<td>' . $estado . '</td>
                                <td>' . $total_estado . '</td>';
                        $tr .= $td.'</tr><tr>';
                    }
                    $tr = '</tr>';
                    echo $tr;
                    ?>
                </tr>
                <?php
                $sql1 = "select * from tipos_nanea 
                              order by id_nanea";
                $res1 = mysql_query($sql1);
                $FILA = array();
                $filtro_total = '';
                while ($row = mysql_fetch_array($res1)) {
                    $indicador = trim($row['nanea']);
                    $TOTAL = array();
                    $tr = '<tr>
                                        <td>' . $indicador . '</td>';
                    $fila = '';
                    foreach ($rango_seccion_h as $i => $rango) {
                        foreach ($sexo as $i => $s) {
                            $sql2 = "select count(*) as total from persona 
                                            inner join paciente_establecimiento using (rut) 
                                            inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                            where id_establecimiento='$id_establecimiento' 
                                            and m_infancia='SI'  
                                            and $s and $rango 
                                            $filtro_centro 
                                            AND upper(nanea) like '%$indicador%'
                                            limit 1";
                            $row2 = mysql_fetch_array(mysql_query($sql2));
                            if($i<=16){
                                if ($row2) {
                                    $TOTAL[$label_sexo[$i]] += $row2['total'];
                                } else {
                                    $TOTAL[$label_sexo[$i]] += 0;
                                }
                            }

                            $fila .= '<td>' . $row2['total'] . '</td>';
                        }

                    }
                    $filtro_total .= " OR upper(nanea) like '%$indicador%' ";
                    $fila = ' <td style="background-color: #fdff8b">' . ($TOTAL['HOMBRE'] + $TOTAL['MUJER']) . '</td>
                                  <td style="background-color: #fdff8b">' . ($TOTAL['HOMBRE']) . '</td>
                                  <td style="background-color: #fdff8b">' . ($TOTAL['MUJER']) . '</td>'
                        . $fila;

                    $tr = $tr . $fila . '</tr>';
                    echo $tr;
                }

                ?>
            </table>
        </div>
    </div>
</section>
