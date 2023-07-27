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
    "persona.edad_total>=36  and persona.edad_total<=(12*9) and antropometria.atencion_secundaria='SI'",//desde los 8 a 9 años
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
                    <td rowspan="3">CLASIFICACION</td>
                    <td rowspan="2" COLSPAN="3">TOTAL</td>
                    <td colspan="6" rowspan="1">GRUPO DE EDAD</td>
                    <td colspan="1" rowspan="3">Derivación Nivel Secundario</td>
                </tr>
                <tr>
                    <?php
                    foreach ($label_rango_seccion_f as $i => $value) {
                        echo '<td colspan="2">' . $value . '</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td>TOTAL</td>
                    <td>HOMBRES</td>
                    <td>MUJERES</td>

                    <td>HOMBRES</td>
                    <td>MUJERES</td>
                    <td>HOMBRES</td>
                    <td>MUJERES</td>
                    <td>HOMBRES</td>
                    <td>MUJERES</td>
                </tr>
                <?php
                $estados = ['NORMAL', 'PRE-HIPERTENSION', 'ETAPA 1', 'ETAPA 2'];

                foreach ($estados as $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';
                    foreach ($rango_seccion_f as $i => $rango) {
                        $sql = "select
                                          sum(presion_arterial='$estado' and $rango and persona.sexo='M') as total_hombres,
                                          sum(presion_arterial='$estado' and $rango and persona.sexo='F') as total_mujeres,
                                          sum(presion_arterial='$estado' and $rango ) as total_general
                                        from persona
                                        inner join antropometria on persona.rut=antropometria.rut 
                                        inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                        inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno 
                                        where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                        $filtro_centro ";
                        $row = mysql_fetch_array(mysql_query($sql));
                        if ($row) {
                            $total_hombres = $row['total_hombres'];
                            $total_mujeres = $row['total_mujeres'];
                        } else {
                            $total_hombres = 0;
                            $total_mujeres = 0;
                        }



                        if($i==3){
                            $td .= '<td>' . $row['total_general'] . '</td>';
                        }else{
                            $total[$estado]['H'] += $total_hombres;
                            $total[$estado]['M'] += $total_mujeres;

                            $td .= '<td>' . $total_hombres . '</td>';
                            $td .= '<td>' . $total_mujeres . '</td>';
                        }

                    }


//                    $td .= '<td>' . $total_secundaria . '</td>';


                    $fila = '<td>'.$estado.'</td>'.
                        '<td>'.($total[$estado]['M']+$total[$estado]['H']).'</td>'.
                        '<td>'.$total[$estado]['H'].'</td>'.
                        '<td>'.$total[$estado]['M'].'</td>';

                    echo $fila.$td.'</tr>';

                }



                ?>
            </table>
        </div>
    </div>
</section>
