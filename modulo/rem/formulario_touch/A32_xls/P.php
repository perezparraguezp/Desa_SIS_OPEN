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

    'TELEFONICO',
    'VIDEO LLAMADA GRUPAL',
    'SEMINARIO RADIO',
    'PLATAFORMA DIGITAL',
    'TOTAL USUARIOS',
    'GESTANTES',
    'ACOMPAÑANTE DE GESTANTE',
    'MENOR DE 12 MESES',
    'NIÑOS DE 12 A 23 MESES',
    'NIÑOS DE 2 A 5 AÑOS',
    'NIÑOS DE 5 A 9 AÑOS',

];

$FILA_HEAD = [
    'HABILIDADES PARENTALES',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"HABILIDADES PARENTALES"%\'',

];

$PROFESIONES[0] = [
    'Nadie es Perfecto Remoto A',
    'Nadie es Perfecto Remoto B',
    'Nadie es Perfecto Seminario',
    'Nadie es perfecto PASMI',

];
$FILTRO_PROFESION[0] = [
    'valor like \'%"tipo_atencion":"HABILIDADES PARENTALES"%\' AND  valor like \'%"tipo_Actividad":"Nadie es Perfecto Remoto A"%\'',
    'valor like \'%"tipo_atencion":"HABILIDADES PARENTALES"%\' AND  valor like \'%"tipo_Actividad":"Nadie es Perfecto Remoto B"%\'',
    'valor like \'%"tipo_atencion":"HABILIDADES PARENTALES"%\' AND  valor like \'%"tipo_Actividad":"Nadie es Perfecto Seminario"%\'',
    'valor like \'%"tipo_atencion":"HABILIDADES PARENTALES"%\' AND  valor like \'%"tipo_Actividad":"Nadie es perfecto PASMI"%\'',

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
            <header>SECCIÓN P:  EDUCACIÓN GRUPAL REMOTA SEGÚN ÁREAS TEMÁTICAS Y EDAD [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" COLSPAN="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ÁREAS TEMÁTICAS DE PROMOCIÓN Y PREVENCIÓN
            </td>
            <td rowspan="2">
                Total Acciones
            </td>
            <td colspan="7" rowspan="1">
                TIPO DE ACCION PARA GENERAR ATENCIONES
            </td>
            <td colspan="4" ROWSPAN="1" >
                MADRE, PADRE O CUIDADOR DE:
            </td>


        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="1" rowspan="1">'.$item.'</td>';
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

                echo '<td>'.($total_mujer+$total_hombre).'</td>';
                echo '<td>'.$total_hombre.'</td>';
                echo '<td>'.$total_mujer.'</td>';
                echo $fila;

                echo '</tr>';
                echo '<tr>';
            }
            echo '</tr>';
        }
        ?>

    </table>
</section>







