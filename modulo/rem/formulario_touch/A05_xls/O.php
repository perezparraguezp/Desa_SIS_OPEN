<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';
;
session_start();

$mysql = new mysql($_SESSION['id_usuario']);




$id_empleado = $_SESSION['id_usuario'];
$rut_profesional = $_SESSION['rut'];
$id_establecimiento = $_SESSION['id_establecimiento'];

$sql = "select * from usuarios where rut='$rut_profesional' limit 1";
$row = mysql_fetch_array(mysql_query($sql));
if($row){
    $profesion = $row['tipo_usuario'];
}else{
    $profesion = '';
}


$fecha_inicio = $_POST['fecha_inicio'];
$fecha_termino = $_POST['fecha_termino'];
$lugar  = $_POST['lugar'];
$form  = $_POST['formulario'];
$seccion  = $_POST['seccion'];
if($lugar!='TODOS'){
    $filtro_lugar = "and lugar='$lugar' ";
}else{
    $filtro_lugar = '';
}
$filtro_lugar .= "and tipo_form='$form' and valor like '%seccion%:%$seccion%' ";


//rango de meses en dias
$rango_seccion = [

    "registro_rem.edad like '%0 A 4%'",
    "registro_rem.edad like '%5 A 9%'",
    "registro_rem.edad like '%10 A 14%'",
    "registro_rem.edad like '%15 A 19%'",
    "registro_rem.edad like '%20 A 24%'",
    "registro_rem.edad like '%25 A 29%'",
    "registro_rem.edad like '%30 A 34%'",
    "registro_rem.edad like '%35 A 39%'",
    "registro_rem.edad like '%40 A 44%'",
    "registro_rem.edad like '%45 A 49%'",
    "registro_rem.edad like '%50 A 54%'",
    "registro_rem.edad like '%55 A 59%'",
    "registro_rem.edad like '%60 A 64%'",
    "registro_rem.edad like '%65 A 69%'",
    "registro_rem.edad like '%70 A 74%'",
    "registro_rem.edad like '%75 A 79%'",
    "registro_rem.edad like '%80 Y MAS%'",
    'valor like \'%"GESTANTE":"SI"%\'',
    'valor like \'%"MADRE DE HIJO MENOR DE 5 AÑOS":"SI"%\'',
    'valor like \'%"Niños, Niñas, Adolescentes y Jóvenes Población SENAME":"SI"%\'',
    'valor like \'%"MIGRANTES":"SI"%\'',


];
$rango_seccion_text = [

    '0 A 4',
    '5 A 9',
    '10 A 14',
    '15 A 19',
    '20 A 24', //menor 1 MES
    '25 A 29', //menor 1 MES
    '30 A 34', //menor 1 MES
    '35 A 39', //menor 1 MES
    '40 y 44', //menor 1 MES
    '45 A 49', //menor 1 MES
    '50 A 54', //menor 1 MES
    '55 A 59', //menor 1 MES
    '60 A 64', //menor 1 MES
    '65 A 69', //menor 1 MES
    '70 A 74', //menor 1 MES
    '75 A 79', //menor 1 MES
    '80 y MAS', //menor 1 MES


];

