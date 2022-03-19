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
    "registro_rem.edad like '%MENOR 1 AÑO%'",
    "registro_rem.edad like '%1 A 4%'",
    "registro_rem.edad like '%5 A 9%'",
    "registro_rem.edad like '%10 A 14%'",
    "registro_rem.edad like '%15 A 19%'",
    "registro_rem.edad like '%20 A 24%'",
    "registro_rem.edad like '%25 A 39%'",
    "registro_rem.edad like '%40 A 44%'",
    "registro_rem.edad like '%45 A 49%'",
    "registro_rem.edad like '%50 A 54%'",
    "registro_rem.edad like '%55 A 59%'",
    "registro_rem.edad like '%60 A 64%'",
    "registro_rem.edad like '%65 A 69%'",
    "registro_rem.edad like '%70 A 74%'",
    "registro_rem.edad like '%75 A 79%'",
    "registro_rem.edad like '%80 Y MAS%'",
    'valor like \'%"REINGRESO":"SI"%\'',

];
$rango_seccion_text = [
    'MENOR DE 1 AÑO',
    '1 A 4',
    '5 A 9',
    '10 A 14',
    '15 A 19',
    '20 A 24', //menor 1 MES
    '25 A 39', //menor 1 MES
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
    'SÍNDROME BRONQUIAL OBSTRUCTIVO RECURRENTE (SBOR)',
    'ASMA BRONQUIAL',
    'ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA (EPOC)',
    'DISPLASIA BRONCOPULMONAR',
    'FIBROSIS QUÍSTICA',
    'OXIGENO DEPENDIENTE',
    'ASISTENCIA VENTILATORIA NO INVASIVA O INVASIVA',
    'OTRAS RESPIRATORIAS CRÓNICAS',
    'TOTAL',
];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"SÍNDROME BRONQUIAL OBSTRUCTIVO RECURRENTE (SBOR)"%\'',
    'valor like \'%"tipo_atencion":"ASMA BRONQUIAL"%\'',
    'valor like \'%"tipo_atencion":"ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA (EPOC)"%\'',
    'valor like \'%"tipo_atencion":"DISPLASIA BRONCOPULMONAR"%\'',
    'valor like \'%"tipo_atencion":"FIBROSIS QUÍSTICA"%\'',
    'valor like \'%"tipo_atencion":"OXIGENO DEPENDIENTE"%\'',
    'valor like \'%"tipo_atencion":"ASISTENCIA VENTILATORIA NO INVASIVA O INVASIVA"%\'',
    'valor like \'%"tipo_atencion":"OTRAS RESPIRATORIAS CRÓNICAS"%\'',
    'valor like \'%"tipo_atencion":"TOTAL"%\'',

];
$PROFESIONES[0] = [
    'Leve',
    'Moderado',
    'Severo',

];
$FILTRO_PROFESION[0] = [
    'valor like \'%"tipo_atencion":"SÍNDROME BRONQUIAL OBSTRUCTIVO RECURRENTE (SBOR)"%\' AND valor like \'%"tipo_nivel":"Leve"%\'',
    'valor like \'%"tipo_atencion":"SÍNDROME BRONQUIAL OBSTRUCTIVO RECURRENTE (SBOR)"%\' AND valor like \'%"tipo_nivel":"Moderado"%\'',
    'valor like \'%"tipo_atencion":"SÍNDROME BRONQUIAL OBSTRUCTIVO RECURRENTE (SBOR)"%\' AND valor like \'%"tipo_nivel":"Severo"%\'',

];
$PROFESIONES[1] = [
    'Leve',
    'Moderado',
    'Severo',

];
$FILTRO_PROFESION[1] = [
    'valor like \'%"tipo_atencion":"ASMA BRONQUIAL"%\' AND valor like \'%"tipo_nivel":"Leve"%\'',
    'valor like \'%"tipo_atencion":"ASMA BRONQUIAL"%\' AND valor like \'%"tipo_nivel":"Moderado"%\'',
    'valor like \'%"tipo_atencion":"ASMA BRONQUIAL"%\' AND valor like \'%"tipo_nivel":"Severo"%\'',


];
$PROFESIONES[2] = [
    'Tipo A',
    'Tipo B',

];
$FILTRO_PROFESION[2] = [
    'valor like \'%"tipo_atencion":"ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA (EPOC)"%\' AND valor like \'%"tipo_nivel":"Tipo A"%\'',
    'valor like \'%"tipo_atencion":"ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA (EPOC)"%\' AND valor like \'%"tipo_nivel":"Tipo B"%\'',



];
$PROFESIONES[3] = [
    '',

];
$FILTRO_PROFESION[3] = [

];
$PROFESIONES[4] = [
    '',

];
$FILTRO_PROFESION[4] = [

];
$PROFESIONES[5] = [
    '',

];
$FILTRO_PROFESION[5] = [

];
$PROFESIONES[6] = [
    '',

];
$FILTRO_PROFESION[6] = [

];

$PROFESIONES[7] = [
    '',


];
$FILTRO_PROFESION[7] = [

];
$PROFESIONES[8] = [
    '',

];
$FILTRO_PROFESION[8] = [

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
            <header>SECCIÓN B: INGRESO CRÓNICO SEGÚN DIAGNÓSTICO (SOLO MÉDICO) [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                CONCEPTO
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="38">
                POR DE EDAD (en años)
            </td>
            <td ROWSPAN="3">
                REINGRESO
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

                echo $fila;

                echo '</tr>';
                echo '<tr>';
            }
            echo '</tr>';
        }
        ?>

    </table>
</section>




