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
                <td rowspan="3" colspan="1">Plan Cuidado Integral Elaborado</td>
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
                for($i = 0 ; $i <= 18; $i++){
                    echo '<td>HOMBRES</td>';
                    echo '<td>MUJERES</td>';
                }
                ?>
            </tr>
            <?php

            $filtro_rango_seccion_a = [
                'and persona.edad_total>=1 and persona.edad_total<4*12',
                'and persona.edad_total>=5*12 and persona.edad_total<9*12',
                'and persona.edad_total>=10*12 and persona.edad_total<14*12',
                'and persona.edad_total>=15*12 and persona.edad_total<19*12',
                'and persona.edad_total>=20*12 and persona.edad_total<24*12',
                'and persona.edad_total>=25*12 and persona.edad_total<29*12',
                'and persona.edad_total>=30*12 and persona.edad_total<34*12',
                'and persona.edad_total>=35*12 and persona.edad_total<39*12',
                'and persona.edad_total>=40*12 and persona.edad_total<44*12',
                'and persona.edad_total>=45*12 and persona.edad_total<49*12',
                'and persona.edad_total>=50*12 and persona.edad_total<54*12',
                'and persona.edad_total>=55*12 and persona.edad_total<59*12',
                'and persona.edad_total>=60*12 and persona.edad_total<64*12',
                'and persona.edad_total>=65*12 and persona.edad_total<69*12',
                'and persona.edad_total>=70*12 and persona.edad_total<74*12',
                'and persona.edad_total>=75*12 and persona.edad_total<80*12',
                'and persona.edad_total>=80*12 ',//16
                "and paciente_salud_mental.gestante='SI' ",//17
                "and paciente_salud_mental.madre_5='SI' ",//18,
                "and persona.migrante='SI' ",//19,pueblos
                "and persona.migrante='SI' ",//20,migrantes
                "and paciente_salud_mental.sename='SI' ",//21,
                "and paciente_salud_mental.plana_integral='SI' ",//22,
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

                        if ($i == 17 || $i == 18 || $i == 21 || $i == 22) {
                            $sql .= $filtro . ' ' . $filtro_sql[$TR];
                            $row = mysql_fetch_array(mysql_query($sql));
                            if ($row) {
                                $total = $row['total'];
                            } else {
                                $total = 0;
                            }
                            $fila .= "<td>$total</td>";//ambos
                            $total_hombre += $total;
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
                "and paciente_antecedentes_sm.nombre_antecedente like '%VICTIMA%' and  paciente_antecedentes_sm.fecha_egreso is null ",
                "and paciente_antecedentes_sm.nombre_antecedente like '%AGRESOR%' and  paciente_antecedentes_sm.fecha_egreso is null  ",


            ];

            //construimos la fila

            $fila_final = '<tr>
                            <td rowspan="2">VIOLENCIA </td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_antecedentes_sm on persona.rut=paciente_antecedentes_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_antecedentes_sm on persona.rut=paciente_antecedentes_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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
            $INDICES = [
                "ABUSO SEXUAL",

            ];
            $filtro_sql = [
                "and paciente_antecedentes_sm.nombre_antecedente like '%ABUSO SEXUAL%' and  paciente_antecedentes_sm.fecha_egreso is null ",
            ];

            //construimos la fila

            $fila_final = '';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_antecedentes_sm on persona.rut=paciente_antecedentes_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_antecedentes_sm on persona.rut=paciente_antecedentes_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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

                $fila_final .='<td colspan="2">'.$texto_fila.'</td>';

                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final = '';

            }//fin filas


            echo '</tr>';
            $INDICES = [
                "PERSONAS CON DIAGNOSTICOS DE TRASTORNOS MENTALES",

            ];
            $filtro_sql = [
                " ",
            ];

            //construimos la fila

            $fila_final = '';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' 
                                  group by paciente_diagnosticos_sm.rut";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' 
                                  ";
                    }
                    $sql1 = $sql." and persona.sexo='M' group by paciente_diagnosticos_sm.rut";
                    $row = mysql_fetch_array(mysql_query($sql1));
                    if($row){
                        $total = $row['total'];
                    }else{
                        $total = 0;
                    }
                    $fila .= "<td>$total</td>";//hombre
                    $total_hombre += $total;
                    $sql2 = $sql." and persona.sexo='F' group by paciente_diagnosticos_sm.rut";
                    $row = mysql_fetch_array(mysql_query($sql2));
                    if($row){
                        $total = $row['total'];
                    }else{
                        $total = 0;
                    }
                    $fila .= "<td>$total</td>";//mujer
                    $total_mujer += $total;

                }//fin columnas

                $fila_final .='<td colspan="2">'.$texto_fila.'</td>';

                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final = '';

            }//fin filas

            $INDICES = [

                "IDEACION",
                "INTENTO",
            ];
            $filtro_sql = [

                "and paciente_antecedentes_sm.nombre_antecedente like '%IDEACION%' and  paciente_antecedentes_sm.fecha_egreso is null  ",
                "and paciente_antecedentes_sm.nombre_antecedente like '%INTENTO%' and  paciente_antecedentes_sm.fecha_egreso is null  ",

            ];

            //construimos la fila

            $fila_final = '<tr>
                            <td rowspan="2">SUICIDIO </td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;


                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_antecedentes_sm on persona.rut=paciente_antecedentes_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_antecedentes_sm on persona.rut=paciente_antecedentes_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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




            //tercer proceso TRASTORNOS DEL HUMOR(AFECTIVOS)
            $INDICES = [
                "DEPRESION LEVE",
                "DEPRESION MODERADA",
                "DEPRESION GRAVE",
                "DEPRESION POST PARTO",
                "TRASTORNO BIPOLAR",
            ];

            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like '%DEPRESION LEVE%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%DEPRESION MODERADA%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%DEPRESION GRAVE%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%DEPRESION POST PARTO%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%TRASTORNO BIPOLAR%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",


            ];

            $fila_final = '<tr>
                        <td rowspan="5">TRASTORNOS DEL HUMOR(AFECTIVOS)</td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  .='<td>'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '</tr>';



            //tercer proceso TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTROPICAS
            $INDICES = [
                "CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL",
                "CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL",
                "POLICONSUMO",
            ];
            $INDICES_COL = [
                2,1,1
            ];
            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like '%CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%POLICONSUMO%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",


            ];

            $fila_final = '<tr>
                        <td rowspan="3">TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTROPICAS</td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  .='<td>'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '</tr>';


            $INDICES = [
                "TRASTORNO HIPERCINÉTICO",
                "TRASTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA",
                "TRASTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA",
                "OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA",

            ];
            $INDICES_COL = [
                2,1,1
            ];
            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like '%TRASTORNO HIPERC%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%TRASTORNO DISOCIAL DESAFIANTE%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%TRASTORNO DE ANSIEDAD DE SEPARA%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%OTROS TRANSTORNOS COMIENZO EN INFANCIA%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
            ];

            $fila_final = '<tr>
                        <td rowspan="4">TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA</td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  .='<td>'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '</tr>';


            $INDICES = [
                "LEVE",
                "MODERADO",
                "AVANZADO",

            ];
            $INDICES_COL = [
                2,1,1
            ];
            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like 'LEVE' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'MODERADO' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'AVANZADO' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
            ];

            $fila_final = '<tr>
                        <td rowspan="3">DEMENCIAS (INCLUYE ALZHEIMER)</td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  .='<td>'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '</tr>';


            $INDICES = [
                "ESQUIZOFRENIA	",
                "PRIMER EPISODIO ESQUIZOFRENIA CON OCUPACION REGULAR	",
                "TRASTORNOS DE LA CONDUCTA ALIMENTARIA	",
                "RETRASO MENTAL	",
                "TRASTORNO DE PERSONALIDAD	",

            ];
            $INDICES_COL = [
                2,1,1
            ];
            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like 'ESQUIZOFRENIA' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like '%1ER EPISODIO EQZ POR OCUPACION REGULAR%' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'TRASTORNO CONDUCTA ALIMENTARIA' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'RETRASO MENTAL' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'TRASTORNO DE PERSONALIDAD' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
            ];

            $fila_final = '';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  ='<tr>
                                <td colspan="2">'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '';



            $INDICES = [
                "AUTISMO",
                "ASPERGER",
                "SÍNDROME DE RETT",
                "TRASTORNO DESINTEGRATIVO DE LA INFANCIA",
                "TRASTONO GENERALIZADO DEL DESARROLLO NO ESPECÍFICO",

            ];
            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like 'AUTISMO' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'ASPERGER' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'SINDROME DE RETT' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'TRASTORNO DESINTEGRATIVO DE LA INFNAICA' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'TRASTORNO GENERALIZADO DEL DESARROLLO NO ESPECIFICO' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
            ];

            $fila_final = '<tr>
                        <td rowspan="5">TRASTORNO GENERALIZADOS DEL DESARROLLO</td>';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  .='<td>'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '</tr>';

            $INDICES = [
                "EPILEPSIA	",
                "OTRAS 	",

            ];
            $INDICES_COL = [
                2,1,1
            ];
            $filtro_sql = [
                "and paciente_diagnosticos_sm.valor_tipo like 'EPILEPSIA' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
                "and paciente_diagnosticos_sm.valor_tipo like 'OTRAS' and  paciente_diagnosticos_sm.fecha_egreso is null  ",
            ];

            $fila_final = '';
            foreach ($INDICES AS $TR => $texto_fila){
                $fila = '';
                $total_hombre = 0;
                $total_mujer = 0;
                foreach ($filtro_rango_seccion_a as $i => $filtro){

                    if($id_centro!=''){
                        $sql = "select count(*) as total from persona 
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where sectores_centros_internos.id_centro_interno='$id_centro'
                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }else{
                        $sql = "select count(*) as total from persona
                                  inner join paciente_diagnosticos_sm on persona.rut=paciente_diagnosticos_sm.rut
                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento' ";
                    }

                    if($i==17 || $i == 18 || $i==21 || $i==22){
                        $sql .= $filtro.' '.$filtro_sql[$TR];
                        $row = mysql_fetch_array(mysql_query($sql));
                        if($row){
                            $total = $row['total'];
                        }else{
                            $total = 0;
                        }
                        $fila .= "<td>$total</td>";//ambos
                        $total_hombre += $total;
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


                //construimos la fila
                $fila_final  ='<tr>
                                <td colspan="2">'.$texto_fila.'</td>';
                $fila_final .='<td>'.($total_hombre+$total_mujer).'</td>';
                $fila_final .='<td>'.($total_hombre).'</td>';
                $fila_final .='<td>'.($total_mujer).'</td>';

                $fila_final .= $fila;
                echo $fila_final.'</tr>';
                $fila_final='';


            }//fin filas
            echo '';









            ?>



        </table>
    </section>

<!--    <section id="seccion_a3" style="width: 100%;overflow-y: scroll;">-->
<!--        <div class="row">-->
<!--            <div class="col l10">-->
<!--                <header>SECCION A.3: PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN LA ATENCION PRIMARIA</header>-->
<!--            </div>-->
<!--        </div>-->
<!--        <table id="table_seccion_a3" style="width: 100%;border: solid 1px black;" border="1">-->
<!--            <tr>-->
<!--                <td ROWSPAN="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">-->
<!--                    CONCEPTO-->
<!--                </td>-->
<!--                <td colspan="3" rowspan="2">TOTAL</td>-->
<!--                <td colspan="10">GRUPO DE EDAD (en años)</td>-->
<!--                <td colspan="2" rowspan="2">POBLACION MIGRANTES</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td colspan="2">0 a 4 años</td>-->
<!--                <td colspan="2">5 a 9 años</td>-->
<!--                <td colspan="2">10 a 14 años</td>-->
<!--                <td colspan="2">15 a 19 años</td>-->
<!--                <td colspan="2">20 a 24 años</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>AMBOS</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!---->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!---->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!---->
<!--            </tr>-->
<!---->
<!--            --><?php
//
//            $INDICES = [
//                "N° DE PERSONAS EN CONTROL EN PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL	",
//            ];
//            $filtro_sql = [
//                'and persona.edad_total>=0 and persona.edad_total<4*12',
//                'and persona.edad_total>=5*12 and persona.edad_total<9*12',
//                'and persona.edad_total>=10*12 and persona.edad_total<14*12',
//                'and persona.edad_total>=15*12 and persona.edad_total<19*12',
//                'and persona.edad_total>=20*12 and persona.edad_total<24*12',
//                'and persona.edad_total>0',
//            ];
//
//            $filtro_rango_seccion_a = [
//                '',
//                "AND riesgo_biopsicosocial='CON RIESGO BIOPSICOSOCIAL' ",
//            ];
//
//            foreach ($INDICES AS $TR => $texto_fila) {
//                $fila = '';
//                foreach ($filtro_rango_seccion_a as $i => $filtro) {
//                    if ($id_centro != '') {
//                        $sql = "select count(*) as total from persona
//                                  inner join gestacion_mujer using(rut)
//                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
//                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
//                                  where sectores_centros_internos.id_centro_interno='$id_centro'
//                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento'
//                                  and estado_gestacion='ACTIVA' ";
//                    } else {
//                        $sql = "select count(*) as total from persona
//                                  inner join gestacion_mujer using(rut)
//                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
//                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
//                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento'
//                                  and estado_gestacion='ACTIVA' ";
//                    }
//                    $sql .= $filtro . ' ' . $filtro_sql[$TR];
////                    echo $sql;
//                    $row = mysql_fetch_array(mysql_query($sql));
//                    if ($row) {
//                        $total = $row['total'];
//                    } else {
//                        $total = 0;
//                    }
//                    $fila .= "<td>$total</td>";
//
//
//                }
//                $fila_final = '<tr>
//                                    <td>'.$texto_fila.'</td>';
//                $fila_final .= $fila;
//                echo $fila_final.'</tr>';
//            }
//            ?>
<!--        </table>-->
<!--    </section>-->


<!--    <section id="seccion_b1" style="width: 100%;overflow-y: scroll;">-->
<!--        <div class="row">-->
<!--            <div class="col l10">-->
<!--                <header>B. ATENCIÓN DE ESPECIALIDADES</header>-->
<!--                <header>SECCION B.1: POBLACIÓN EN CONTROL EN ESPECIALIDAD AL CORTE</header>-->
<!--            </div>-->
<!--        </div>-->
<!--        <table id="table_seccion_a3" style="width: 100%;border: solid 1px black;" border="1">-->
<!--            <tr>-->
<!--                <td ROWSPAN="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">-->
<!--                    CONCEPTO-->
<!--                </td>-->
<!--                <td colspan="3" rowspan="2">TOTAL</td>-->
<!--                <td colspan="34">GRUPO DE EDAD (en años)</td>-->
<!--                <td colspan="1" rowspan="3">GESTANTES</td>-->
<!--                <td colspan="1" rowspan="3">MADRE DE MENOR 5 AÑOS</td>-->
<!--                <td colspan="2" rowspan="2">PUEBLOS ORIGINARIOS</td>-->
<!--                <td colspan="2" rowspan="2">POBLACION MIGRANTES</td>-->
<!--                <td colspan="1" rowspan="3">SENAME</td>-->
<!--                <td colspan="1" rowspan="3">PLAN CUIDADO INTEGRAL</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td colspan="2">0 a 4 años</td>-->
<!--                <td colspan="2">5 a 9 años</td>-->
<!--                <td colspan="2">10 a 14 años</td>-->
<!--                <td colspan="2">15 a 19 años</td>-->
<!--                <td colspan="2">20 a 24 años</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>AMBOS</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!---->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!---->
<!--                <td>HOMBRES</td>-->
<!--                <td>MUJER</td>-->
<!---->
<!--            </tr>-->
<!---->
<!--            --><?php
//
//            $INDICES = [
//                "NUMERO DE PERSONAS EN CONTROL EN EL PROGRAMA",
//                "FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL	",
//            ];
//            $filtro_sql = [
//                'and persona.edad_total>=0 and persona.edad_total<4*12',
//                'and persona.edad_total>=5*12 and persona.edad_total<9*12',
//                'and persona.edad_total>=10*12 and persona.edad_total<14*12',
//                'and persona.edad_total>=15*12 and persona.edad_total<19*12',
//                'and persona.edad_total>=20*12 and persona.edad_total<24*12',
//                'and persona.edad_total>0',
//            ];
//
//            $filtro_rango_seccion_a = [
//                '',
//                "AND riesgo_biopsicosocial='CON RIESGO BIOPSICOSOCIAL' ",
//            ];
//            $filtro_rango_seccion_b1 = [
//                'and persona.edad_total>=1 and persona.edad_total<4*12',
//                'and persona.edad_total>=5*12 and persona.edad_total<9*12',
//                'and persona.edad_total>=10*12 and persona.edad_total<14*12',
//                'and persona.edad_total>=15*12 and persona.edad_total<19*12',
//                'and persona.edad_total>=20*12 and persona.edad_total<24*12',
//                'and persona.edad_total>=25*12 and persona.edad_total<29*12',
//                'and persona.edad_total>=30*12 and persona.edad_total<34*12',
//                'and persona.edad_total>=35*12 and persona.edad_total<39*12',
//                'and persona.edad_total>=40*12 and persona.edad_total<44*12',
//                'and persona.edad_total>=45*12 and persona.edad_total<49*12',
//                'and persona.edad_total>=50*12 and persona.edad_total<54*12',
//                'and persona.edad_total>=55*12 and persona.edad_total<59*12',
//                'and persona.edad_total>=60*12 and persona.edad_total<64*12',
//                'and persona.edad_total>=65*12 and persona.edad_total<69*12',
//                'and persona.edad_total>=70*12 and persona.edad_total<74*12',
//                'and persona.edad_total>=75*12 and persona.edad_total<80*12',
//                'and persona.edad_total>=80*12 ',//16
//                "and paciente_salud_mental.gestante='SI' ",//17
//                "and paciente_salud_mental.madre_5='SI' ",//18,
//                "and persona.migrante='SI' ",//19,pueblos
//                "and persona.migrante='SI' ",//20,migrantes
//                "and paciente_salud_mental.sename='SI' ",//21,
//                "and paciente_salud_mental.plana_integral='SI' ",//22,
//            ];
//
//            foreach ($INDICES AS $TR => $texto_fila) {
//                $fila = '';
//                foreach ($filtro_rango_seccion_b1 as $i => $filtro) {
//                    if ($id_centro != '') {
//                        $sql = "select count(*) as total from persona
//                                  inner join gestacion_mujer using(rut)
//                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
//                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
//                                  where sectores_centros_internos.id_centro_interno='$id_centro'
//                                  and m_salud_mental='SI' and id_establecimiento='$id_establecimiento'
//                                  and estado_gestacion='ACTIVA' ";
//                    } else {
//                        $sql = "select count(*) as total from persona
//                                  inner join gestacion_mujer using(rut)
//                                  inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut
//                                  inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
//                                  where m_salud_mental='SI' and id_establecimiento='$id_establecimiento'
//                                  and estado_gestacion='ACTIVA' ";
//                    }
//                    $sql .= $filtro . ' ' . $filtro_sql[$TR];
////                    echo $sql;
//                    $row = mysql_fetch_array(mysql_query($sql));
//                    if ($row) {
//                        $total = $row['total'];
//                    } else {
//                        $total = 0;
//                    }
//                    $fila .= "<td>$total</td>";
//
//
//                }
//                $fila_final = '<tr>
//                                    <td>'.$texto_fila.'</td>';
//                $fila_final .= $fila;
//                echo $fila_final.'</tr>';
//            }
//            ?>
<!--        </table>-->
<!--    </section>-->
</div>
