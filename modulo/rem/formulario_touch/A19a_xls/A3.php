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
    'CON RIESGO PSICOSOCIAL',
    'CON INTEGRANTE DE PATOLOGÍA CRÓNICA',
    'CON INTEGRANTE CON PROBLEMA DE SALUD MENTAL',
    'CON ADULTO MAYOR DEPENDIENTE',
    'CON ADULTO MAYOR CON DEMENCIA',
    'CON INTEGRANTE CON ENFERMEDAD TERMINAL',
    'CON INTEGRANTE DEPENDIENTE SEVERO',
    'OTRAS ÁREAS DE INTERVENCIÓN',
    'CON ADOLESCENTE VIH (+)',
];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"CON RIESGO PSICOSOCIAL"%\'',
    'valor like \'%"tipo_atencion":"CON INTEGRANTE DE PATOLOGÍA CRÓNICA"%\'',
    'valor like \'%"tipo_atencion":"CON INTEGRANTE CON PROBLEMA DE SALUD MENTAL"%\'',
    'valor like \'%"tipo_atencion":"CON ADULTO MAYOR DEPENDIENTE"%\'',
    'valor like \'%"tipo_atencion":"CON ADULTO MAYOR CON DEMENCIA"%\'',
    'valor like \'%"tipo_atencion":"CON INTEGRANTE CON ENFERMEDAD TERMINAL"%\'',
    'valor like \'%"tipo_atencion":"CON INTEGRANTE DEPENDIENTE SEVERO"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS DE INTERVENCIÓN"%\'',
    'valor like \'%"tipo_atencion":"CON ADOLESCENTE VIH (+)"%\'',

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
            <header>SECCIÓN A: CONSEJERÍAS
                <BR />SECCIÓN A.3: CONSEJERÍAS FAMILIARES [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td colspan="1"ROWSPAN="10" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TEMAS PRIORIDAD
            </td>
            <td rowspan="1" >
                FAMILIA
            </td>
            <td colspan="1"ROWSPAN="1">
                TOTAL ACTIVIDADES
            </td>
            <td colspan="1"ROWSPAN="1">
                ESPACIOS AMIGABLES
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
