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

$rango_seccion_c = [
    'persona.edad_total_dias>0 and persona.edad_total<=12', //menor 10 dias
    'persona.edad_total_dias<10', //menor 10 dias
    'persona.edad_total=1',
    'persona.edad_total=2',
    'persona.edad_total=3',
    'persona.edad_total=4',
    'persona.edad_total=5',
    'persona.edad_total=6',
    'persona.edad_total>6 and persona.edad_total<=12',
    'persona.edad_total<=12',
    "persona.pueblo='SI' AND persona.edad_total>0 and persona.edad_total<=12 ",
    "persona.migrante='SI' AND persona.edad_total>0 and persona.edad_total<=12 ",

];

$label_rango_seccion_c = [
    'TOTAL',
    'menor de 10 dias',
    '1 mes',
    '2 meses',
    '3 meses',
    '4 meses',
    '5 meses',
    '6 meses',
    '7 A 12 meses',
    'Total de Niños y Niñas que han Recibido VDI',
    'PUEBLOS ORIGINARIOS',
    'POBLACION MIGRANTE',
];
?>
<section id="seccion_c" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION C: POBLACIÓN MENOR DE 1 AÑO EN CONTROL, SEGÚN SCORE RIESGO EN IRA Y VISITA DOMICILIARIA
                INTEGRAL EN EL SEMESTRE
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_c" style="width: 100%;border: solid 1px black;" border="1">
                <tr>
                    <td colspan="2">RESULTADO</td>
                    <?php
                    foreach ($rango_seccion_c as $i => $rango) {
                        ?>
                        <td><?php echo $label_rango_seccion_c[$i]; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                $indicadores = ['SCORE DE RIESGO'];
                $estados = ["SCORE_IRA='LEVE'",
                            "SCORE_IRA='MODERADO'",
                            "SCORE_IRA='GRAVE'",
                            "(SCORE_IRA='GRAVE' or SCORE_IRA='MODERADO' ) "];
                $label_estados = ["LEVE", "MODERADO", "GRAVE", "TOTAL"];
                $i_esatdo = 0;
                foreach ($estados as $i => $estado) {
                    ?>
                    <tr>
                        <?php
                        if ($i_esatdo == 0) {
                            ?>
                            <td rowspan="4"><?php echo $indicadores[$i_esatdo]; ?></td>
                            <?php
                            $i_esatdo++;
                        }
                        ?>
                        <td><?php echo $label_estados[$i]; ?></td>

                        <?php
                        foreach ($rango_seccion_c as $j => $rango) {

                            if ($id_centro != '') {
                                $sql = "select COUNT(*) as total
                                    from antropometria inner join persona using(rut)
                                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    where sectores_centros_internos.id_centro_interno='$id_centro' 
                                    and m_infancia='SI'
                                    and $estado AND $rango 
                                    $filtro_centro;";

                            } else {
                                $sql = "select COUNT(*) as total
                                    from antropometria inner join persona using(rut)
                                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    where m_infancia='SI'
                                    and $estado AND $rango ;";

                            }




                            if ($i == 0 && $j == 9) {
                                ?>
                                <td style="background-color: gray;"></td>
                                <?php
                            } else {

                                $total = 0;
                                $row = mysql_fetch_array(mysql_query($sql));
                                if ($row) {
                                    $total = $row['total'];
                                }

                                ?>
                                <td><?php echo $total; ?></td>
                                <?php
                            }

                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</section>
