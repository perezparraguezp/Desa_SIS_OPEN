<?php


include "../../../php/config.php";
include '../../../php/objetos/mysql.php';

$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";


$id_establecimiento = $_SESSION['id_establecimiento'];

$id_centro = $_POST['id'];

$sql = "SELECT * from centros_internos
inner join sectores_centros_internos using(id_centro_interno)
inner join sector_comunal sc on centros_internos.id_sector_comunal = sc.id_sector_comunal
where nombre_sector_comunal='URBANO' order by nombre_sector_interno";

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
<section id="seccion_A" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l12">
            <header>SECCION A: CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO
            </header>
        </div>
    </div>
    <div class="row">
        <div class="col l12">
            <table id="table_seccion_a" style="width: 70%;border: solid 1px black;" border="1">
                <tr style="background-color: yellow;">
                    <td rowspan="1">CLASIFICACION DE LAS FAMILIAS POR SECTOR</td>
                    <td rowspan="1">TOTAL</td>
                    <?php echo $td_centros; ?>
                </tr>

                <?php
                $estados = ['Nº FAMILIAS INSCRITAS'];

                foreach ($estados as $i => $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';

                    foreach ($array_sectores as $indice => $id_sector_interno){
                        $sql2 = "select count(*) as total from familia where id_sector='$id_sector_interno' ";
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
                    $tr .= '</tr>';
                    echo $tr;
                }
                ?>

                <?php
                $estados = ['Nº FAMILIAS EVALUADAS CON CARTOLA/ENCUESTA FAMILIAR'];

                foreach ($estados as $i => $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';

                    foreach ($array_sectores as $indice => $id_sector_interno){
                        $sql2 = "select count(*) as total from familia 
                            where id_sector='$id_sector_interno'
                                and estado_evaluacion like '%RIESGO%'";
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
                    $tr .= '</tr>';
                    echo $tr;
                }
                ?>

                <?php
                $estados = [
                    'Nº FAMILIAS EN RIESGO BAJO',
                    'Nº FAMILIAS EN RIESGO MEDIO',
                    'Nº FAMILIAS EN RIESGO ALTO',
                ];
                $filtro_estados = [
                    'BAJO','MEDIO','ALTO'
                ];

                foreach ($estados as $i => $estado) {
                    $total_estado = 0;
                    $tr = '<tr>';
                    $td = '';

                    foreach ($array_sectores as $indice => $id_sector_interno){
                        $sql2 = "select count(*) as total from familia 
                                where id_sector='$id_sector_interno'
                                and estado_evaluacion like '%".$filtro_estados[$i]."%'";
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
                    $tr .= '</tr>';
                    echo $tr;
                }
                ?>



            </table>
        </div>
    </div>
</section>
