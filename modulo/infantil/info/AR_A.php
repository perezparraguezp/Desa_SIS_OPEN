<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';

$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";

$hasta = $_POST['hasta'];
$desde = $_POST['desde'];
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

$rango_seccion_h = [

    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>0  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30 ", //menor 1 mes
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*2 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*2  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*3 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*3  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*4 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*4  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*5 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*5  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*6 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*6  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*7 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*7  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*11 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*11  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*17 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*17  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*23 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*23  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*35 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*35  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*41 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*41  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*47 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*47  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*59 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*59  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*71 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*71  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*84 ", //
    " and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')>30*84  and TIMESTAMPDIFF(day , fecha_nacimiento, '" . $hasta . "')<=30*108 ", //


];

$label_rango_seccion_h = [
    'menor de 1 mes', //menor 1 mes
    '1 mes',//un mes
    '2 meses',//dos meses
    '3 meses',//dos meses
    '4 meses',//dos meses
    '5 meses',//dos meses
    '6 meses',//dos meses
    '7 a 11 meses',//7 a 11 meses
    '12 a 17 meses',//12 a 17 meses
    '18 a 23 meses',//18 a 23 meses
    '24 a 35 meses',//24 a 35 meses
    '36 a 41 meses',//36 a 41 meses
    '42 a 47 meses',//42 a 47 meses
    '48 a 59 meses',//48 a 59 meses
    '60 a 71 meses', //entre 60 meses a 71 meses
    '6 a 7 años',//desde los 6 a 7 años
    '8 a 9 años',//desde los 6 a 7 años
];


?>

