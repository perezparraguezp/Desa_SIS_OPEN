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
$filtro_lugar .= 'and tipo_form=\''.$form.'\' and valor like \'%"seccion":"D"%\' ';


//rango de meses en dias
$rango_seccion = [
    "registro_rem.edad like '%6 A 11%'",
    "registro_rem.edad like '%12 A 23%'",
    "registro_rem.edad like '%2 A 4%'",
    "registro_rem.edad like '%5 A 9%'",
    "registro_rem.edad like '%10 A 14%'",
    "registro_rem.edad like '%15 A 19%'",
    "registro_rem.edad like '%20 A 24%'",
    "registro_rem.edad like '%25 A 44%'",
    "registro_rem.edad like '%45 A 64%'",
    "registro_rem.edad like '%65 A 69%'",
    "registro_rem.edad like '%70 A 79%'",
    "registro_rem.edad like '%80%'",

];
$rango_seccion_text = [
    '6 A 11 MESES', //menor 1 MES
    '12 A 23 MESES', //menor 1 MES
    '2 A 4', //menor 1 MES
    '5 A 9', //menor 1 MES
    '10 A 14', //menor 1 MES
    '15 A1 19', //menor 1 MES
    '20 A1 24', //menor 1 MES
    '25 A1 44', //menor 1 MES
    '45 A1 64', //menor 1 MES
    '65 A1 69', //menor 1 MES
    '70 A1 79', //menor 1 MES
    '80 y MAS', //menor 1 MES
];

$FILA_HEAD = [
    'ORIGEN FÍSICO',
    'ORIGEN SENSORIAL VISUAL',
    'ORIGEN SENSORIAL AUDITIVO',
    'ORIGEN MENTAL PSÍQUICO',
    'ORIGEN MENTAL INTELECTUAL',
    'ORIGEN MÚLTIPLE',
];
$FILA_HEAD_SQL = [
    'valor like \'%"origen_fisico":"##"%\'',
    'valor like \'%"origen_sensorial_visual":"##"%\'',
    'valor like \'%"origen_sensorial_auditivo":"##"%\'',
    'valor like \'%"origen_mental_psiquico":"##"%\'',
    'valor like \'%"origen_mental_intelectual":"##"%\'',
    'valor like \'%"origen_multiple":"##"%\'',
];

$PROFESIONES[0] = ['SIN DISCAPACIDAD',
                    'DISCAPACIDAD LEVE',
                    'DISCAPACIDAD MODERADA',
                    'DISCAPACIDAD SEVERA',
                    'DISCAPACIDAD PROFUNDA',];

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
            <td colspan="24">
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
        //total
        echo '<tr>';
        echo '<td colspan="2">TOTAL EVALUACIONES</td>';

        $total_hombre = 0;
        $total_mujer = 0;
        $fila = '';
        foreach ($rango_seccion as $c => $filtro_columna) {
            $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='M'
                        $filtro_lugar
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
                          $filtro_lugar
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

        echo '<td>'.($total_mujer+$total_hombre).'</td>';
        echo '<td>'.$total_hombre.'</td>';
        echo '<td>'.$total_mujer.'</td>';
        echo $fila;
        echo '</tr>';
        ?>


        <?php

        $FILA_HEAD = [
            'EVALUACIÓN INGRESO',
            'EVALUACIÓN EGRESO',
        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"evaluacion_ingreso":"##"%\'',
            'valor like \'%"evaluacion_egreso":"##"%\'',
        ];


        $PROFESIONES[0] = ['SIN DISCAPACIDAD',
            'DISCAPACIDAD LEVE',
            'DISCAPACIDAD MODERADA',
            'DISCAPACIDAD SEVERA',
            'DISCAPACIDAD PROFUNDA',];

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
        //total
        echo '<tr>';
        echo '<td colspan="2">TOTAL EVALUACIONES</td>';

        $total_hombre = 0;
        $total_mujer = 0;
        $fila = '';
        foreach ($rango_seccion as $c => $filtro_columna) {
            $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='M'
                        $filtro_lugar
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
                          $filtro_lugar
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

        echo '<td>'.($total_mujer+$total_hombre).'</td>';
        echo '<td>'.$total_hombre.'</td>';
        echo '<td>'.$total_mujer.'</td>';
        echo $fila;
        echo '</tr>';
        ?>

    </table>
</section>
