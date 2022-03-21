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

    "registro_rem.edad like '%<12 MESES%'",
    "registro_rem.edad like '%12 A 23 MESES%'",
    "registro_rem.edad like '%2 A 4%'",
    "registro_rem.edad like '%5 A 9%'",
    "registro_rem.edad like '10 A 14'",
    "registro_rem.edad like '15 A 19'",
    "registro_rem.edad like '20 A 24'",
    "registro_rem.edad like '25 A 29'",
    "registro_rem.edad like '30 A 34'",
    "registro_rem.edad like '35 A 39'",
    "registro_rem.edad like '40 A 44'",
    "registro_rem.edad like '45 A 49'",
    "registro_rem.edad like '50 A 54'",
    "registro_rem.edad like '55 A 59'",
    "registro_rem.edad like '60 A 64 %'",
    "registro_rem.edad like '65 A 74 %'",
    "registro_rem.edad like '75 Y 79 %'",
    "registro_rem.edad like '80 Y MAS %'",
];
$rango_seccion_text = [

    'MENOR 12 MESES',
    '12 A 23 MESES',
    '2 A 4',
    '5 A 9',
    '10 A 14',
    '15 A 19',
    '20 A 24',
    '25 A 29',
    '30 A 34',
    '35 A 39',
    '40 y 44',
    '45 A 49',
    '50 A 54',
    '55 A 59',
    '60 A 64',
    '65 A 69',
    '70 A 74',
    '75 A 79',
    '80 y MAS',



];

$FILA_HEAD = [
    'TOTAL INGRESO (N° DE PERSONAS)',
    'CONDICIÓN FÍSICA',
    'CONDICIÓN SENSORIAL VISUAL',
    'CONDICIÓN SENSORIAL AUDITIVO',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"TOTAL INGRESO (N° DE PERSONAS)"%\'',
    'valor like \'%"tipo_atencion":"CONDICIÓN FÍSICA"%\'',
    'valor like \'%"tipo_atencion":"CONDICIÓN SENSORIAL VISUAL"%\'',
    'valor like \'%"tipo_atencion":"CONDICIÓN SENSORIAL AUDITIVO"%\'',

];


$PROFESIONES[0] = [
    '',


];
$FILTRO_PROFESION[0] = [

];
$PROFESIONES[1] = [
    'SÍNDROME DOLOROSO DE ORIGEN TRAUMÁTICO',
    'ARTROSIS LEVE Y MODERADA DE RODILLA Y CADERA',
    'NEUROLÓGICOS ACCIDENTE CEREBRO VASCULAR (ACV)',
    'NEUROLÓGICOS  TRAUMATISMO ENCÉFALO CRANEANO (TEC)',
    'NEUROLÓGICOS LESIÓN MEDULAR',
    'QUEMADOS (NO GES)',
    'GRAN QUEMADO (GES)',
    'ENFERMEDAD DE PARKINSON',
    'NEUROLÓGICOS DISRAFIA',
    'OTRO DÉFICIT SECUNDARIO CON COMPROMISO NEUROMUSCULAR EN MENOR DE 20 AÑOS CONGÉNITO',
    'OTRO DÉFICIT SECUNDARIO CON COMPROMISO NEUROMUSCULAR EN MENOR DE 20 AÑOS ADQUIRIDO',
    'OTRO DÉFICIT SECUNDARIO CON COMPROMISO NEUROMUSCULAR  EN MAYOR DE 20 AÑOS',
    'OTROS',
    'DIABETES MELLITUS',
    'AMPUTACIÓN POR DIABETES',
    'AMPUTACIÓN POR OTRAS CAUSAS',
    'ARTROSIS SEVERA DE RODILLA Y CADERA',
    'OTRAS ARTROSIS',
    'REUMATOLÓGICAS',
    'DOLOR LUMBAR',
    'HOMBRO DOLOROSO',
    'CUIDADOS PALIATIVOS',
    'OTROS SÍNDROMES DOLOROSOS NO TRAUMÁTICOS',


];
$FILTRO_PROFESION[1] = [
];
$PROFESIONES[2] = [
    '',
];
$FILTRO_PROFESION[2] = [

];
$PROFESIONES[3] = [
    '',
];
$FILTRO_PROFESION[3] = [

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
<section id="seccion_A03A5" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN A:  NIVEL PRIMARIO
                <BR />SECCIÓN A.2: INGRESOS POR CONDICIÓN DE SALUD [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" COLSPAN="1" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                CONDICIÓN DE SALUD
            </td>
            <td   COLSPAN="1" rowspan="3">
                CONCEPTO
            </td>
            <td   rowspan="3">
                TOTAL
            </td>
            <td colspan="38" rowspan="1">
                POR EDAD (en años)
            </td>
            <td rowspan="2" COLSPAN="5">
                TIPO DE ESTRATEGIA
            </td>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="2">'.$item.'</td>';
            }
            ?>
        </tr>
        <tr>

            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td>HOMBRE</td>';
                echo '<td>MUJER</td>';
            }
            ?>
            <td>Rehabilitación Base Comunitaria (RBC)</td>
            <td>Rehabilitación Integral(RI)</td>
            <td>Rehabilitación Rural (RR)</td>
            <td>Otros</td>
            <td>UAPORRINO</td>
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

                }

                echo $fila;

                echo '</tr>';
                echo '<tr>';
            }
            echo '</tr>';
        }
        ?>
    </table>
</section>















