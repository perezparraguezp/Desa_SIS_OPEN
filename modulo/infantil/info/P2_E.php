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
$label_rango_seccion_e = [

    'de 0 a 11 meses',
    'de 12 a 24 meses',
    '25 a 35 meses',//24 a 35 meses
    '36 a 59 meses',//36 a 41 meses
    '60 a 9 años',//42 a 47 meses
    'total',//TOTAL

];
$filtro_rango_seccion_e = [

    'persona.edad_total>=0 and persona.edad_total<=11', // 0 a 11 meses
    'persona.edad_total>11 and persona.edad_total<=24', // 12 a 24 meses
    'persona.edad_total>24 and persona.edad_total<=35', // 25 A 35
    'persona.edad_total>35 and persona.edad_total<=59', // 36 a 59 meses
    'persona.edad_total>59 and persona.edad_total<=(12*30*9)', // 9 AÑOS
    'persona.edad_total<=(12*30*9)', // TOTAL
];
$filtro_inasistencia_e = [
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*4',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*4',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*13',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*13',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*13',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*13',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*13',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*13',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*18',
    'and TIMESTAMPDIFF(DAY,agendamiento.fecha_registro,CURRENT_DATE)>30*18',
];

?>

<section id="seccion_e" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION E: POBLACIÓN INASISTENTE A CONTROL DEL NIÑO SANO (AL CORTE)</header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_e" style="width: 50%;border: solid 1px black;" border="1">
                <tr>
                    <td>EDAD</td>
                    <td>TOTAL</td>
                </tr>
                <?php
                foreach ($label_rango_seccion_e as $i => $value) {
                    $rango = $filtro_rango_seccion_e[$i];
                    if ($id_centro != '') {

                        $sql = "select COUNT(*) as total
                                from persona
                                   inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                   inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno,
                                 (
                                                   select agendamiento.rut
from agendamiento
         inner join paciente_establecimiento on agendamiento.rut = paciente_establecimiento.rut
         inner join sectores_centros_internos  on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno
         inner join centros_internos on sectores_centros_internos.id_centro_interno = centros_internos.id_centro_interno
where m_infancia = 'SI'
  AND paciente_establecimiento.id_establecimiento = 1
  and sectores_centros_internos.id_centro_interno='$id_centro'
  AND estado_control = 'PENDIENTE'
  and (mes_proximo_control < month(current_date()) and anio_proximo_control <= year(current_date()))
GROUP BY agendamiento.rut) as personas
                                where personas.rut=persona.rut and $rango ;";

                    } else {
                        $sql = "select COUNT(*) as total
                                from persona
                                   inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                   inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno,
                                 (
                                     select agendamiento.rut
                                        from agendamiento
                                                 inner join paciente_establecimiento on agendamiento.rut = paciente_establecimiento.rut
                                                 inner join sectores_centros_internos  on paciente_establecimiento.id_sector = sectores_centros_internos.id_sector_centro_interno
                                                 inner join centros_internos on sectores_centros_internos.id_centro_interno = centros_internos.id_centro_interno
                                        where m_infancia = 'SI'
                                          AND paciente_establecimiento.id_establecimiento = 1
                                          AND estado_control = 'PENDIENTE'
                                          and ( mes_proximo_control < month(current_date()) 
                                                and anio_proximo_control <= year(current_date()))
                                        GROUP BY agendamiento.rut

                                 ) as personas
                                where personas.rut=persona.rut
                                  and $rango;";

                    }


//                        echo '<br />'.$sql;
                    $row = mysql_fetch_array(mysql_query($sql));
                    if ($row) {
                        $total = $row['total'];
                    } else {
                        $total = 0;
                    }

                    ?>
                    <tr>
                        <td><?PHP echo $value ?></td>
                        <td><?PHP echo $total ?></td>

                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</section>
