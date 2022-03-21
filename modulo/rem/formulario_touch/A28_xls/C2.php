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

    "registro_rem.edad like '%<12 MESES%'",
    "registro_rem.edad like '%12 A 23 MESES%'",
    "registro_rem.edad like '%2 A 4%'",
    "registro_rem.edad like '%5 A 9%'",
    "registro_rem.edad like '10 A 14'",
    "registro_rem.edad like '15 A 19'",
    "registro_rem.edad like '20 A 24'",
    "registro_rem.edad like '25 A 29'",
    "registro_rem.edad like '30 A 34'",
    "registro_rem.edad like '35 A 39'",
    "registro_rem.edad like '40 A 44'",
    "registro_rem.edad like '45 A 49'",
    "registro_rem.edad like '50 A 54'",
    "registro_rem.edad like '55 A 59'",
    "registro_rem.edad like '60 A 64 %'",
    "registro_rem.edad like '65 A 74 %'",
    "registro_rem.edad like '75 Y 79 %'",
    "registro_rem.edad like '80 Y MAS %'",

];
$rango_seccion_text = [
    'MENOR 12 MESES',
    '12 A 23 MESES',
    '2 A 4',
    '5 A 9',
    '10 A 14',
    '15 A 19',
    '20 A 24',
    '25 A 29',
    '30 A 34',
    '35 A 39',
    '40 y 44',
    '45 A 49',
    '50 A 54',
    '55 A 59',
    '60 A 64',
    '65 A 69',
    '70 A 74',
    '75 A 79',
    '80 y MAS',

];


$FILA_HEAD = [
    'SILLAS DE RUEDAS ESTÁNDAR',
    'SILLA DE RUEDAS NEUROLÓGICA',
    'COJÍN ANTI ESCARAS',
    'COLCHÓN ANTI ESCARAS',
    'BASTONES',
    'ANDADORES',
    'CORSÉ',
    'ORTESIS BAJA TEMPERATURA (palmeta, cock up, digitales entre otras)',
    'ORTESIS ALTA TEMPERATURA (OTP, canaletas, canaleta con yugo, entre otras)',
    'SISTEMA COMPRESIVO',
    'PRÓTESIS EXTREMIDAD INFERIOR',
    'PRÓTESIS EXTREMIDAD SUPERIOR',
    'AYUDA TÉCNICA AUDITIVAS AUDÍFONOS',
    'AYUDA TÉCNICA VISUALES LENTES',
    'PLANTILLA ORTOPÉDICA',
    'BOTA O BOTÍN DE DESCARGA',
    'ZAPATO ORTOPÉDICO',
    'BAÑO PORTÁTIL',
    'TECNOLOGÍAS DE LA COMUNICACIÓN AUMENTATIVA Y ALTERNATIVAS',
    'EQUIPO VENTILADOR MECÁNICO NO INVASIVO',
    'ASPIRADOR DE SECRECIONES',
    'OTRAS',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_Actividad":SILLAS DE RUEDAS ESTÁNDAR"%\'',
    'valor like \'%"tipo_Actividad":SILLA DE RUEDAS NEUROLÓGICA"%\'',
    'valor like \'%"tipo_Actividad":COJÍN ANTI ESCARAS"%\'',
    'valor like \'%"tipo_Actividad":COLCHÓN ANTI ESCARAS"%\'',
    'valor like \'%"tipo_Actividad":BASTONES"%\'',
    'valor like \'%"tipo_Actividad":ANDADORES"%\'',
    'valor like \'%"tipo_Actividad":CORSÉ"%\'',
    'valor like \'%"tipo_Actividad":ORTESIS BAJA TEMPERATURA (palmeta, cock up, digitales entre otras)"%\'',
    'valor like \'%"tipo_Actividad":ORTESIS ALTA TEMPERATURA (OTP, canaletas, canaleta con yugo, entre otras)"%\'',
    'valor like \'%"tipo_Actividad":SISTEMA COMPRESIVO"%\'',
    'valor like \'%"tipo_Actividad":PRÓTESIS EXTREMIDAD INFERIOR"%\'',
    'valor like \'%"tipo_Actividad":PRÓTESIS EXTREMIDAD SUPERIOR"%\'',
    'valor like \'%"tipo_Actividad":AYUDA TÉCNICA AUDITIVAS AUDÍFONOS"%\'',
    'valor like \'%"tipo_Actividad":AYUDA TÉCNICA VISUALES LENTES"%\'',
    'valor like \'%"tipo_Actividad":PLANTILLA ORTOPÉDICA"%\'',
    'valor like \'%"tipo_Actividad":BOTA O BOTÍN DE DESCARGA"%\'',
    'valor like \'%"tipo_Actividad":ZAPATO ORTOPÉDICO"%\'',
    'valor like \'%"tipo_Actividad":BAÑO PORTÁTIL"%\'',
    'valor like \'%"tipo_Actividad":TECNOLOGÍAS DE LA COMUNICACIÓN AUMENTATIVA Y ALTERNATIVAS"%\'',
    'valor like \'%"tipo_Actividad":EQUIPO VENTILADOR MECÁNICO NO INVASIVO"%\'',
    'valor like \'%"tipo_Actividad":ASPIRADOR DE SECRECIONES"%\'',
    'valor like \'%"tipo_Actividad":OTRAS"%\'',

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
            <header>SECCIÓN C: AYUDAS TÉCNICAS DE SALUD, NIVEL APS Y HOSPITALARIO
                <BR/>SECCIÓN C.2: NÚMERO DE  AYUDAS TÉCNICAS ENTREGADAS POR TIPO [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" colspan="1" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TOTAL DE AYUDAS TÉCNICAS ENTREGADAS
            </td>
            <td colspan="1" rowspan="2">
                TOTAL
            </td>
            <td colspan="19">
                POR DE EDAD (en años)
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














