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
    'Actividad física',//
    'Alimentación',//
    'Ambiente libre de humo de tabaco',//
    'Factores protectores psicosociales',//
    'Factores protectores ambientales',//
    'Derechos humanos',//
    'Salud sexual y prevención de VIH/SIDA e ITS',//

];

$FILA_HEAD = [
    'EVENTOS  MASIVOS',
    'REUNIONES DE PLANIFICACIÓN PARTICIPATIVA',
    'ORNADAS Y SEMINARIOS',
    'EDUCACIÓN GRUPAL',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"EVENTOS  MASIVOS"%\'',
    'valor like \'%"tipo_atencion":"REUNIONES DE PLANIFICACIÓN PARTICIPATIVA"%\'',
    'valor like \'%"tipo_atencion":"ORNADAS Y SEMINARIOS"%\'',
    'valor like \'%"tipo_atencion":"EDUCACIÓN GRUPAL"%\'',

];

$PROFESIONES[0] = [
    'COMUNAS, COMUNIDADES',
    'ESPACIOS AMIGABLES EN APS',
    'LUGARES DE TRABAJO',
    'ESTABLECIMIENTOS EDUCACIÓN',
];
$FILTRO_PROFESION[0] = [
    'valor like \'%"tipo_atencion":"EVENTOS  MASIVOS"%\' AND  valor like \'%"tipo_estrategia":"COMUNAS, COMUNIDADES"%\'',
    'valor like \'%"tipo_atencion":"EVENTOS  MASIVOS"%\' AND  valor like \'%"tipo_estrategia":"ESPACIOS AMIGABLES EN APS"%\'',
    'valor like \'%"tipo_atencion":"EVENTOS  MASIVOS"%\' AND  valor like \'%"tipo_estrategia":"LUGARES DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"EVENTOS  MASIVOS"%\' AND  valor like \'%"tipo_estrategia":"ESTABLECIMIENTOS EDUCACIÓN"%\'',

];

$PROFESIONES[1] = [
    'COMUNAS, COMUNIDADES',
    'ESPACIOS AMIGABLES EN APS',
    'LUGARES DE TRABAJO',
    'ESTABLECIMIENTOS EDUCACIÓN',
];
$FILTRO_PROFESION[1] = [
    'valor like \'%"tipo_atencion":"REUNIONES DE PLANIFICACIÓN PARTICIPATIVA"%\' AND  valor like \'%"tipo_estrategia":"COMUNAS, COMUNIDADES"%\'',
    'valor like \'%"tipo_atencion":"REUNIONES DE PLANIFICACIÓN PARTICIPATIVA"%\' AND  valor like \'%"tipo_estrategia":"ESPACIOS AMIGABLES EN APS"%\'',
    'valor like \'%"tipo_atencion":"REUNIONES DE PLANIFICACIÓN PARTICIPATIVA"%\' AND  valor like \'%"tipo_estrategia":"LUGARES DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"REUNIONES DE PLANIFICACIÓN PARTICIPATIVA"%\' AND  valor like \'%"tipo_estrategia":"ESTABLECIMIENTOS EDUCACIÓN"%\'',

];

$PROFESIONES[2] = [
    'COMUNAS, COMUNIDADES',
    'ESPACIOS AMIGABLES EN APS',
    'LUGARES DE TRABAJO',
    'ESTABLECIMIENTOS EDUCACIÓN',
];
$FILTRO_PROFESION[2] = [
    'valor like \'%"tipo_atencion":"ORNADAS Y SEMINARIOS"%\' AND  valor like \'%"tipo_estrategia":"COMUNAS, COMUNIDADES"%\'',
    'valor like \'%"tipo_atencion":"ORNADAS Y SEMINARIOS"%\' AND  valor like \'%"tipo_estrategia":"ESPACIOS AMIGABLES EN APS"%\'',
    'valor like \'%"tipo_atencion":"ORNADAS Y SEMINARIOS"%\' AND  valor like \'%"tipo_estrategia":"LUGARES DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"ORNADAS Y SEMINARIOS"%\' AND  valor like \'%"tipo_estrategia":"ESTABLECIMIENTOS EDUCACIÓN"%\'',

];

$PROFESIONES[3] = [
    'COMUNAS, COMUNIDADES',
    'ESPACIOS AMIGABLES EN APS',
    'LUGARES DE TRABAJO',
    'ESTABLECIMIENTOS EDUCACIÓN',
];
$FILTRO_PROFESION[3] = [
    'valor like \'%"tipo_atencion":"EDUCACIÓN GRUPAL"%\' AND  valor like \'%"tipo_estrategia":"COMUNAS, COMUNIDADES"%\'',
    'valor like \'%"tipo_atencion":"EDUCACIÓN GRUPAL"%\' AND  valor like \'%"tipo_estrategia":"ESPACIOS AMIGABLES EN APS"%\'',
    'valor like \'%"tipo_atencion":"EDUCACIÓN GRUPAL"%\' AND  valor like \'%"tipo_estrategia":"LUGARES DE TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"EDUCACIÓN GRUPAL"%\' AND  valor like \'%"tipo_estrategia":"ESTABLECIMIENTOS EDUCACIÓN"%\'',

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
            <header>SECCIÓN B: ACTIVIDADES DE PROMOCIÓN
                <BR/>SECCIÓN B.1: ACTIVIDADES DE PROMOCIÓN SEGÚN ESTRATEGIAS Y CONDICIONANTES ABORDADAS Y NÚMERO DE PARTICIPANTES [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" colspan="1" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ACTIVIDADES
            </td>
            <td colspan="1" rowspan="2">
                ESTRATEGIA, ESPACIOS  O LÍNEAS DE ACCIÓN
            </td>
            <td colspan="1" rowspan="2">
                TOTAL ACTIVIDADES
            </td>
            <td colspan="34">
                CONDICIONANTES ABORDADAS
            </td>

            <td rowspan="2">
                DETERMINANTES SOCIALES DE LA SALUD ABORDADAS - CHILE CRECE CONTIGO
            </td>
            <td rowspan="2">
                TOTAL PARTICIPANTES
            </td>
        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="2">'.$item.'</td>';
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










