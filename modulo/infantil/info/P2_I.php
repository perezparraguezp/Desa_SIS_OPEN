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

$rango_seccion_i = [
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

$label_rango_seccion_i = [
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
<section id="seccion_i" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION I: POBLACIÓN SEGÚN NIVEL DE COMPLEJIDAD DE NIÑOS, NIÑAS Y ADOLESCENTES CON NECESIDADES ESPECIALES DE ATENCIÓN EN SALUD (NANEAS) (Incluida en sección A y A1)
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_i" style="width: 70%;border: solid 1px black;" border="1">
                <tr>
                    <td rowspan="3">NIVELES DE COMPLEJIDAD</td>
                    <td rowspan="2" colspan="3">TOTAL</td>
                    <td colspan="<?php echo (count($rango_seccion_i) - 2) * 2; ?>">GRUPOS DE EDAD Y SEXO</td>
                    <td colspan="2" rowspan="2">PUEBLOS ORIGINARIOS</td>
                    <td colspan="2" rowspan="2">POBLACION MIGRANTE</td>
                </tr>
                <tr>
                    <?php
                    foreach ($label_rango_seccion_i as $i => $value) {
                        echo '<td colspan="2">' . $value . '</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td style="background-color: #fdff8b">AMBOS</td>
                    <td style="background-color: #fdff8b">HOMBRES</td>
                    <td style="background-color: #fdff8b">HOMBRES</td>
                    <?php
                    $label_sexo = ['HOMBRE', 'MUJER'];
                    foreach ($rango_seccion_i as $i => $rango) {

                        foreach ($label_sexo as $s => $value) {
                            ?>
                            <td><?php echo $value; ?></td>
                            <?php
                        }
                    }
                    ?>
                </tr>
                <?php
                $estados = ['TOTAL POBLACIÓN NANES BAJO CONTROL','BAJA COMPLEJIDAD	', 'MEDIANA COMPLEJIDAD','ALTA COMPLEJIDAD'];
                $estados_sql = [''," AND complejidad='BAJA'"," AND complejidad='MEDIA'"," AND complejidad='ALTA'"];

                foreach ($estados as $f => $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';
                    $total_hombres = 0;
                    $total_mujeres = 0;
                    foreach ($rango_seccion_i as $i => $rango) {
                        $sql = "select
                                          sum(persona.sexo='M') as HOMBRES,
                                          sum(persona.sexo='F') as MUJERES
                                        from persona 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        and nanea!='' and nanea!='NO' and $rango
                                        $filtro_centro $estados_sql[$f] 
                                        ";

                        $row = mysql_fetch_array(mysql_query($sql));
                        if ($row) {
                            $hombres = $row['HOMBRES'];
                            $mujeres = $row['MUJERES'];
                        } else {
                            $hombres = 0;
                            $mujeres = 0;
                        }
                        if($i<14){
                            $total_estado += $hombres+$mujeres;
                            $total_hombres += $hombres;
                            $total_mujeres += $mujeres;
                        }


                        $td .= '<td>' . $hombres . '</td>';
                        $td .= '<td>' . $mujeres . '</td>';

                    }
                    $tr .= '<td>' . $estado . '</td>'.
                            '<td>' . $total_estado . '</td>' .
                            '<td>' . $total_hombres . '</td>' .
                            '<td>' . $total_mujeres . '</td>' . $td;
                    $tr .= '</tr>';
                    echo $tr;
                }
                ?>
            </table>
        </div>
    </div>
</section>
