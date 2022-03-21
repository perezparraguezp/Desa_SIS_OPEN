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
    'TOTAL ',
    'HOMBRES',
    'MUEJRES',
    'Reclamos generados en el mes',
    'Reclamos generados en el mes anterior',
    'Respuestas pendientes dentro del plazo legal',
    'Respuestas pendientes fuera del plazo legal',

];


$FILA_HEAD = [
  'TOTAL DE RECLAMOS',
  'TRATO',
  'COMPETENCIA TÉCNICA',
  'INFRAESTRUCTURA',
  'TIEMPO DE ESPERA (EN SALA DE ESPERA)',
  'TIEMPO DE ESPERA, POR CONSULTA ESPECIALIDAD (POR LISTA DE ESPERA)',
  'TIEMPO DE ESPERA, POR PROCEDIMIENTO (LISTA DE ESPERA)',
  'TIEMPO DE ESPERA , POR CIRUGÍA (LISTA DE ESPERA)',
  'INFORMACIÓN',
  'PROCEDIMIENTOS ADMINISTRATIVOS',
  'PROBIDAD ADMINISTRATIVA',
  'INCUMPLIMIENTO GARANTÍAS EXPLÍCITAS EN SALUD (GES)',
  'INCUMPLIMIENTO DE GARANTÍAS LEY RICARTE SOTO',
  'INCUMPLIMIENTO DE GARANTÍAS FOFAR',
  'CONSULTAS',
  'SUGERENCIAS',
  'FELICITACIONES',
  'SOLICITUDES',
  'SOLICITUDES LEY 20.285 (Ley de Transparencia)',


];
$FILA_HEAD_SQL = [

    'valor like \'%"tipo_atencion":"TOTAL DE RECLAMOS"%\'',
    'valor like \'%"tipo_atencion":"TRATO"%\'',
    'valor like \'%"tipo_atencion":"COMPETENCIA TÉCNICA"%\'',
    'valor like \'%"tipo_atencion":"INFRAESTRUCTURA"%\'',
    'valor like \'%"tipo_atencion":"TIEMPO DE ESPERA (EN SALA DE ESPERA)"%\'',
    'valor like \'%"tipo_atencion":"TIEMPO DE ESPERA, POR CONSULTA ESPECIALIDAD (POR LISTA DE ESPERA)"%\'',
    'valor like \'%"tipo_atencion":"TIEMPO DE ESPERA, POR PROCEDIMIENTO (LISTA DE ESPERA)"%\'',
    'valor like \'%"tipo_atencion":"TIEMPO DE ESPERA , POR CIRUGÍA (LISTA DE ESPERA)"%\'',
    'valor like \'%"tipo_atencion":"INFORMACIÓN"%\'',
    'valor like \'%"tipo_atencion":"PROCEDIMIENTOS ADMINISTRATIVOS"%\'',
    'valor like \'%"tipo_atencion":"PROBIDAD ADMINISTRATIVA"%\'',
    'valor like \'%"tipo_atencion":"INCUMPLIMIENTO GARANTÍAS EXPLÍCITAS EN SALUD (GES)"%\'',
    'valor like \'%"tipo_atencion":"INCUMPLIMIENTO DE GARANTÍAS LEY RICARTE SOTO"%\'',
    'valor like \'%"tipo_atencion":"INCUMPLIMIENTO DE GARANTÍAS FOFAR"%\'',
    'valor like \'%"tipo_atencion":"CONSULTAS"%\'',
    'valor like \'%"tipo_atencion":"SUGERENCIAS"%\'',
    'valor like \'%"tipo_atencion":"FELICITACIONES"%\'',
    'valor like \'%"tipo_atencion":"SOLICITUDES"%\'',
    'valor like \'%"tipo_atencion":"SOLICITUDES LEY 20.285 (Ley de Transparencia)"%\'',

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
            <header>SECCIÓN A: ATENCIÓN OFICINAS DE INFORMACIONES (SISTEMA INTEGRAL DE ATENCIÓN A USUARIOS) [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO DE ATENCION
            </td>
            <td colspan="3" rowspan="1">
                Nº DE ATENCIONES EN EL MES
            </td>
            <td colspan="2"rowspan="1">
                RESPUESTAS DEL MES DENTRO DE PLAZOS LEGALES ( 15 DIAS HÁBILES)
            </td>
            <td  rowspan="2">
                RECLAMOS RESPONDIDOS FUERA DE PLAZOS LEGALES
            </td>
            <td colspan="2" rowspan="1">
                RECLAMOS PENDIENTES
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
                if($c<1){
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
            echo '<td>'.($total_mujer+$total_hombre).'</td>';
            echo '<td>'.$total_hombre.'</td>';
            echo '<td>'.$total_mujer.'</td>';

            echo $fila;
            echo '</tr>';

        }
        ?>
    </table>
</section>