<section id="seccion_h" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>POBLACIÓN EN CONTROL PROGRAMA DE SALUD DE NIÑOS, NIÑAS Y ADOLESCENTE CON NECESIDADES ESPECIALES.
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_c" style="width: 100%;border: solid 1px black;" border="1">
                <tr>
                    <td rowspan="3" COLSPAN="2">NIÑOS, NIÑAS Y ADOLESCENTE CON NECESIDADES ESPECIALES - NANEAS</td>
                    <td rowspan="2" colspan="3">TOTAL</td>
                    <td colspan="<?php echo (count($rango_seccion_h)) * 2; ?>">GRUPOS DE EDAD Y SEXO</td>

                </tr>
                <tr>
                    <?php
                    foreach ($label_rango_seccion_h as $i => $label) {
                        ?>
                        <td COLSPAN="2"><?php echo $label; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td style="background-color: #fdff8b">AMBOS</td>
                    <td style="background-color: #fdff8b">MUJERES</td>
                    <td style="background-color: #fdff8b">HOMBRES</td>
                    <?php
                    $label_sexo = ['HOMBRE', 'MUJER'];
                    foreach ($rango_seccion_h as $i => $rango) {

                        foreach ($label_sexo as $s => $value) {
                            ?>
                            <td><?php echo $value; ?></td>
                            <?php
                        }

                    }
                    ?>
                </tr>
                <?php
                $estados = ['DNI'];
                $rango_seccion_b = [
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' "
                ];
                $label_rango_seccion_b = [
                    'RIESGO DE DESNUTRICION / DEFICIT PONDERAL',
                    'DESNUTRIDO',
                    'SOBREPESO / RIESGO OBESIDAD',
                    'OBESO',
                    'OBESO SEVERO',
                    'NORMAL',
                    'SUBTOTAL',
                    'DESNUTRICION SECUNDARIA',
                    'TOTAL',

                ];
                $sql_item = [
                    " and valor='RI DESNUTRICION' ",
                    " and valor='DESNUTRICION' ",
                    " and valor='SOBREPESO' ",
                    " and valor='OBESIDAD' ",
                    " and valor='OB SEVERA' ",
                    " and valor='NORMAL' ",
                    " and (valor='NORMAL' OR valor='OB SEVERA' OR valor='OBESIDAD' OR valor='SOBREPESO' OR valor='DESNUTRICION' OR valor='RI DESNUTRICION'  ) ",
                    " and valor='DESNUTRICION SECUNDARIA' ",
                    " and (valor='NORMAL' OR valor='OB SEVERA' OR valor='OBESIDAD' OR valor='SOBREPESO' OR valor='DESNUTRICION' OR valor='RI DESNUTRICION' OR valor='DESNUTRICION SECUNDARIA'  ) "

                ];
                foreach ($estados as $i => $estado) {
                    $i_esatdo = 0;

                    foreach ($rango_seccion_b as $j => $rango) {
                        $fila = '<tr>';
                        $fila1 = '';

                        if ($i_esatdo == 0) {
                            $fila .= '<td rowspan="' . count($label_rango_seccion_b) . '">' . $estado . '</td>';
                            $i_esatdo++;
                        }
                        $fila .= '<td>' . $label_rango_seccion_b[$j] . '</td>';
                        $indicador = $sql_item[$j];
                        $total_hombres = 0;
                        $total_mujeres = 0;

                        foreach ($rango_seccion_h as $m => $rango_edad) {
                            if ($id_centro == '') {
                                $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno,
                                         (
                                             select historial_antropometria.rut from historial_antropometria
                                                INNER join persona p on historial_antropometria.rut = p.rut
                                                where indicador='DNI'
                                                  " . $indicador . "
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_antropometria.fecha_registro <= '" . $hasta . "'
                                                and historial_antropometria.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        and paciente_establecimiento.m_infancia='SI' ";
                            } else {
                                $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                         inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno,
                                         (
                                             select historial_antropometria.rut from historial_antropometria
                                                INNER join persona p on historial_antropometria.rut = p.rut
                                                where indicador='DNI'
                                                  " . $indicador . "
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_antropometria.fecha_registro <= '" . $hasta . "'
                                                and historial_antropometria.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        and paciente_establecimiento.m_infancia='SI' 
                                        and centros_internos.id_centro_interno='" . $id_centro . "' ";
                            }
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $hombres = $row['HOMBRES'];
                                $mujeres = $row['MUJERES'];
                            } else {
                                $hombres = 0;
                                $mujeres = 0;
                            }
                            $fila1 .= '<td>' . $hombres . '</td>';
                            $fila1 .= '<td>' . $mujeres . '</td>';

                            $total_hombres += $hombres;
                            $total_mujeres += $mujeres;

                        }
                        $fila .= '<td>' . ($total_mujeres + $total_hombres) . '</td>' .
                            '<td>' . $total_mujeres . '</td>' .
                            '<td>' . $total_mujeres . '</td>' . $fila1;

                        $fila .= '</tr>';
                        echo $fila;
                        ?>

                        <?php
                    }
                }
                ?>

                <?php
                //grado de complejidad
                $estados = ['GRADO DE COMPLEJIDAD NANEAS'];
                $rango_seccion_b = [
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' "
                ];
                $label_rango_seccion_b = [
                    'BAJA',
                    'MEDIANA',
                    'ALTA',
                    'TOTAL',

                ];
                $sql_item = [
                    " and complejidad='BAJA' ",
                    " and complejidad='MEDIA' ",
                    " and complejidad='ALTA' ",
                    " and (complejidad='BAJA' OR  complejidad='ALTA' OR complejidad='BAJA') "

                ];
                foreach ($estados as $i => $estado) {
                    $i_esatdo = 0;

                    foreach ($rango_seccion_b as $j => $rango) {
                        $fila = '<tr>';
                        $fila1 = '';

                        if ($i_esatdo == 0) {
                            $fila .= '<td rowspan="' . count($label_rango_seccion_b) . '">' . $estado . '</td>';
                            $i_esatdo++;
                        }
                        $fila .= '<td>' . $label_rango_seccion_b[$j] . '</td>';
                        $indicador = $sql_item[$j];
                        $total_hombres = 0;
                        $total_mujeres = 0;

                        foreach ($rango_seccion_h as $m => $rango_edad) {
                            if ($id_centro == '') {
                                $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno,
                                         (
                                             select historial_antropometria.rut from historial_antropometria
                                                INNER join persona p on historial_antropometria.rut = p.rut
                                                where indicador='DNI'
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_antropometria.fecha_registro <= '" . $hasta . "'
                                                and historial_antropometria.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        " . $indicador . "
                                        and paciente_establecimiento.m_infancia='SI' ";
                            } else {
                                $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                         inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno,
                                         (
                                             select historial_antropometria.rut from historial_antropometria
                                                INNER join persona p on historial_antropometria.rut = p.rut
                                                where indicador='DNI'
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_antropometria.fecha_registro <= '" . $hasta . "'
                                                and historial_antropometria.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        and paciente_establecimiento.m_infancia='SI'
                                        " . $indicador . " 
                                        and centros_internos.id_centro_interno='" . $id_centro . "' ";
                            }
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $hombres = $row['HOMBRES'];
                                $mujeres = $row['MUJERES'];
                            } else {
                                $hombres = 0;
                                $mujeres = 0;
                            }
                            $fila1 .= '<td>' . $hombres . '</td>';
                            $fila1 .= '<td>' . $mujeres . '</td>';

                            $total_hombres += $hombres;
                            $total_mujeres += $mujeres;

                        }
                        $fila .= '<td>' . ($total_mujeres + $total_hombres) . '</td>' .
                            '<td>' . $total_mujeres . '</td>' .
                            '<td>' . $total_mujeres . '</td>' . $fila1;

                        $fila .= '</tr>';
                        echo $fila;
                        ?>

                        <?php
                    }
                }
                ?>

                <?php
                //VDI ATENCIONES
                $estados = ['VISITAS DOMICILIARIAS INTEGRAL'];
                $rango_seccion_b = [
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' "
                ];
                $label_rango_seccion_b = [
                    'BAJA',
                    'MEDIANA',
                    'ALTA',
                    'TOTAL',

                ];
                $sql_item = [
                    " and complejidad='BAJA' ",
                    " and complejidad='MEDIA' ",
                    " and complejidad='ALTA' ",
                    " and (complejidad='BAJA' OR  complejidad='ALTA' OR complejidad='BAJA') "

                ];
                foreach ($estados as $i => $estado) {
                    $i_esatdo = 0;

                    foreach ($rango_seccion_b as $j => $rango) {
                        $fila = '<tr>';
                        $fila1 = '';

                        if ($i_esatdo == 0) {
                            $fila .= '<td rowspan="' . count($label_rango_seccion_b) . '">' . $estado . '</td>';
                            $i_esatdo++;
                        }
                        $fila .= '<td>' . $label_rango_seccion_b[$j] . '</td>';
                        $indicador = $sql_item[$j];
                        $total_hombres = 0;
                        $total_mujeres = 0;

                        foreach ($rango_seccion_h as $m => $rango_edad) {
                            if ($id_centro == '') {
                                $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno,
                                         (
                                             select historial_paciente.rut from historial_paciente
                                                INNER join persona p on historial_paciente.rut = p.rut
                                                where tipo_historial='VDI'
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_paciente.fecha_registro <= '" . $hasta . "'
                                                and historial_paciente.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        " . $indicador . "
                                        and paciente_establecimiento.m_infancia='SI' ";
                            } else {
                                $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                         inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno,
                                         (
                                             select historial_paciente.rut from historial_paciente
                                                INNER join persona p on historial_paciente.rut = p.rut
                                                where tipo_historial='VDI'
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_paciente.fecha_registro <= '" . $hasta . "'
                                                and historial_paciente.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        and paciente_establecimiento.m_infancia='SI'
                                        " . $indicador . " 
                                        and centros_internos.id_centro_interno='" . $id_centro . "' ";
                            }
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $hombres = $row['HOMBRES'];
                                $mujeres = $row['MUJERES'];
                            } else {
                                $hombres = 0;
                                $mujeres = 0;
                            }
                            $fila1 .= '<td>' . $hombres . '</td>';
                            $fila1 .= '<td>' . $mujeres . '</td>';

                            $total_hombres += $hombres;
                            $total_mujeres += $mujeres;

                        }
                        $fila .= '<td>' . ($total_mujeres + $total_hombres) . '</td>' .
                            '<td>' . $total_mujeres . '</td>' .
                            '<td>' . $total_mujeres . '</td>' . $fila1;

                        $fila .= '</tr>';
                        echo $fila;
                        ?>

                        <?php
                    }
                }
                ?>


                <?php
                //VDI INASISTENTE
                $estados = ['POBLACION INASISTENTE A CONTROL'];
                $rango_seccion_b = [
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' ",
                    "DNI='' "
                ];
                $label_rango_seccion_b = [
                    'BAJA',
                    'MEDIANA',
                    'ALTA',
                    'TOTAL',
                    'RESCATE'
                ];
                $sql_item = [
                    " and complejidad='BAJA' ",
                    " and complejidad='MEDIA' ",
                    " and complejidad='ALTA' ",
                    " and (complejidad='BAJA' OR  complejidad='ALTA' OR complejidad='BAJA') ",
                    " and (complejidad='BAJA' OR  complejidad='ALTA' OR complejidad='BAJA') "

                ];
                foreach ($estados as $i => $estado) {
                    $i_esatdo = 0;

                    foreach ($rango_seccion_b as $j => $rango) {
                        $fila = '<tr>';
                        $fila1 = '';

                        if ($i_esatdo == 0) {
                            $fila .= '<td rowspan="' . count($label_rango_seccion_b) . '">' . $estado . '</td>';
                            $i_esatdo++;
                        }

                        $fila .= '<td>' . $label_rango_seccion_b[$j] . '</td>';

                        $indicador = $sql_item[$j];
                        $total_hombres = 0;
                        $total_mujeres = 0;

                        foreach ($rango_seccion_h as $m => $rango_edad) {
                            if($label_rango_seccion_b[$j]=="RESCATE"){
                                //pacientes en rescate
                                if ($id_centro == '') {
                                    $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno,
                                         (
                                               select historial_paciente.rut from historial_paciente
                                                INNER join persona p on historial_paciente.rut = p.rut
                                                where tipo_historial='RESCATE'
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_paciente.fecha_registro <= '" . $hasta . "'
                                                and historial_paciente.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        " . $indicador . "
                                        and paciente_establecimiento.m_infancia='SI' ";
                                } else {
                                    $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                         inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno,
                                         (
                                              select historial_paciente.rut from historial_paciente
                                                INNER join persona p on historial_paciente.rut = p.rut
                                                where tipo_historial='RESCATE'
                                                  " . $rango_edad . "
                                                and p.nanea!=''
                                                and historial_paciente.fecha_registro <= '" . $hasta . "'
                                                and historial_paciente.fecha_registro >= '" . $desde . "'
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        and paciente_establecimiento.m_infancia='SI'
                                        " . $indicador . " 
                                        and centros_internos.id_centro_interno='" . $id_centro . "' ";
                                }
                            }else{
                                if ($id_centro == '') {
                                    $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno,
                                         (
                                              select agendamiento.rut
                                                 from agendamiento
                                                          INNER join persona p on agendamiento.rut = p.rut
                                                 where estado_control = 'PENDIENTE'
                                                     " . $rango_edad . "
                                                   and p.nanea != ''
                                                   and agendamiento.mes_proximo_control <= month('" . $desde . "')
                                                   and agendamiento.anio_proximo_control >= year('" . $desde . "')
                                                 group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        " . $indicador . "
                                        and paciente_establecimiento.m_infancia='SI' ";
                                } else {
                                    $sql = "select 
                                   COUNT(*) as total,
                                   sum(persona.sexo = 'M') AS HOMBRES,
                                   sum(persona.sexo = 'F') AS MUJERES
                                    from  persona
                                         inner join paciente_establecimiento on persona.rut = paciente_establecimiento.rut
                                         inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                         inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno,
                                         (
                                              select agendamiento.rut
                                                 from agendamiento
                                                          INNER join persona p on agendamiento.rut = p.rut
                                                 where estado_control = 'VDI'
                                                     " . $rango_edad . "
                                                   and p.nanea != ''
                                                   and agendamiento.mes_proximo_control <= month('" . $desde . "')
                                                   and agendamiento.anio_proximo_control >= year('" . $desde . "')
                                                 group by p.rut
                                                group by p.rut
                                         ) as personas
                                        where personas.rut = persona.rut
                                        and paciente_establecimiento.m_infancia='SI'
                                        " . $indicador . " 
                                        and centros_internos.id_centro_interno='" . $id_centro . "' ";
                                }
                            }

                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $hombres = $row['HOMBRES'];
                                $mujeres = $row['MUJERES'];
                            } else {
                                $hombres = 0;
                                $mujeres = 0;
                            }
                            $fila1 .= '<td>' . $hombres . '</td>';
                            $fila1 .= '<td>' . $mujeres . '</td>';

                            $total_hombres += $hombres;
                            $total_mujeres += $mujeres;

                        }
                        $fila .= '<td>' . ($total_mujeres + $total_hombres) . '</td>' .
                            '<td>' . $total_mujeres . '</td>' .
                            '<td>' . $total_mujeres . '</td>' . $fila1;

                        $fila .= '</tr>';
                        echo $fila;
                        ?>

                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</section>