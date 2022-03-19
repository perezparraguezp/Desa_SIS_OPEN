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

    "registro_rem.edad like '%1 MES%'",
    "registro_rem.edad like '%2 MESES%'",
    "registro_rem.edad like '%3 MESES%'",
    "registro_rem.edad like '%4 MESES%'",
    "registro_rem.edad like '%5 MESES%'",
    "registro_rem.edad like '%6 MESES%'",
    "registro_rem.edad like '%7 A 11 MESES%'",
    "registro_rem.edad like '%12 A 17 MESES%'",
    "registro_rem.edad like '%18 A 23 MESES%'",
    "registro_rem.edad like '%24 A 35 MESES%'",
    "registro_rem.edad like '%36 A 41 MESES%'",
    "registro_rem.edad like '%42 A 47 MESES%'",
    "registro_rem.edad like '%48 A 59 MESES%'",
    "registro_rem.edad like '%60 A 71 MESES%'",
    "registro_rem.edad like '%6 A 9 AÑOS 11 MESES%'",

];
$rango_seccion_text = [

    'LLAMADAS TELEFÓNICAS',
    'VIDEO LLAMADAS',
    '1 MES',
    '2 MESES',
    '3 MESES',
    '4 MESES',
    '5 MESES',
    '6 MESES',
    '7 A 11 MESES',
    '12 A 17 MESES',
    '18 A 23 MESES',
    '24 A 35 MESES',
    '36 A 41 MESES',
    '42 A 47 MESES',
    '48 A 59 MESES',
    '60 A 71 MESES',
    '6 A 9 AÑOS 11 MESES',


];

$FILA_HEAD = [
    'Enfermera/o',
    'Médico/a',
    'Nutricionista',
    'Otro/a',

];
$FILA_HEAD_SQL = [
    'profesion like \'%MATRONA%\'',
    'profesion like \'%Médico/a%\'',
    'profesion like \'%Nutricionista%\'',
    'profesion like \'%Otro/a%\'',

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
            <header>SECCIÓN M: SEGUIMIENTO DE SALUD INFANTIL EN CONTEXTO DE EMERGENCIA SANITARIA   [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                PROFESIONALES
            </td>
            <td  rowspan="2">
                TOTAL ACCIONES
            </td>
            <td colspan="2" rowspan="1">
                ACCIONES
            </td>
            <td  rowspan="2">
                TOTAL USUARIOS
            </td>
            <td colspan="15" rowspan="1">
                NÚMERO DE ACCIONES TELEFÓNICAS Y DE SEGUIMIENTO POR RANGOS DE EDAD
            </td>
            <TD rowspan="1">
                Acompañamiento del Padre
            </TD>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td ROWSPAN="1">'.$item.'</td>';
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
                if($c<3){
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


















