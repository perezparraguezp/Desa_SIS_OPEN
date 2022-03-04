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
$filtro_lugar .= "and tipo_form='$form' and valor like '%sub_seccion%:%$seccion%' ";


//rango de meses en dias
$rango_seccion = [
    "registro_rem.edad like 'MENOR 7 MESES'",
    "registro_rem.edad like '7 A 11 MESES'",
    "registro_rem.edad like '12 A 17 MESES'",
    "registro_rem.edad like '18 A 23 MESES'",
    "registro_rem.edad like '24 A 47 MESES'",
    "registro_rem.edad like '48 A 59 MESES'",

];
$rango_seccion_text = [
    '< 7 MESES', //menor 1 MES
    '7 A 11 MESES',
    '12 A 17 MESES', //menor 1 MES
    '18 A 23 MESES', //menor 1 MES
    '24 A 47 MESES', //menor 1 MES
    '48 A 59 MESES', //menor 1 MES
];

$FILA_HEAD = [
    'PRIMERA EVALUACIÓN',
    'REEVALUACION',
    'RESULTADO ALTERADO',
    'RESULTADO ALTERADO',
];
$FILA_HEAD_SQL = [
    "valor like '%primera_evaluacion%'",
    "valor like '%reevaluacion%'",
    "valor like '%derivados%'",
    "valor like '%traslado%'",
];

$PROFESIONES[0] = ['NORMAL','NORMAL CON REZAGO','RIESGO','RETRASO'];
$PROFESIONES[1] = ['NORMAL (desde normal con rezago)',
                    'NORMAL (desde riesgo)',
                    'NORMAL (desde retraso)',
                    'NORMAL CON REZAGO (desde riesgo)',
                    'NORMAL CON REZAGO (desde retraso)',
                    'NORMAL CON REZAGO (desde normal con rezago)',
                    'RIESGO (desde retraso)',
                    'RIESGO (desde riesgo)',
                    'RIESGO (desde normal con rezago)',
                    'RETRASO (desde retraso)',
                    'RETRASO (desde riesgo)',
                    'RETRASO (desde normal con rezago)',
    ];
$PROFESIONES[2] = ['RIESGO','RETRASO'];
$PROFESIONES[3] = ['NORMAL CON REZAGO','RIESGO','RETRASO'];

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
            <header>SECCIÓN A: APLICACIÓN DE INSTRUMENTO Y RESULTADO EN EL NIÑO (A)
                <BR />SECCIÓN A.2: RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ACTIVIDAD
            </td>
            <td rowspan="3">
                RESULTADO
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="12">
                POR EDAD
            </td>
            <td  rowspan="3">MIGRANTES</td>
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
            $filtro_fila = $FILA_HEAD_SQL[$i];
            $total_fila = 0;


            echo '<tr>';
            echo '<td rowspan="'.count($PROFESIONES[$i]).'">' . $FILA . '</td>';
            foreach ($PROFESIONES[$i] AS $indice => $profesion){
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

                $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and migrante='SI'
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
