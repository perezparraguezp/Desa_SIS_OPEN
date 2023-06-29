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
    'persona.edad_total_dias>=(30*12*1) and persona.edad_total_dias<(30*12*2)',//1 AÑO
    'persona.edad_total_dias>=(30*12*2) and persona.edad_total_dias<(30*12*3)',//2 AÑOS
    'persona.edad_total_dias>=(30*12*3) and persona.edad_total_dias<(30*12*4)',//3 AÑOS
    'persona.edad_total_dias>=(30*12*4) and persona.edad_total_dias<(30*12*5)',//4 AÑOS
    'persona.edad_total_dias>=(30*12*5) and persona.edad_total_dias<(30*12*6)',//5 AÑOS
    'persona.edad_total_dias>=(30*12*6) and persona.edad_total_dias<(30*12*7)',//6
    'persona.edad_total_dias>=(30*12*7) and persona.edad_total_dias<(30*12*8)',//7
    'persona.edad_total_dias>=(30*12*8) and persona.edad_total_dias<(30*12*9)',//8
    'persona.edad_total_dias>=(30*12*9) and persona.edad_total_dias<(30*12*10)',//9

    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.pueblo!='NO'",//PUEBLOS ORIGINARIOS
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//MIGRANTES

    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//DISCAPACIDAD
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO'",//MEJOR NIÑEZ
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*12*9) and persona.migrante!='NO' ",//SENAME
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
$estados = ['ALTO RIESGO ', 'BAJO RIESGO ', 'TOTAL'];

$estados_sql = ["paciente_dental.factor_riesgo='ALTO' ", "paciente_dental.factor_riesgo='BAJO' ", "(paciente_dental.factor_riesgo='ALTO' or paciente_dental.factor_riesgo='BAJO' )",];

