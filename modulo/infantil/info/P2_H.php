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

$rango_seccion_h = [
    'persona.edad_total_dias>=0 and persona.edad_total_dias<30', //menor 1 mes
    'persona.edad_total_dias>=(30*1) and persona.edad_total_dias<(30*2)',//un mes
    'persona.edad_total_dias>=(30*2) and persona.edad_total_dias<(30*3)',//dos meses
    'persona.edad_total_dias>=(30*3) and persona.edad_total_dias<(30*4)',//tres meses
    'persona.edad_total_dias>=(30*4) and persona.edad_total_dias<(30*5)',//cuatro meses
    'persona.edad_total_dias>=(30*5) and persona.edad_total_dias<(30*6)',//cinco meses
    'persona.edad_total_dias>=(30*6) and persona.edad_total_dias<(30*7)',//cinco meses
    'persona.edad_total_dias>=(30*7) and persona.edad_total_dias<(30*12)',//7 a 11 meses
    'persona.edad_total_dias>=(30*12) and persona.edad_total_dias<(30*18)',//12 a 17 meses
    'persona.edad_total_dias>=(30*18) and persona.edad_total_dias<(30*24)',//18 a 23 meses
    'persona.edad_total_dias>=(30*24) and persona.edad_total_dias<(30*36)',//24 a 35 meses
    'persona.edad_total_dias>=(30*36) and persona.edad_total_dias<(30*42)',//36 a 41 meses
    'persona.edad_total_dias>=(30*42) and persona.edad_total_dias<(30*48)',//42 a 47 meses
    'persona.edad_total_dias>=(30*48) and persona.edad_total_dias<(30*60)',//48 a 59 meses

    'persona.edad_total_dias>=(60*30) and persona.edad_total_dias<(72*30)', //entre 60 meses a 71 meses
    'persona.edad_total_dias>=(30*12*6) and persona.edad_total_dias<=(30*12*7)',//desde los 6 a 7 años
    'persona.edad_total_dias>=(30*12*8) and persona.edad_total_dias<=(30*12*9)',//desde los 8 a 9 años

    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*60) and persona.pueblo!='NO'",//PUEBLOS ORIGINARIOS
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*60) and persona.migrante!='NO'",//MIGRANTES
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
            <header>SECCION H: POBLACIÓN INFANTIL SEGÚN DIAGNÓSTICO DE NANEAS (incluidas en sección A y A.1)
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_c" style="width: 100%;border: solid 1px black;" border="1">
                <tr>
                    <td rowspan="3">DIAGNOSTICOS</td>
                    <td rowspan="2" colspan="3">TOTAL</td>
                    <td colspan="<?php echo (count($rango_seccion_h) - 2) * 2; ?>">GRUPOS DE EDAD Y SEXO</td>
                    <td colspan="2" rowspan="2">PUEBLOS ORIGINARIOS</td>
                    <td colspan="2" rowspan="2">POBLACION MIGRANTE</td>
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
                    <td style="background-color: #fdff8b">HOMBRES</td>
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
                $sql1 = "select * from tipos_nanea where vigencia='SI'
                              order by orden asc";
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
