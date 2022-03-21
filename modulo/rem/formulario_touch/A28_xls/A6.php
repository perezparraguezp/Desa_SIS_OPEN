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

'',
'',
'',
'',
'',
'',

];
$rango_seccion_text = [

];


$FILA_HEAD = [
    'EVALUACIÓN AYUDAS TÉCNICAS',
    'ENTRENAMIENTO DE AYUDAS TÉCNICAS',
    'FISIOTERAPIA',
    'TRATAMIENTO COMPRESIVO',
    'ENTRENAMIENTO PROTÉSICO',
    'EJERCICIOS TERAPÉUTICOS',
    'TRATAMIENTO (VOZ, HABLA Y/O LENGUAJE)',
    'TRATAMIENTO FUNCIONES MOTORAS ORALES ',
    'ESTIMULACIÓN COGNITIVA',
    'PREVENCIÓN DE DETERIORO DE ÓRGANOS FONO ARTICULATORIOS (OFA)',
    'REHABILITACIÓN DEGLUCIÓN',
    'CONFECCIÓN ÓRTESIS Y/O ADAPTACIONES',
    'HABILITACIÓN Y REHABILITACIÓN EN ACTIVIDADES DE LA VIDA DIARIA (AVD)',
    'HABILITACIÓN Y REHABILITACIÓN EDUCACIONAL',
    'ACTIVIDADES RECREATIVAS',
    'ACTIVIDADES TERAPÉUTICAS',
    'INTEGRACIÓN SENSORIAL',
    'PSICOTERAPIA ',
    'ADAPTACIÓN DEL HOGAR',
    'ORIENTACIÓN Y MOVILIDAD',
    'ORIENTACIÓN SOCIOLABORAL',
    'ORIENTACIÓN FAMILIAR Y A LA RED DE APOYO PARA EL TRABAJO',
    'GESTIÓN DE LA RED LOCAL PARA EL TRABAJO',
    'REHABILITACIÓN AUDITIVA INDIVIDUAL',
    'REHABILITACIÓN AUDITIVA GRUPAL',
    'TOTAL',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"EVALUACIÓN AYUDAS TÉCNICAS"%\'',
    'valor like \'%"tipo_atencion":"ENTRENAMIENTO DE AYUDAS TÉCNICAS"%\'',
    'valor like \'%"tipo_atencion":"FISIOTERAPIA"%\'',
    'valor like \'%"tipo_atencion":"TRATAMIENTO COMPRESIVO"%\'',
    'valor like \'%"tipo_atencion":"ENTRENAMIENTO PROTÉSICO"%\'',
    'valor like \'%"tipo_atencion":"EJERCICIOS TERAPÉUTICOS"%\'',
    'valor like \'%"tipo_atencion":"TRATAMIENTO (VOZ, HABLA Y/O LENGUAJE)"%\'',
    'valor like \'%"tipo_atencion":"TRATAMIENTO FUNCIONES MOTORAS ORALES "%\'',
    'valor like \'%"tipo_atencion":"ESTIMULACIÓN COGNITIVA"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE DETERIORO DE ÓRGANOS FONO ARTICULATORIOS (OFA)"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN DEGLUCIÓN"%\'',
    'valor like \'%"tipo_atencion":"CONFECCIÓN ÓRTESIS Y/O ADAPTACIONES"%\'',
    'valor like \'%"tipo_atencion":"HABILITACIÓN Y REHABILITACIÓN EN ACTIVIDADES DE LA VIDA DIARIA (AVD)"%\'',
    'valor like \'%"tipo_atencion":"HABILITACIÓN Y REHABILITACIÓN EDUCACIONAL"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES RECREATIVAS"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDADES TERAPÉUTICAS"%\'',
    'valor like \'%"tipo_atencion":"INTEGRACIÓN SENSORIAL"%\'',
    'valor like \'%"tipo_atencion":"PSICOTERAPIA "%\'',
    'valor like \'%"tipo_atencion":"MASOTERAPIA"%\'',
    'valor like \'%"tipo_atencion":"ADAPTACIÓN DEL HOGAR"%\'',
    'valor like \'%"tipo_atencion":"ORIENTACIÓN Y MOVILIDAD"%\'',
    'valor like \'%"tipo_atencion":"ORIENTACIÓN SOCIOLABORAL"%\'',
    'valor like \'%"tipo_atencion":"ORIENTACIÓN FAMILIAR Y A LA RED DE APOYO PARA EL TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"GESTIÓN DE LA RED LOCAL PARA EL TRABAJO"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN AUDITIVA INDIVIDUAL"%\'',
    'valor like \'%"tipo_atencion":"REHABILITACIÓN AUDITIVA GRUPAL"%\'',
    'valor like \'%"tipo_atencion":"TOTAL"%\'',


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
            <header>SECCIÓN A:  NIVEL PRIMARIO
                <BR/>SECCIÓN A.6: PROCEDIMIENTOS Y ACTIVIDADES [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" colspan="1" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO
            </td>
            <td colspan="1" rowspan="2">
                Total Rehabilitacion Base Comunitaria
            </td>
            <td colspan="1" rowspan="2">
                Total Rehabilitación Integral
            </td>
            <td colspan="1" rowspan="2">
                Total Rehabilitacion  Rural
            </td>
            <td colspan="1" rowspan="2">
                Otros
            </td>
            <td colspan="1" rowspan="2">
                UAPORRINO
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













