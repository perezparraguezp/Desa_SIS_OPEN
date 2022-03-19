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

    'valor like \'%"GESTANTE":"SI"%\'',
    'valor like \'%"DISCAPACIDAD":"SI"%\'',
    'valor like \'%"SENAME":"SI"%\'',
    'valor like \'%"MIGRANTE":"SI"%\'',




];
$rango_seccion_text = [


];

$FILA_HEAD = [
    'ENDODONCIA',
    'REHABILITACIÓN ORAL',
    'CIRUGÍA BUCAL',
    'CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL',
    'ODONTOPEDIATRÍA ',
    'ORTODONCIA Y ORTOPEDIA DENTOMAXILOFACIAL',
    'PERIODONCIA',
    'IMAGENOLOGÍA ORAL Y MAXILOFACIAL',
    'PATOLOGÍA ORAL',
    'IMPLANTOLOGÍA BUCO MAXILOFACIAL',
    'TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL',
    'SOMATOPRÓTESIS',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"ENDODONCIA"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN ORAL"%\'',
    'valor like \'%"tipo_atencion":"CIRUGÍA BUCAL"%\'',
    'valor like \'%"tipo_atencion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\'',
    'valor like \'%"tipo_atencion":"ODONTOPEDIATRÍA"%\'',
    'valor like \'%"tipo_atencion":"ORTODONCIA Y ORTOPEDIA DENTOMAXILOFACIAL"%\'',
    'valor like \'%"tipo_atencion":"PERIODONCIA"%\'',
    'valor like \'%"tipo_atencion":"IMAGENOLOGÍA ORAL Y MAXILOFACIAL"%\'',
    'valor like \'%"tipo_atencion":"PATOLOGÍA ORAL"%\'',
    'valor like \'%"tipo_atencion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\'',
    'valor like \'%"tipo_atencion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\'',
    'valor like \'%"tipo_atencion":"SOMATOPRÓTESIS"%\'',

];
$PROFESIONES[0] = [
    '',

];
$FILTRO_PROFESION[0] = [

];
$PROFESIONES[1] = [
    'PRÓTESIS REMOVIBLES',
    'PRÓTESIS FIJA',
    'PRÓTESIS IMPLANTOASISTIDA',

];
$FILTRO_PROFESION[1] = [
    'valor like \'%"tipo_atencion":"REHABILITACIÓN ORAL"%\' AND  valor like \'%"tipo_protesis":"PRÓTESIS REMOVIBLES"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN ORAL"%\' AND  valor like \'%"tipo_protesis":"PRÓTESIS FIJA"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN ORAL"%\' AND  valor like \'%"tipo_protesis":"PRÓTESIS IMPLANTOASISTIDA"%\'',

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
$PROFESIONES[4] = [
    '',

];
$FILTRO_PROFESION[4] = [

];
$PROFESIONES[5] = [
    'ORTODONCIA Y ORTOPEDIA DENTOMAXILOFACIAL',
    'APARATOLOGÍA REMOVIBLE',

];
$FILTRO_PROFESION[5] = [
    'valor like \'%"tipo_atencion":"REHABILITACIÓN ORAL"%\' AND  valor like \'%"tipo_protesis":"ORTODONCIA Y ORTOPEDIA DENTOMAXILOFACIAL"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN ORAL"%\' AND  valor like \'%"tipo_protesis":"APARATOLOGÍA REMOVIBLE"%\'',


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
$PROFESIONES[9] = [
    '',

];
$FILTRO_PROFESION[9] = [


];
$PROFESIONES[10] = [
    '',

];
$FILTRO_PROFESION[10] = [

];
$PROFESIONES[11] = [
    '',

];
$FILTRO_PROFESION[11] = [

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
            <header>SECCIÓN D : INTERCONSULTAS GENERADAS EN ESTABLECIMIENTOS DE APS [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="1" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ESPECIALIDAD
            </td>
            <td  <td ROWSPAN="1">
                TOTAL
            </td>
            <td  <td ROWSPAN="1">
                Gestantes
            </td>
            <td ROWSPAN="1">
                60 años
            </td>
            <td ROWSPAN="1">
                Usuarios con Discapacidad
            </td>
            <td ROWSPAN="1">
                Niños. Niñas, adolescentes y jóvenes Población SENAME
            </td>
            <td ROWSPAN="1">
                Migrantes
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