$FILA_HEAD = [
    'INGRESOS AL PROGRAMA',
    'FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL',
    'VIOLENCIA',
    'ABUSO SEXUAL',
    'SUICIDIO',
    'PERSONAS CON DIAGNÓSTICOS DE TRASTORNOS MENTALES',
    'TRASTORNOS DEL HUMOR (AFECTIVOS)',
    'TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS',
    'TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA',
    'TRASTORNOS DE ANSIEDAD',
    'DEMENCIAS (INCLUYE ALZHEIMER)',
    'ESQUIZOFRENIA',
    'TRASTORNOS DE LA CONDUCTA ALIMENTARIA',
    'RETRASO MENTAL',
    'TRASTORNO DE PERSONALIDAD',
    'TRASTORNO GENERALIZADOS DEL DESARROLLO',
    'EPILEPSIA',
    'OTRAS',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_condicion":"INGRESOS AL PROGRAMA"%\'',
    'valor like \'%"tipo_condicion":"FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL"%\'',
    'valor like \'%"tipo_condicion":"VIOLENCIA"%\'',
    'valor like \'%"tipo_condicion":"ABUSO SEXUAL"%\'',
    'valor like \'%"tipo_condicion":"SUICIDIO"%\'',
    'valor like \'%"tipo_condicion":"PERSONAS CON DIAGNÓSTICOS DE TRASTORNOS MENTALES"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR (AFECTIVOS)"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\'',
    'valor like \'%"tipo_condicion":"DEMENCIAS (INCLUYE ALZHEIMER)"%\'',
    'valor like \'%"tipo_condicion":"ESQUIZOFRENIA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE LA CONDUCTA ALIMENTARIA"%\'',
    'valor like \'%"tipo_condicion":"RETRASO MENTAL"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNO DE PERSONALIDAD"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNO GENERALIZADOS DEL DESARROLLO"%\'',
    'valor like \'%"tipo_condicion":"EPILEPSIA"%\'',
    'valor like \'%"tipo_condicion":"OTRAS"%\'',


];

