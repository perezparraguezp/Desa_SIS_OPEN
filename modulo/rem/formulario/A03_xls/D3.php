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
$filtro_lugar .= 'and tipo_form=\''.$form.'\' and valor like \'%"seccion":"D"%\' and valor like \'%"sub_seccion":"D3"%\' ';


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
    "registro_rem.edad like '%80%'",

];
$rango_seccion_text = [
    '0 A 4', //menor 1 MES
    '5 A 9', //menor 1 MES
    '10 A 14', //menor 1 MES
    '15 A1 19', //menor 1 MES
    '20 A1 24', //menor 1 MES
    '25 A1 29', //menor 1 MES
    '30 A1 34', //menor 1 MES
    '35 A1 39', //menor 1 MES
    '40 A1 44', //menor 1 MES
    '45 A1 49', //menor 1 MES
    '50 A1 54', //menor 1 MES
    '55 A1 59', //menor 1 MES
    '60 A1 64', //menor 1 MES
    '65 A1 69', //menor 1 MES
    '70 A1 74', //menor 1 MES
    '75 A1 79', //menor 1 MES
    '80 y MAS', //menor 1 MES
];

$FILA_HEAD = [
    'EVALUACION AL INGRESO',
    'EVALUACION AL EGRESO',
];
$FILA_HEAD_SQL = [
    'valor like \'%"eval_ingreso":"##"%\'',
    'valor like \'%"eval_egreso":"##"%\'',
];

$PROFESIONES[0] = ['BAJO',
    'MEDIO',
    'ALTO',
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
            <header>SECCIÓN D: OTRAS EVALUACIONES, APLICACIONES Y RESULTADOS DE ESCALAS EN TODAS LAS EDADES
                <BR />SECCION D.3: APLICACIÓN Y RESULTADO DE PAUTA DE EVALUACIÓN Y SALUD MENTAL [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                RESULTADOS
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="34">
                POR EDAD
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
        $TOTAL['HOMBRE']=Array(0);
        $TOTAL['MUJER']=Array(0);
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila = $FILA_HEAD_SQL[$i];
            $total_fila = 0;


            echo '<tr>';
            echo '<td rowspan="'.count($PROFESIONES[0]).'">' . $FILA . '</td>';
            foreach ($PROFESIONES[0] AS $indice => $profesion){
                $total_hombre = 0;
                $total_mujer = 0;
                echo '<td>'.$profesion.'</td>';
                $fila = '';
                foreach ($rango_seccion as $c => $filtro_columna) {
                    $filtro_fila_1 = str_replace("##",$profesion,$filtro_fila);
                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='M'
                        $filtro_lugar
                        and $filtro_fila_1 
                        and $filtro_columna ";

                    $row = mysql_fetch_array(mysql_query($sql));
                    if($row){
                        $total = $row['total'];
                    }else{
                        $total = 0;
                    }
                    $fila .= '<td>'.$total.'</td>';
                    $total_hombre+=$total;
                    $TOTAL['HOMBRE'][$filtro_columna] +=$total;

                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='F'
                        $filtro_lugar
                        and $filtro_fila_1 
                        and $filtro_columna ";

                    $row = mysql_fetch_array(mysql_query($sql));
                    if($row){
                        $total = $row['total'];
                    }else{
                        $total = 0;
                    }
                    $fila .= '<td>'.$total.'</td>';
                    $total_mujer+=$total;
                    $TOTAL['MUJER'][$filtro_columna] +=$total;
                }

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
