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

if ($id_centro != '') {
    $sql1 = "select count(*) as total from antropometria
                inner join historial_antropometria using(rut)
                inner join paciente_establecimiento on antropometria.rut=paciente_establecimiento.rut
                inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                where m_infancia='SI'
                  and historial_antropometria.fecha_registro>=date_sub(str_to_date('2024-01-05','%Y-%m-%d'),interval 6 month)
                and indicador='EVAL_NUTRICIONISTA'
                and valor='5 MESES'
                $filtro_centro
                group by historial_antropometria.indicador ;";
    $sql2 = "select count(*) as total from antropometria
                inner join historial_antropometria using(rut)
                inner 
                    join paciente_establecimiento on antropometria.rut=paciente_establecimiento.rut
                inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                where m_infancia='SI'
                  and historial_antropometria.fecha_registro>=date_sub(str_to_date('2024-01-05','%Y-%m-%d'),interval 6 month)
                and indicador='EVAL_NUTRICIONISTA'
                and valor='3 ANIOS 6 MESES'
                $filtro_centro
                group by historial_antropometria.indicador ;";

} else {
    $sql1 = "select count(*) as total from antropometria
                inner join historial_antropometria using(rut)
                inner join paciente_establecimiento on antropometria.rut=paciente_establecimiento.rut
                inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                where m_infancia='SI'
                  and historial_antropometria.fecha_registro>=date_sub(str_to_date('2024-01-05','%Y-%m-%d'),interval 6 month)
                and indicador='EVAL_NUTRICIONISTA'
                and valor='5 MESES'
                group by historial_antropometria.indicador ;";
    $sql2 = "select count(*) as total from antropometria
                inner join historial_antropometria using(rut)
                inner join paciente_establecimiento on antropometria.rut=paciente_establecimiento.rut
                inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                where m_infancia='SI'
                  and historial_antropometria.fecha_registro>=date_sub(str_to_date('2024-01-05','%Y-%m-%d'),interval 6 month)
                and indicador='EVAL_NUTRICIONISTA'
                and valor='3 ANIOS 6 MESES'
                group by historial_antropometria.indicador ;";

}
$row1 = mysql_fetch_array(mysql_query($sql1));
$row2 = mysql_fetch_array(mysql_query($sql2));
?>

<section id="seccion_d" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION D: POBLACIÓN EN CONTROL EN EL SEMESTRE CON CONSULTA NUTRICIONAL, SEGÚN ESTRATEGIA
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_d" style="width: 50%;border: solid 1px black;" border="1">
                <tr>
                    <td>NIÑO/A CON CONSULTA NUTRICIONAL EN</td>
                    <td>TOTAL</td>
                </tr>
                <tr>
                    <td>DEL 5TO MES</td>
                    <td><?php echo $row1['total']; ?></td>
                </tr>
                <tr>
                    <td>DE LOS 3 AÑOS Y 6 MESES</td>
                    <td><?php echo $row2['total']; ?></td>
                </tr>
            </table>
        </div>
    </div>
</section>
