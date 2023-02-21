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
$rango_seccion_b = [
    'persona.edad_total<12', //menor 12 meses
    'persona.edad_total>=12 and persona.edad_total<=17',
    'persona.edad_total>=18 and persona.edad_total<=23',
    'persona.edad_total>=24 and persona.edad_total<=35',
    'persona.edad_total>=36 and persona.edad_total<=47',
    'persona.edad_total>=48 and persona.edad_total<=59',
];
$label_rango_seccion_b = [
    'menores 12 meses',
    'desde 12 meses a 17 meses',
    'desde 18 meses a 23 meses',
    'desde 24 meses a 35 meses',
    'desde 36 meses a 47 meses',
    'desde 48 meses a 59 meses',

];
?>
<section id="seccion_b" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCION B: POBLACION EN CONTROL SEGÚN RESULTADO DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR</header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_b" style="width: 100%;border: solid 1px black;" border="1">
                <tr>
                    <td colspan="2">RESULTADO Y GRUPOS DE EDAD</td>
                    <td>TOTAL</td>
                    <td>HOMBRES</td>
                    <td>MUJERES</td>
                    <td>PUEBLOS ORIGINARIOS</td>
                    <td>POBLACION MIGRANTE</td>
                </tr>
                <?php
                $estados = ['NORMAL', 'NORMAL C/REZAGO', 'RIESGO', 'RETRASO'];
                foreach ($estados as $i => $estado) {
                    $i_esatdo = 0;

                    foreach ($rango_seccion_b as $j => $rango) {
                        ?>
                        <tr>
                            <?php

                            if ($i_esatdo == 0) {
                                ?>
                                <td rowspan="6"><?php echo $estado; ?></td>
                                <?php
                            }

                            $sql = "select COUNT(*) as total,
                                           sum(persona.sexo='M') AS HOMBRES,
                                           sum(persona.sexo='F') AS MUJERES
                                    from paciente_psicomotor inner join persona using(rut)
                                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno,
                                         (
                                            select historial_paciente.rut from historial_paciente
                                            inner join paciente_establecimiento using (rut)
                                            inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                            inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                            inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                            inner join persona on paciente_establecimiento.rut=persona.rut
                                            where m_infancia='SI'
                                              $filtro_centro
                                            and TIMESTAMPDIFF(DAY,historial_paciente.fecha_registro,CURRENT_DATE)<365
                                            group by historial_paciente.rut
                                            order by historial_paciente.id_historial desc
                                        ) as personas  
                                    where personas.rut=persona.rut 
                                    and tepsi='$estado' AND $rango 
                                    ;";
                            $total_hombres = $total_mujeres = 0;
                            //PACIENTES TEPSI
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $total_hombres = $row['HOMBRES'];
                                $total_mujeres = $row['MUJERES'];
                            }

                            $sql = "select COUNT(*) as total,
                                           sum(persona.sexo='M') AS HOMBRES,
                                           sum(persona.sexo='F') AS MUJERES
                                    from paciente_psicomotor inner join persona using(rut)
                                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno,
                                         (
                                            select historial_paciente.rut from historial_paciente
                                            inner join paciente_establecimiento using (rut)
                                            inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                            inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                            inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                            inner join persona on paciente_establecimiento.rut=persona.rut
                                            where m_infancia='SI'
                                              $filtro_centro
                                            and TIMESTAMPDIFF(DAY,historial_paciente.fecha_registro,CURRENT_DATE)<365
                                            group by historial_paciente.rut 
                                            order by historial_paciente.id_historial desc
                                        ) as personas     
                                    where personas.rut=persona.rut
                                    and eedp='$estado' AND $rango";

                            $row = mysql_fetch_array(mysql_query($sql));
                            //PACIENTES EEDP
                            if ($row) {
                                $total_hombres += $row['HOMBRES'];
                                $total_mujeres += $row['MUJERES'];
                            }


                            $sql = "select COUNT(*) as total from paciente_psicomotor inner join persona using(rut)
                                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno,
                                         (
                                            select historial_paciente.rut from historial_paciente
                                            inner join paciente_establecimiento using (rut)
                                            inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                            inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                            inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                            inner join persona on paciente_establecimiento.rut=persona.rut
                                            where m_infancia='SI' and persona.pueblo='SI'
                                              $filtro_centro
                                            and TIMESTAMPDIFF(DAY,historial_paciente.fecha_registro,CURRENT_DATE)<365
                                            group by historial_paciente.rut
                                            order by historial_paciente.id_historial desc
                                        ) as personas  
                                    where personas.rut=persona.rut 
                                    and tepsi='$estado' AND $rango 
                                    ;";
                            $total_pueblo = 0;
                            //PACIENTES TEPSI
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $total_pueblo = $row['total'];
                            }

                            $sql = "select COUNT(*) as total,
                                    from paciente_psicomotor inner join persona using(rut)
                                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno,
                                         (
                                            select historial_paciente.rut from historial_paciente
                                            inner join paciente_establecimiento using (rut)
                                            inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                            inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                            inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                            inner join persona on paciente_establecimiento.rut=persona.rut
                                            where m_infancia='SI' and persona.migrante='SI'
                                              $filtro_centro
                                            and TIMESTAMPDIFF(DAY,historial_paciente.fecha_registro,CURRENT_DATE)<365
                                            group by historial_paciente.rut 
                                            order by historial_paciente.id_historial desc
                                        ) as personas     
                                    where personas.rut=persona.rut
                                    and eedp='$estado' AND $rango";

                            $row = mysql_fetch_array(mysql_query($sql));
                            //PACIENTES EEDP
                            $total_migrante = 0;
                            if ($row) {
                                $total_migrante += $row['total'];
                            }

                            ?>

                            <td><?php echo $label_rango_seccion_b[$j]; ?></td>
                            <td><?php echo($total_hombres + $total_mujeres); ?></td>
                            <td><?php echo($total_hombres); ?></td>
                            <td><?php echo($total_mujeres); ?></td>
                            <td><?php echo($total_pueblo); ?></td>
                            <td><?php echo($total_migrante); ?></td>
                        </tr>

                        <?php
                        $i_esatdo++;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</section>
