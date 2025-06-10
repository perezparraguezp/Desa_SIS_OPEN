<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';


$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";



$id_establecimiento = $_SESSION['id_establecimiento'];

$id_centro = $_POST['id'];
if($id_centro!=''){
    $filtro_centro = " and id_centro_interno='$id_centro' ";
    $sql0 = "select * from centros_internos 
                              WHERE id_centro_interno='$id_centro' limit 1";
    $row0 = mysql_fetch_array(mysql_query($sql0));
    $nombre_centro = $row0['nombre_centro_interno'];
}else{
    $nombre_centro = 'TODOS LOS CENTROS';
}


$rango_label_seccion_a = [
    '0 a 4 años',
    '5 a 9 años',
    '10 a 14 años',
    '15 a 19 Años',
    '20 a 24 Años',
    '25 a 29 Años',
    '30 a 34 Años',
    '35 a 39 Años',
    '40 a 44 Años',
    '45 a 49 Años',
    '50 a 54 Años',
    '55 a 59 Años',
    '60 a 64 Años',
    '65 a 69 Años',
    '70 a 74 Años',
    '75 a 70 Años',
    '80 y mas Años',
];



?>
<style type="text/css">
    table, tr, td {
        padding: 10px;
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.8em;
        text-align: center;
    }
    section{
        padding-top: 10px;
        padding-left: 10px;
    }
    header{
        font-weight: bold;;
    }
</style>

