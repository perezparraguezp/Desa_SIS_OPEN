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


];
$rango_seccion_text = [
    '',
    '',
    '',
    '',
    '',
];

$FILA_HEAD = [
    'DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA',
    'ACTIVIDADES DE PROMOCIÓN DE LA SALUD',
    'ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES',
    'ASESORÍA A GRUPOS COMUNITARIOS',


];
$FILA_HEAD_SQL = [

    'valor like \'%"tipo_atencion":"DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES DE PROMOCIÓN DE LA SALUD"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\'',
    'valor like \'%"tipo_atencion":"ASESORÍA A GRUPOS COMUNITARIOS"%\'',

];

$PROFESIONES[0] = [
    'COMUNAS, COMUNIDADES',
    'ORGANIZACIONES ASOCIADAS A DISCAPACIDAD',
    'ORGANIZACIONES COMUNITARIAS',
    'COMUNIDAD EDUCATIVA',

];
$FILTRO_PROFESION[0] = [
    'valor like \'%"tipo_atencion":"DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA"%\' AND valor like \'%"tipo_grupo":"COMUNAS, COMUNIDADES"%\'',
    'valor like \'%"tipo_atencion":"DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA"%\' AND valor like \'%"tipo_grupo":"ORGANIZACIONES ASOCIADAS A DISCAPACIDAD"%\'',
    'valor like \'%"tipo_atencion":"DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA"%\' AND valor like \'%"tipo_grupo":"ORGANIZACIONES COMUNITARIAS"%\'',
    'valor like \'%"tipo_atencion":"DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA"%\' AND valor like \'%"tipo_grupo":"COMUNIDAD EDUCATIVA"%\'',

];
$PROFESIONES[1] = [
    'COMUNAS, COMUNIDADES.',
    'EMPLEADORES Y COMPAÑEROS DE TRABAJO',
    'COMUNIDAD EDUCATIVA',
    'RED DE APOYO',
    'CUIDADORES',
];
$FILTRO_PROFESION[1] = [
    'valor like \'%"tipo_atencion":"ACTIVIDADES DE PROMOCIÓN DE LA SALUD"%\' AND valor like \'%"tipo_grupo":"COMUNAS, COMUNIDADES."%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES DE PROMOCIÓN DE LA SALUD"%\' AND valor like \'%"tipo_grupo":"EMPLEADORES Y COMPAÑEROS DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES DE PROMOCIÓN DE LA SALUD"%\' AND valor like \'%"tipo_grupo":"COMUNIDAD EDUCATIVA"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES DE PROMOCIÓN DE LA SALUD"%\' AND valor like \'%"tipo_grupo":"RED DE APOYO"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES DE PROMOCIÓN DE LA SALUD"%\' AND valor like \'%"tipo_grupo":"CUIDADORES"%\'',

];
$PROFESIONES[2] = [
    'PROFESIONALES DE SALUD',
    'EMPLEADORES Y COMPAÑEROS DE TRABAJO',
    'COMUNIDAD EDUCATIVA',
    'MONITORES',
    'RED DE APOYO',
    'CUIDADORES',
];
$FILTRO_PROFESION[2] = [
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"PROFESIONALES DE SALUD"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"EMPLEADORES Y COMPAÑEROS DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"COMUNIDAD EDUCATIVA"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"MONITORES"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"RED DE APOYO"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"CUIDADORES"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES"%\' AND valor like \'%"tipo_grupo":"CUIDADORES"%\'',

];
$PROFESIONES[3] = [
    'ORGANIZACIONES COMUNITARIAS',

];
$FILTRO_PROFESION[3] = [
    'valor like \'%"tipo_atencion":"ASESORÍA A GRUPOS COMUNITARIOS"%\' AND valor like \'%"tipo_grupo":"ORGANIZACIONES COMUNITARIAS"%\'',

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
            <header>SECCIÓN A:  NIVEL PRIMARIO
                <BR />SECCIÓN A.12: ACTIVIDADES Y PARTICIPACIÓN  [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                MODALIDADES DE INTERVENCIÓN
            </td>
            <td rowspan="3">
                GRUPO OBJETIVO
            </td>
            <td colspan="2" rowspan="2">
                TOTALES RBC
            </td>
            <td colspan="2" rowspan="2">
                TOTALES RI
            </td>
            <td colspan="2" rowspan="2">
                TOTALES RR
            </td>
            <td colspan="2" rowspan="2">
                OTROS TOTALES
            </td>
            <td colspan="2" rowspan="2">
                UAPORRINO
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

            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td>Actividades</td>';
                echo '<td>Participantes </td>';
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






