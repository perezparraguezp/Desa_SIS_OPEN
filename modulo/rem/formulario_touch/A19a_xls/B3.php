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
$filtro_lugar .= "and tipo_form='$form' and seccion_form='$seccion' ";



//rango de meses en dias
$rango_seccion = [


];
$rango_seccion_text = [

];

$FILA_HEAD = [
    'COMUNAS, COMUNIDADES',
    'ESPACIOS AMIGABLES EN APS',
    'LUGARES DE TRABAJO',
    'ESTABLECIMIENTOS EDUCACIONALES',
    'OFICINA INTERCULTURAL',
    'OTROS',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"COMUNAS, COMUNIDADES"%\'',
    'valor like \'%"tipo_atencion":"ESPACIOS AMIGABLES EN APS"%\'',
    'valor like \'%"tipo_atencion":"LUGARES DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"ESTABLECIMIENTOS EDUCACIONALES"%\'',
    'valor like \'%"tipo_atencion":"OFICINA INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"OTROS"%\'',

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

<section id="seccion_A02A" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN B: ACTIVIDADES DE PROMOCIÓN
                <BR />SECCIÓN B.3: ACTIVIDADES DE GESTIÓN SEGÚN TIPO, POR ESPACIOS DE ACCIÓN [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td colspan="1"ROWSPAN="1" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ESPACIOS DE ACCIÓN
            </td>
            <td rowspan="1" >
                TOTAL ACTIVIDADES
            </td>
            <td colspan="1"ROWSPAN="1">
                REUNIONES DE GESTIÓN
            </td>
            <td colspan="1"ROWSPAN="1">
                REUNIONES  MASIVAS DE GESTIÓN
            </td>
            <td colspan="1"ROWSPAN="1">
                ACCIONES DE COMUNICACIÓN Y DIFUSIÓN
            </td>
            <td colspan="1"ROWSPAN="1">
                PREPARACIÓN ACTIVIDADES EDUCATIVAS
            </td>
            <td colspan="1"ROWSPAN="1">
                ENTREVISTAS
            </td>
            <td colspan="1"ROWSPAN="1">
                INVESTIGACIÓN Y CAPACITACIÓN DE RRHH
            </td>
        </tr>

        <?php
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila =$FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';
            echo '<tr>';
            echo '<td>'.$FILA.'</td>';
            foreach ($rango_seccion as $c => $filtro_columna){
                $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' and fecha_registro<='$fecha_termino'
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


        }
        ?>
    </table>
</section>