<div class="card" id="todo_p6">
    <div class="row" style="padding:20px;">
        <div class="col l10">
            <header>CENTRO MEDICO: <?php echo $nombre_centro; ?></header>
            <header>REM-P6. POBLACIÓN EN CONTROL PROGRAMA DE SALUD MENTAL EN ATENCIÓN PRIMARIA Y ESPECIALIDAD</header>
        </div>
        <div class="col l2">
            <input type="button"
                   class="btn green lighten-2 white-text"
                   value="EXPORTAR A EXCEL" onclick="exportTable('todo_p6','REM P6')" />
        </div>
    </div>
    <hr class="row" style="margin-bottom: 10px;" />

    <section id="seccion_a" style="width: 100%;overflow-y: scroll;">
        <div class="row">
            <div class="col l10">
                <header>SECCION A.1: POBLACIÓN EN CONTROL EN APS AL CORTE</header>
            </div>
        </div>
        <table id="table_seccion_a" style="width: 100%;border: solid 1px black;" border="1">
            <tr>
                <td colspan="2" rowspan="3"
                    style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                    CONCEPTO
                </td>
                <td rowspan="2" colspan="3">TOTAL</td>
                <td colspan="34">GRUPO DE EDAD (en años) Y SEXO</td>
                <td rowspan="3" colspan="1">GESTANTES</td>
                <td rowspan="3" colspan="1">MADRE DE HIJO MENOR DE 5 AÑOS</td>
                <td rowspan="2" colspan="2">PUEBLOS ORIGINARIOS</td>
                <td rowspan="2" colspan="2">POBLACION MIGRANTE</td>
                <td rowspan="3" colspan="1">Niños, Niñas, Adolescentes y Jóvenes de Población SENAME</td>
                <td rowspan="3" colspan="1">Niños, Niñas, Adolescentes y Jóvenes Mejor Niñez</td>
                <td rowspan="3" colspan="1">Plan Cuidado Integral Elaborado</td>
                <td rowspan="2" colspan="2">TRANS</td>
            </tr>
            <tr>
                <?php
                foreach ($rango_label_seccion_a as $i => $value){
                    echo '<td colspan="2">'.$value.'</td>';
                }
                ?>
            </tr>
            <tr>
                <?php
                echo '<td>AMBOS</td>';
                echo '<td>HOMBRES</td>';
                echo '<td>MUJERES</td>';
                for($i = 0 ; $i <= 19; $i++){
                    echo '<td>HOMBRES</td>';
                    echo '<td>MUJERES</td>';
                }
                ?>
            </tr>
            <?php

            $filtro_rango_seccion_a = [
                'and persona.edad_total>=1 and persona.edad_total<4*12',//0
                'and persona.edad_total>=4*12 and persona.edad_total<9*12',
                'and persona.edad_total>=9*12 and persona.edad_total<14*12',
                'and persona.edad_total>=14*12 and persona.edad_total<19*12',
                'and persona.edad_total>=19*12 and persona.edad_total<24*12',
                'and persona.edad_total>=24*12 and persona.edad_total<29*12',
                'and persona.edad_total>=29*12 and persona.edad_total<34*12',
                'and persona.edad_total>=34*12 and persona.edad_total<39*12',
                'and persona.edad_total>=39*12 and persona.edad_total<44*12',
                'and persona.edad_total>=44*12 and persona.edad_total<49*12',
                'and persona.edad_total>=49*12 and persona.edad_total<54*12',
                'and persona.edad_total>=54*12 and persona.edad_total<59*12',
                'and persona.edad_total>=59*12 and persona.edad_total<64*12',
                'and persona.edad_total>=64*12 and persona.edad_total<69*12',
                'and persona.edad_total>=69*12 and persona.edad_total<74*12',
                'and persona.edad_total>=74*12 and persona.edad_total<79*12',
                'and persona.edad_total>=80*12 ',//16
                "and sm_registros.gestante='1' ",//17
                "and sm_registros.madre_menor='1' ",//18,
                "and persona.pueblo='SI' ",//19,pueblos
                "and persona.migrante='SI' ",//20,migrantes
                "and sm_registros.sename='1' ",//21,
                "and sm_registros.mejor_ninez='1' ",//21,
                "and sm_registros.plana_integral='1' ",//22,
                "and sm_registros.transgenero='1' ",//23,
            ];

            $INDICES = [
                "NUMERO DE PERSONAS EN CONTROL EN EL PROGRAMA",
                "FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL",
            ];
            $filtro_sql = [
                "and persona.rut!='' ",
                "and persona.rut!='' ",
            ];

            foreach ($INDICES AS $TR => $texto_fila) {
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                if ($TR == 1) {
                    $fila .= "<tr>
                                <td colspan='2'>'.$texto_fila.'</td>
                                <td colspan='45' style='background-color: dimgrey;'></td></tr>";
                    echo $fila;
                } else {
                    foreach ($filtro_rango_seccion_a as $i => $filtro) {

                        if ($id_centro != '') {
                            $sql = "select count(*) as total from persona 
                                  inner join paciente_salud_mental on persona.rut=paciente_salud_mental.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                        } else {
                            $sql = "select count(*) as total from persona
                                  inner join paciente_salud_mental on persona.rut=paciente_salud_mental.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                        }

                        if ($i == 17 || $i == 18 || $i == 21 || $i == 22|| $i == 23) {
                            $sql .= $filtro . ' ' . $filtro_sql[$TR];
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            }
                            $fila .= "<td>$total</td>";//ambos
                            
                        } else {

                            $sql1 = $sql . $filtro . ' ' . $filtro_sql[$TR] . " and persona.sexo='M' ";
                            $row = mysql_fetch_array(mysql_query($sql1));
                            if ($row) {
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            }
                            $fila .= "<td>$total</td>";//hombre
                            $total_hombre += $total;

                            $sql2 = $sql . $filtro . ' ' . $filtro_sql[$TR] . " and persona.sexo='F' ";
                            $row = mysql_fetch_array(mysql_query($sql2));
                            if ($row) {
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            }
                            $fila .= "<td>$total</td>";//mujer
                            $total_mujer += $total;

                        }

                    }//fin columnas


                    //construimos la fila
                    $fila_final = '<tr>
                                    <td colspan="2">' . $texto_fila . '</td>';
                    $fila_final .= '<td>' . ($total_hombre + $total_mujer) . '</td>';
                    $fila_final .= '<td>' . ($total_hombre) . '</td>';
                    $fila_final .= '<td>' . ($total_mujer) . '</td>';

                    $fila_final .= $fila;
                    echo $fila_final . '</tr>';
                }//fin else
            }

            //segundo proceso
            $INDICES = [
                "VICTIMA",
                "AGRESOR/A",

            ];
            $filtro_sql = [
                "and sm_registros.f34=1 ",
                "and sm_registros.f35=1 ",

            ];
            //construimos la fila
            $fila_final = '<tr>
                            <td rowspan="2">VIOLENCIA FISICA </td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==19 || $i==20 || $i==21){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos

                    }else{
                        $sql1 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='M' ";
                        $row = mysql_fetch_array(mysql_query($sql1));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//hombre
                        $total_hombre += $total;
                        $sql2 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='F' ";
                        $row = mysql_fetch_array(mysql_query($sql2));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//mujer
                        $total_mujer += $total;

                    }

                }//fin columnas

                $fila_final .='<td>'.$texto_fila.'</td>';

                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final = '';


            }//fin filas
            echo '</tr>';


            //VIOLENCIA SEXUAL
            $INDICES = [
                "VICTIMA",
                "AGRESOR/A",

            ];
            $filtro_sql = [
                "and sm_registros.f34a=1 ",
                "and sm_registros.f35a=1 ",

            ];
            //construimos la fila
            $fila_final = '<tr>
                            <td rowspan="2">VIOLENCIA SEXUAL </td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==19 || $i==20 || $i==21){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos

                    }else{
                        $sql1 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='M' ";
                        $row = mysql_fetch_array(mysql_query($sql1));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//hombre
                        $total_hombre += $total;
                        $sql2 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='F' ";
                        $row = mysql_fetch_array(mysql_query($sql2));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//mujer
                        $total_mujer += $total;

                    }

                }//fin columnas

                $fila_final .='<td>'.$texto_fila.'</td>';

                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final = '';


            }//fin filas
            echo '</tr>';

            //VIOLENCIA PSICOLOGICA
            $INDICES = [
                "VICTIMA",
                "AGRESOR/A",

            ];
            $filtro_sql = [
                "and sm_registros.f34b=1 ",
                "and sm_registros.f35b=1 ",

            ];
            //construimos la fila
            $fila_final = '<tr>
                            <td rowspan="2">VIOLENCIA PSICOLOGICA </td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==19 || $i==20 || $i==21){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos

                    }else{
                        $sql1 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='M' ";
                        $row = mysql_fetch_array(mysql_query($sql1));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//hombre
                        $total_hombre += $total;
                        $sql2 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='F' ";
                        $row = mysql_fetch_array(mysql_query($sql2));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//mujer
                        $total_mujer += $total;

                    }

                }//fin columnas

                $fila_final .='<td>'.$texto_fila.'</td>';

                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final = '';


            }//fin filas
            echo '</tr>';

            //abuso sexual
            $INDICES = [
                "VICTIMA"

            ];
            $filtro_sql = [
                "and sm_registros.f38=1 "

            ];
            //construimos la fila
            $fila_final = '<tr>
                            <td rowspan="1" colspan="2">ABUSO SEXUAL </td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join sm_registros on persona.rut=sm_registros.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==19 || $i==20 || $i==21){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos


                    }else{
                        $sql1 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='M' ";
                        $row = mysql_fetch_array(mysql_query($sql1));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//hombre
                        $total_hombre += $total;


                        $sql2 = $sql.$filtro.' '.$filtro_sql[$TR]." and persona.sexo='F' ";
                        $row = mysql_fetch_array(mysql_query($sql2));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//mujer
                        $total_mujer += $total;

                    }

                }//fin columnas

                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final = '';


            }//fin filas
            echo '</tr>';





            ?>



        </table>
    </section>
</div>