$PROFESIONES[2] = [
    'VICTIMA',
    'AGRESOR/A',
];
$FILTRO_PROFESION[2] = [
    'valor like \'%"tipo_condicion":"VIOLENCIA"%\' AND valor like \'%"tipo_atencion":"VICTIMA"%\'',
    'valor like \'%"tipo_condicion":"VIOLENCIA"%\' AND valor like \'%"tipo_atencion":"AGRESOR/A"%\'',
];
$PROFESIONES[4] = [
    'IDEACION',
    'INTENTO',
];
$FILTRO_PROFESION[4] = [
    'valor like \'%"tipo_condicion":"SUICIDIO"%\' AND valor like \'%"tipo_atencion":"IDEACION"%\'',
    'valor like \'%"tipo_condicion":"SUICIDIO"%\' AND valor like \'%"tipo_atencion":"INTENTO"%\'',
];
$PROFESIONES[6] = [
    'DEPRESIÓN LEVE',
    'DEPRESIÓN MODERADA',
    'DEPRESIÓN GRAVE',
    'DEPRESIÓN POST PARTO',
    'TRASTORNO BIPOLAR',
    'DDEPRESIÓN REFRACTARIA',
    'DEPRESIÓN GRAVE CON PSICOSIS',
    'DEPRESIÓN  CON ALTO RIESGO SUICIDA',
];
$FILTRO_PROFESION[6] = [
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DEPRESIÓN LEVE"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DEPRESIÓN MODERADA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DEPRESIÓN GRAVE"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DEPRESIÓN POST PARTO"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"TRASTORNO BIPOLAR"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DDEPRESIÓN REFRACTARIA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DEPRESIÓN GRAVE CON PSICOSIS"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL HUMOR(AFECTIVOS)"%\' AND valor like \'%"tipo_atencion":"DEPRESIÓN  CON ALTO RIESGO SUICIDA"%\'',
];
$PROFESIONES[7] = [
    'CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL',
    'CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL',
    'POLICONSUMO',
];
$FILTRO_PROFESION[7] = [
    'valor like \'%"tipo_condicion":"TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS"%\' AND valor like \'%"tipo_atencion":"CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS"%\' AND valor like \'%"tipo_atencion":"CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS"%\' AND valor like \'%"tipo_atencion":"POLICONSUMO"%\'',
];
$PROFESIONES[8] = [
    'TRASTORNO HIPERCINÉTICOS',
    'TRASTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA',
    'TRASTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA',
    'OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA',
];
$FILTRO_PROFESION[8] = [
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA"%\' AND valor like \'%"tipo_atencion":"TRASTORNO HIPERCINÉTICOS"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA"%\' AND valor like \'%"tipo_atencion":"TRASTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA"%\' AND valor like \'%"tipo_atencion":"TRASTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA"%\' AND valor like \'%"tipo_atencion":"OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA"%\'',
];
$PROFESIONES[9] = [
    'TRASTORNO DE ESTRÉS POST TRAUMATICO',
    'TRASTORNO DE PÁNICO CON AGOROFOBIA ',
    'TRASTORNO DE PÁNICO SIN AGOROFOBIA ',
    'FOBIAS SOCIALES',
    'TRASTORNOS DE ANSIEDAD GENERALIZADA',
    'OTROS TRASTORNOS DE ANSIEDAD',
];
$FILTRO_PROFESION[9] = [
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\' AND valor like \'%"tipo_atencion":"TRASTORNO DE ESTRÉS POST TRAUMATICO"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\' AND valor like \'%"tipo_atencion":"TRASTORNO DE PÁNICO CON AGOROFOBIA "%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\' AND valor like \'%"tipo_atencion":"TRASTORNO DE PÁNICO SIN AGOROFOBIA "%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\' AND valor like \'%"tipo_atencion":"FOBIAS SOCIALES"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\' AND valor like \'%"tipo_atencion":"TRASTORNOS DE ANSIEDAD GENERALIZADA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNOS DE ANSIEDAD"%\' AND valor like \'%"tipo_atencion":"OTROS TRASTORNOS DE ANSIEDAD"%\'',
];
$PROFESIONES[10] = [
    'LEVE',
    'MODERADO',
    'AVANZADO',
];
$FILTRO_PROFESION[10] = [
    'valor like \'%"tipo_condicion":"DEMENCIAS (INCLUYE ALZHEIMER)"%\' AND valor like \'%"tipo_atencion":"LEVE"%\'',
    'valor like \'%"tipo_condicion":"DEMENCIAS (INCLUYE ALZHEIMER)"%\' AND valor like \'%"tipo_atencion":"MODERADO"%\'',
    'valor like \'%"tipo_condicion":"DEMENCIAS (INCLUYE ALZHEIMER)"%\' AND valor like \'%"tipo_atencion":"AVANZADO"%\'',
];
$PROFESIONES[16] = [
    'AUTISMO',
    'ASPERGER',
    'SÍNDROME DE RETT',
    'TRASTORNO DESINTEGRATIVO DE LA INFANCIA',
    'TRASTONO GENERALIZADO DEL DESARROLLO NO ESPECÍFICO',
];
$FILTRO_PROFESION[16] = [
    'valor like \'%"tipo_condicion":"TRASTORNO GENERALIZADOS DEL DESARROLLO"%\' AND valor like \'%"tipo_atencion":"AUTISMO"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNO GENERALIZADOS DEL DESARROLLO"%\' AND valor like \'%"tipo_atencion":"ASPERGER"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNO GENERALIZADOS DEL DESARROLLO"%\' AND valor like \'%"tipo_atencion":"SÍNDROME DE RETT"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNO GENERALIZADOS DEL DESARROLLO"%\' AND valor like \'%"tipo_atencion":"TRASTORNO DESINTEGRATIVO DE LA INFANCIA"%\'',
    'valor like \'%"tipo_condicion":"TRASTORNO GENERALIZADOS DEL DESARROLLO"%\' AND valor like \'%"tipo_atencion":"TRASTONO GENERALIZADO DEL DESARROLLO NO ESPECÍFICO"%\'',
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
<section id="seccion_A03A2" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN O: EGRESOS DEL PROGRAMA DE SALUD  MENTAL POR ALTAS CLÍNICAS EN APS /ESPECIALIDAD [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                PROFESIONAL
            </td>

            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="34" >
                POR EDAD
            </td>
            <td rowspan="3">
                GESTANTES
            </td>
            <td rowspan="3">
                MADRE DE HIJO MENOR DE 5 AÑOS
            </td>
            <td colspan="2" rowspan="1">
                PUEBLOS ORIGINARIOS
            </td>
            <td rowspan="3">
                Niños, Niñas, Adolescentes y Jóvenes Población SENAME
            </td>
            <td rowspan="3">
                MIGRANTES
            </td>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="2" rowspan="2">'.$item.'</td>';
            }
            ?>
        </tr>

        <tr>
            <td>AMBOS</td>
            <td>HOMBRE</td>
            <td>MUJER</td>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td>HOMBRE</td>';
                echo '<td>MUJER</td>';
            }
            ?>
        </tr>

        <?php
        foreach ($FILA_HEAD as $i => $FILA){

            $total_fila = 0;
            echo '<tr>';
            echo '<td rowspan="'.count($PROFESIONES[$i]).'">' . $FILA . '</td>';
            foreach ($PROFESIONES[$i] AS $indice => $profesion){
                $filtro_fila = $FILTRO_PROFESION[$i][$indice];
                $total_hombre = 0;
                $total_mujer = 0;
                echo '<td>'.$profesion.'</td>';
                $fila = '';
                foreach ($rango_seccion as $c => $filtro_columna) {
                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='M'
                          and valor like '%:%".$profesion."%'
                        $filtro_lugar
                        and $filtro_fila 
                        and $filtro_columna ";

                    $row = mysql_fetch_array(mysql_query($sql));
                    if($row){
                        $total = $row['total'];
                    }else{
                        $total = 0;
                    }
                    $fila .= '<td>'.$total.'</td>';
                    $total_hombre+=$total;

                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='F'
                          and valor like '%:%".$profesion."%'
                        $filtro_lugar
                        and $filtro_fila 
                        and $filtro_columna ";

                    $row = mysql_fetch_array(mysql_query($sql));
                    if($row){
                        $total = $row['total'];
                    }else{
                        $total = 0;
                    }
                    $fila .= '<td>'.$total.'</td>';
                    $total_mujer+=$total;
                }

                //GESTANTE
                $sql = 'select count(*) as total from registro_rem  
                        where fecha_registro>=\'$fecha_inicio\' 
                          and fecha_registro<=\'$fecha_termino\'
                          and valor like \'%"GESTANTES":"SI"%\'
                        '.$filtro_lugar.'
                        and '.$filtro_fila.' 
                        and '.$filtro_columna.' ';

                $row = mysql_fetch_array(mysql_query($sql));
                if($row){
                    $total = $row['total'];
                }else{
                    $total = 0;
                }
                $fila .= '<td>'.$total.'</td>';
                //MADRE DE HIJO MENOR DE 5 AÑOS
                $sql = 'select count(*) as total from registro_rem  
                        where fecha_registro>=\'$fecha_inicio\' 
                          and fecha_registro<=\'$fecha_termino\'
                          and valor like \'%"MADRE DE HIJO MENOR DE 5 AÑOS":"SI"%\'
                        '.$filtro_lugar.'
                        and '.$filtro_fila.' 
                        and '.$filtro_columna.' ';

                $row = mysql_fetch_array(mysql_query($sql));
                if($row){
                    $total = $row['total'];
                }else{
                    $total = 0;
                }
                $fila .= '<td>'.$total.'</td>';
                //SENAME
                $sql = 'select count(*) as total from registro_rem  
                        where fecha_registro>=\'$fecha_inicio\' 
                          and fecha_registro<=\'$fecha_termino\'
                          and valor like \'%"SENAME":"SI"%\'
                        '.$filtro_lugar.'
                        and '.$filtro_fila.' 
                        and '.$filtro_columna.' ';

                $row = mysql_fetch_array(mysql_query($sql));
                if($row){
                    $total = $row['total'];
                }else{
                    $total = 0;
                }
                $fila .= '<td>'.$total.'</td>';
                //MIGRANTES
                $sql = 'select count(*) as total from registro_rem  
                        where fecha_registro>=\'$fecha_inicio\' 
                          and fecha_registro<=\'$fecha_termino\'
                          and valor like \'%"MIGRANTE":"SI"%\'
                        '.$filtro_lugar.'
                        and '.$filtro_fila.' 
                        and '.$filtro_columna.' ';

                $row = mysql_fetch_array(mysql_query($sql));
                if($row){
                    $total = $row['total'];
                }else{
                    $total = 0;
                }
                $fila .= '<td>'.$total.'</td>';

                echo '<td>'.($total_mujer+$total_hombre).'</td>';
                echo '<td>'.$total_hombre.'</td>';
                echo '<td>'.$total_mujer.'</td>';
                echo $fila;


                echo '</tr>';
                echo '<tr>';
            }
            echo '</tr>';
        }
        ?>

    </table>
</section>