$estados_indice = ['0', '1 a 2', '3 a 4', '5 a 6', '7 a 8', '9 o más', 'TOTAL '];
$estados_indice_sql = [
    "paciente_dental.indice like '%0%' ",
    "paciente_dental.indice like '%1%' ",
    "paciente_dental.indice like '%3%' ",
    "paciente_dental.indice like '%5%' ",
    "paciente_dental.indice like '%7%' ",
    "paciente_dental.indice like '%9%' ",
    "paciente_dental.indice!='' "];


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
                    <td colspan="<?php echo (count($rango_seccion_j) - 5) * 2; ?>">GRUPOS DE EDAD Y SEXO</td>
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
                    <td style="background-color: #fdff8b">HOMBRE</td>
                    <td style="background-color: #fdff8b">MUJER</td>
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
                    <?php
                    $td = '';
                    $tr = '';
                    $total_h = 0;
                    $total_m = 0;
                    $estado = "(paciente_dental.factor_riesgo='ALTO' or paciente_dental.factor_riesgo='BAJO' ) 
                                and paciente_dental.indice!='' ";
                    foreach ($rango_seccion_j as $i => $rango) {
                        $sql = "select
                                          sum($estado and $rango and persona.sexo='M' ) as total_hombre,
                                          sum($estado and $rango and persona.sexo='F' ) as total_mujer
                                        from persona
                                        inner join paciente_dental on persona.rut=paciente_dental.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno 
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro ";

                        $row = mysql_fetch_array(mysql_query($sql));
                        if ($row) {
                            $total_hombres = $row['total_hombre'];
                            $total_mujeres = $row['total_mujer'];
                        } else {
                            $total_mujeres = 0;
                            $total_hombres = 0;
                        }

                        if ($i < 10) {
                            $total_h += $total_hombres;
                            $total_m += $total_mujeres;
                        }


                        $td .= '<td>' . $total_hombres . '</td>';
                        $td .= '<td>' . $total_mujeres . '</td>';

                    }
                    $tr .= '<td>' . ($total_m + $total_h) . '</td>
                                <td>' . $total_h . '</td>
                                <td>' . $total_m . '</td>';
                    $tr .= $td;
                    echo $tr;
                    ?>
                </tr>
                <tr>
                    <td rowspan="<?php echo count($estados); ?>">EVALUACIÓN DE RIESGO SEGÚN PAUTA CERO</td>
                    <?php

                    $tr = '';
                    foreach ($estados_sql as $e => $estado) {
                        $total_estado = 0;
                        $td = '';
                        $total_h = 0;
                        $total_m = 0;
                        foreach ($rango_seccion_j as $i => $rango) {
                            $sql = "select
                                          sum($estado and $rango and persona.sexo='M' ) as total_hombre,
                                          sum($estado and $rango and persona.sexo='F' ) as total_mujer
                                        from persona
                                        inner join paciente_dental on persona.rut=paciente_dental.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno 
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro ";

                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $total_hombres = $row['total_hombre'];
                                $total_mujeres = $row['total_mujer'];
                            } else {
                                $total_mujeres = 0;
                                $total_hombres = 0;
                            }

                            if ($i < 10) {
                                $total_h += $total_hombres;
                                $total_m += $total_mujeres;
                            }


                            $td .= '<td>' . $total_hombres . '</td>';
                            $td .= '<td>' . $total_mujeres . '</td>';

                        }
                        $tr .= '<td>' . $estados[$e] . '</td>
                                <td>' . ($total_m + $total_h) . '</td>
                                <td>' . $total_h . '</td>
                                <td>' . $total_m . '</td>';
                        $tr .= $td . '</tr><tr>';
                    }


                    $tr .= '</tr>';
                    echo $tr;
                    ?>
                </tr>

                <tr>
                    <td rowspan="<?php echo count($estados_indice); ?>">EVALUACIÓN DE DAÑO POR CARIES SEGÚN ÍNDICE ceod
                        O COPD
                    </td>
                    <?php

                    $tr = '';
                    foreach ($estados_indice_sql as $e => $indice) {
                        $total_estado = 0;
                        $td = '';
                        $total_h = 0;
                        $total_m = 0;
                        foreach ($rango_seccion_j as $i => $rango) {
                            $sql = "select
                                          sum($indice and $rango and persona.sexo='M' ) as total_hombre,
                                          sum($indice and $rango and persona.sexo='F' ) as total_mujer
                                        from persona
                                        inner join paciente_dental on persona.rut=paciente_dental.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno 
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro ";

                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $total_hombres = $row['total_hombre'];
                                $total_mujeres = $row['total_mujer'];
                            } else {
                                $total_mujeres = 0;
                                $total_hombres = 0;
                            }

                            if ($i < 10) {
                                $total_h += $total_hombres;
                                $total_m += $total_mujeres;
                            }


                            $td .= '<td>' . $total_hombres . '</td>';
                            $td .= '<td>' . $total_mujeres . '</td>';

                        }
                        $tr .= '<td>' . $estados_indice[$e] . '</td>
                                <td>' . ($total_m + $total_h) . '</td>
                                <td>' . $total_h . '</td>
                                <td>' . $total_m . '</td>';
                        $tr .= $td . '</tr><tr>';
                    }


                    $tr .= '</tr>';
                    echo $tr;
                    ?>
                </tr>


                <tr>
                    <td colspan="2">INASISTENTES A CONTROL ODONTOLÓGICO</td>
                    <?php

                    $tr = '';
                    $td = '';
                    $indice = "paciente_dental.dental_asistente='AUSENTE' ";
                    $total_h = 0;
                    $total_m = 0;
                    foreach ($rango_seccion_j as $i => $rango) {
                        $sql = "select
                                          sum($indice and $rango and persona.sexo='M' ) as total_hombre,
                                          sum($indice and $rango and persona.sexo='F' ) as total_mujer
                                        from persona
                                        inner join paciente_dental on persona.rut=paciente_dental.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno 
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro ";

                        $row = mysql_fetch_array(mysql_query($sql));
                        if ($row) {
                            $total_hombres = $row['total_hombre'];
                            $total_mujeres = $row['total_mujer'];
                        } else {
                            $total_mujeres = 0;
                            $total_hombres = 0;
                        }

                        if ($i < 10) {
                            $total_h += $total_hombres;
                            $total_m += $total_mujeres;
                        }


                        $td .= '<td>' . $total_hombres . '</td>';
                        $td .= '<td>' . $total_mujeres . '</td>';

                    }
                    $tr .= '<td>' . ($total_m + $total_h) . '</td>
                                <td>' . $total_h . '</td>
                                <td>' . $total_m . '</td>';
                    $tr .= $td ;



                    echo $tr;
                    ?>
                </tr>
            </table>
        </div>
    </div>
</section>
