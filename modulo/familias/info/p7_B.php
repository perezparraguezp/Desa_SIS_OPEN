<?php


include "../../../php/config.php";
include '../../../php/objetos/mysql.php';

$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";


$id_establecimiento = $_SESSION['id_establecimiento'];

$id_centro = $_POST['id'];

$sql = "SELECT id_sector_centro_interno,nombre_sector_interno,nombre_centro_interno from centros_internos
inner join sectores_centros_internos using(id_centro_interno)
inner join sector_comunal sc on centros_internos.id_sector_comunal = sc.id_sector_comunal
where sc.id_establecimiento='1' order by id_sector_centro_interno,nombre_sector_interno";

$res = mysql_query($sql);
$centros = 0;
$td_centros = '';
$array_sectores = Array();
while ($row = mysql_fetch_array($res)){
    $centros++;
    array_push($array_sectores,$row['id_sector_centro_interno']);
    $td_centros.='<td>'.$row['nombre_centro_interno'].' SECTOR: '.$row['nombre_sector_interno'].'</td>';
}

$sexo = [
    "persona.sexo='M' ",
    "persona.sexo='F' "
];

$rango_seccion_g = [
    'persona.edad_total>=4 and persona.edad_total<=11',//36 a 47 meses
    'persona.edad_total>=12 and persona.edad_total<=23',//48 6 a 71 meses
    'persona.edad_total>=24 and persona.edad_total<=35',//48 6 a 71 meses
    'persona.edad_total>=36 and persona.edad_total<=47',//48 6 a 71 meses
    'persona.edad_total>=48 and persona.edad_total<=59',//48 6 a 71 meses
    'persona.edad_total>=60 and persona.edad_total<=71',//48 6 a 71 meses
];
?>
<section id="seccion_B" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION B: INTERVENCIÓN EN FAMILIAS SECTOR URBANO Y RURAL
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_a" style="width: 70%;border: solid 1px black;" border="1">
                <tr style="background-color: yellow;">
                    <td rowspan="1" colspan="2">CLASIFICACION DE LAS FAMILIAS POR SECTOR</td>
                    <td rowspan="1">TOTAL</td>
                    <?php echo $td_centros; ?>
                </tr>

                <?php
                $estados = ['Nº FAMILIAS CON PLAN DE INTERVENCIÓN'];

                $sql1 = "SELECT id_sector_centro_interno,nombre_sector_interno,nombre_centro_interno from centros_internos
                        inner join sectores_centros_internos using(id_centro_interno)
                        inner join sector_comunal sc on centros_internos.id_sector_comunal = sc.id_sector_comunal
                        where sc.id_establecimiento='1' 
                        order by id_sector_centro_interno,nombre_sector_interno";

                foreach ($estados as $i => $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';

                    foreach ($array_sectores as $indice => $id_sector_interno){
                        $sql2 = "select COUNT(*) AS total from historial_plan_intervencion_familia
                                inner join familia f on historial_plan_intervencion_familia.id_familia = f.id_familia
                                where f.id_sector='$id_sector_interno' and historial_plan_intervencion_familia.estado='VIGENTE' ";
                        $row2 = mysql_fetch_array(mysql_query($sql2));
                        if($row2){
                            $total = $row2['total'];
                        }else{
                            $total = 0;
                        }
                        $total_estado += $total;
                        $td .= '<td>' . $total . '</td>';
                    }


                    $tr .= '<td colspan="2">' . $estado . '</td><td>' . $total_estado . '</td>' . $td;
                    $tr .= '</tr>';
                    echo $tr;
                }
                ?>

                <?php
                $estados = ['RIESGO BAJO','RIESGO MEDIO','RIESGO ALTO'];
                $tr = '<tr>
                            <td rowspan="3">Nº FAMILIAS SIN PLAN DE INTERVENCIÓN</td>';
                foreach ($estados as $i => $estado) {
                    $total_estado = 0;
                    $td = '';

                    foreach ($array_sectores as $indice => $id_sector_interno){
                        $sql2 = "select count(*) as total from familia 
                            where id_sector='$id_sector_interno' AND plan_intervencion='SIN PLAN'
                                and estado_evaluacion like '%$estado%'";
                        $row2 = mysql_fetch_array(mysql_query($sql2));
                        if($row2){
                            $total = $row2['total'];
                        }else{
                            $total = 0;
                        }
                        $total_estado += $total;
                        $td .= '<td>' . $total . '</td>';
                    }


                    $tr .= '<td>' . $estado . '</td><td>' . $total_estado . '</td>' . $td;
                    $tr .= '</tr>
                            <tr>';
                    echo $tr;
                    $tr = '';
                }
                ?>

                <?php
                $estados = [
                    'TOTAL EGRESOS',
                    'ALTA POR CUMPLIR PLAN DE INTERVENCION',
                    'TRASLADO DE ESTABLECIMIENTO',
                    'DERIVACION POR COMPLEJIDAD DEL CASO',
                    'POR ABANDONO',
                ];
                $estados_sql = [
                    'A',
                    'CUMPLIMIENTO',
                    'TRASLADO',
                    'DERIVACION',
                    'ABANDONO',
                ];
                $tr = '<tr>
                            <td rowspan="5">Nº FAMILIAS EGRESADAS DE PLANES DE INTERVENCION</td>';
                foreach ($estados as $i => $estado) {
                    $total_estado = 0;
                    $td = '';

                    $filtro = $estados_sql[$i];
                    foreach ($array_sectores as $indice => $id_sector_interno){
                        $sql2 = "select count(*) as total from familia 
                            INNER JOIN historial_plan_intervencion_familia using(id_familia)
                            where id_sector='$id_sector_interno' 
                                AND plan_intervencion='EGRESADO'
                                and tipo_egreso like '%$filtro%'";
                        $row2 = mysql_fetch_array(mysql_query($sql2));
                        if($row2){
                            $total = $row2['total'];
                        }else{
                            $total = 0;
                        }
                        $total_estado += $total;
                        $td .= '<td>' . $total . '</td>';
                    }


                    $tr .= '<td>' . $estado . '</td><td>' . $total_estado . '</td>' . $td;
                    $tr .= '</tr>
                            <tr>';
                    echo $tr;
                    $tr = '';
                }
                ?>



            </table>
        </div>
    </div>
</section>
