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

    "registro_rem.edad like '0 A 19'",
    "registro_rem.edad like '20 A 64'",
    "registro_rem.edad like '65 Y MAS'",
    "registro_rem.edad like 'HOMBRES'",
    "registro_rem.edad like 'MUJERES'",

];
$rango_seccion_text = [
    '0 A 19',//
    '20 A 64',//
    '65 Y MAS',//
    'HOMBRES',//
    'MUJERES',//

];


$FILA_HEAD = [
    'INGRESOS',
    'PACIENTES ATENDIDOS',
    'ATENCIONES REALIZADAS POR EQUIPO',
    'DIAS CAMA EFECTIVAMENTE UTILIZADOS',
    'DERIVACION A HOSPITAL POR AGRAVAMIENTO',
    'EGRESOS POR ALTA',
    'FALLECIMIENTOS',


];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"INGRESOS"%\'',
    'valor like \'%"tipo_atencion":"PACIENTES ATENDIDOS"%\'',
    'valor like \'%"tipo_atencion":"ATENCIONES REALIZADAS POR EQUIPO"%\'',
    'valor like \'%"tipo_atencion":"DIAS CAMA EFECTIVAMENTE UTILIZADOS"%\'',
    'valor like \'%"tipo_atencion":"DERIVACION A HOSPITAL POR AGRAVAMIENTO"%\'',
    'valor like \'%"tipo_atencion":"EGRESOS POR ALTA"%\'',
    'valor like \'%"tipo_atencion":"FALLECIMIENTOS"%\'',

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
            <header>SECCIÓN G: HOSPITALIZACIÓN DOMICILIARIA EN APS  [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                COMPONENTES
            </td>
            <td colspan="1" rowspan="2">
                TOTAL
            </td>
            <td colspan="3">
                EDAD
            </td>
            <td colspan="2">
                SEXO
            </td>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="1">'.$item.'</td>';
            }
            ?>
        </tr>
        <?php
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila =$FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';
            $total_hombre = 0;
            $total_mujer = 0;
            foreach ($rango_seccion as $c => $filtro_columna){
                if($c<2){
                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='M'
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
                }else{
                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
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

            }

            echo '<tr>';
            echo '<td>'.$FILA.'</td>';

            echo $fila;
            echo '</tr>';

        }
        ?>
    </table>
</section>











