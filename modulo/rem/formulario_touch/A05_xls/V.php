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
    'valor like \'%"BENEFICIARIO":"SI"%\'',
    'valor like \'%"PUEBLO":"SI"%\'',
    'valor like \'%"DOMICILIO":"SI"%\'',
    'valor like \'%"MIGRANTES":"SI"%\'',


];
$rango_seccion_text = [
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
    'Dupla (Medico + Profesional no médico)',
    'Médico',
    'Profesional No Médico',
];
$FILA_HEAD = [
    'INGRESOS',
    'PLAN DE CUIDADO ELABORADO',


];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"INGRESOS"%\'',
    'valor like \'%"tipo_atencion":"PLAN DE CUIDADO ELABORADO"%\'',


];

$PROFESIONES[0] = [
    'RIESGO LEVE (G1)',
    'RIESGO MODERADO (G2)',
    'RIESGO ALTO (G3)',
];
$FILTRO_PROFESION[0] = [
     'valor like \'%"tipo_atencion":"INGRESOS"%\' AND valor like \'%"tipo_riesgo":"RIESGO LEVE (G1)"%\'',
     'valor like \'%"tipo_atencion":"INGRESOS"%\' AND valor like \'%"tipo_riesgo":"RIESGO MODERADO (G2)"%\'',
     'valor like \'%"tipo_atencion":"INGRESOS"%\' AND valor like \'%"tipo_riesgo":"RIESGO ALTO (G3)"%\'',
];
$PROFESIONES[1] = [
    'RIESGO LEVE (G1)',
    'RIESGO MODERADO (G2)',
    'RIESGO ALTO (G3)',
];
$FILTRO_PROFESION[1] = [
    'valor like \'%"tipo_atencion":"PLAN DE CUIDADO ELABORADO"%\' AND valor like \'%"tipo_riesgo":"RIESGO LEVE (G1)"%\'',
    'valor like \'%"tipo_atencion":"PLAN DE CUIDADO ELABORADO"%\' AND valor like \'%"tipo_riesgo":"RIESGO MODERADO (G2)"%\'',
    'valor like \'%"tipo_atencion":"PLAN DE CUIDADO ELABORADO"%\' AND valor like \'%"tipo_riesgo":"RIESGO ALTO (G3)"%\'',
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
            <header>SECCIÓN V. INGRESOS  INTEGRALES DE PERSONAS CON CONDICIONES CRÓNICAS EN ATENCIÓN PRIMARIA [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ACTIVIDAD
            </td>
            <td rowspan="3">
                RIESGO
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="28" >
                POR EDAD
            </td>
            <td rowspan="3">
                BENEFICIARIOS
            </td>
            <td rowspan="3">
                MIGRANTES
            </td>
            <td rowspan="3">
              PUEBLOS ORIGINARIOS
            </td>
            <td COLSPAN="6">
                REALIZADO POR
            </td>
            <td rowspan="3">
                REALIZADO EN DOMICILIO
            </td>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="2" rowspan="1">'.$item.'</td>';
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
                          and valor like \'%"gestante":"SI"%\'
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
                //POST PARTO
                $sql = 'select count(*) as total from registro_rem  
                        where fecha_registro>=\'$fecha_inicio\' 
                          and fecha_registro<=\'$fecha_termino\'
                          and valor like \'%"post_parto":"SI"%\'
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

        }
        ?>

    </table>
</section>


