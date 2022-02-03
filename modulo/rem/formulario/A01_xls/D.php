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
$seccion  = 'B';//$_POST['seccion'];
if($lugar!='TODOS'){
    $filtro_lugar = "and lugar='$lugar' ";
}else{
    $filtro_lugar = '';
}
$filtro_lugar .= "and tipo_form='$form' and seccion_form='$seccion' ";


//rango de meses en dias
$rango_seccion = [
    "(registro_rem.sexo='M' or registro_rem.sexo='F') and (edad like '%MES%' OR edad like '%6 a 9%' OR edad like '%10 a 14%')",
    "registro_rem.sexo='M' and (edad like '%MES%' OR edad like '%6 a 9%' OR edad like '%10 a 14%')",
    "registro_rem.sexo='F' and (edad like '%MES%' OR edad like '%6 a 9%' OR edad like '%10 a 14%')",
    "(registro_rem.sexo='M' or registro_rem.sexo='F') and (edad like '%15 a 19%' OR edad like '%20 a 24%' OR edad like '%25 a 29%' OR edad like '%30 a 34%' OR edad like '%35 a 39%' OR edad like '%40 a 44%' OR edad like '%45 a 49%' OR edad like '%50 a 54%' OR edad like '%55 a 59%' OR edad like '%60 a 64%' OR edad like '%65 a 69%' OR edad like '%70 a 74%' OR edad like '%75 a 79%' OR edad like '%80%')",
    "registro_rem.sexo='M' and (edad like '%15 a 19%' OR edad like '%20 a 24%' OR edad like '%25 a 29%' OR edad like '%30 a 34%' OR edad like '%35 a 39%' OR edad like '%40 a 44%' OR edad like '%45 a 49%' OR edad like '%50 a 54%' OR edad like '%55 a 59%' OR edad like '%60 a 64%' OR edad like '%65 a 69%' OR edad like '%70 a 74%' OR edad like '%75 a 79%' OR edad like '%80%')",
    "registro_rem.sexo='F' and (edad like '%15 a 19%' OR edad like '%20 a 24%' OR edad like '%25 a 29%' OR edad like '%30 a 34%' OR edad like '%35 a 39%' OR edad like '%40 a 44%' OR edad like '%45 a 49%' OR edad like '%50 a 54%' OR edad like '%55 a 59%' OR edad like '%60 a 64%' OR edad like '%65 a 69%' OR edad like '%70 a 74%' OR edad like '%75 a 79%' OR edad like '%80%')",

];
$rango_seccion_text = [
    '0 A 4',//
    '5 A 9',//
    '10 A 14',//
    '15 A 19',//
    '20 A 24',//
    '25 A 29',//
    '30 A 34',//
    '35 A 39',//
    '40 A 44',//
    '45 A 49',//
    '50 A 54',//
    '55 A 59',//
    '60 A 64',//
    '65 A 69',//
    '70 A 74',//
    '75 A 79',//
    '80 Y MÁS',//
];

$FILA_HEAD = [
    'EN ESPACIO AMIGABLE',
    'EN OTROS ESPACIOS DEL ESTABLECIMIENTO DE SALUD	',
    'EN ESTABLECIMIENTOS EDUCACIONALES	',
    'EN OTROS LUGARES FUERA DEL ESTABLECIMIENTO DE SALUD	',
    'TOTALES',
];
$PROFESIONES[0] = ['MEDICO','ENFERMERO','NUTRICIONISTA','TENS'];
$PROFESIONES[1] = ['MEDICO','ENFERMERO'];
$PROFESIONES[2] = ['MEDICO','ENFERMERO'];
$PROFESIONES[3] = ['MEDICO','ENFERMERO'];
$PROFESIONES[4] = ['MEDICO','ENFERMERO','MATRONA'];
$PROFESIONES[5] = ['MEDICO','ENFERMERO','MATRONA','NUTRICIONISTA','TENS'];
$PROFESIONES[6] = ['MEDICO','ENFERMERO','MATRONA','NUTRICIONISTA','TENS'];

$FILA_HEAD_SQL = [
    "valor like '%tipo_lugar%:%AMIGABLE%'",
    "valor like '%tipo_lugar%:%OTROS ESPACIOS DEL ESTABLECIMIENTO %'",
    "valor like '%tipo_lugar%:%EDUCACIONALES%'",
    "valor like '%tipo_lugar%:%FUERA DEL ESTABLECIMIENTO%'",
    "valor like '%tipo_lugar%:%'",
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
<section id="seccion_A01C" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN D: CONTROL DE SALUD INTEGRAL DE ADOLESCENTES (incluidos en sección B) [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                LUGAR DEL CONTROL, SEGÚN EDAD
            </td>
            <td colspan="3">
                10 A 14 AÑOS
            </td>
            <td colspan="3">
                15 A 19 AÑOS
            </td>
        </tr>
        <tr>
            <td>AMBOS</td>
            <td>HOMBRE</td>
            <td>MUJER</td>
            <td>AMBOS</td>
            <td>HOMBRE</td>
            <td>MUJER</td>
        </tr>
        <?php
        foreach ($FILA_HEAD as $i => $FILA) {
            $filtro_fila = $FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';

            foreach ($rango_seccion as $c => $filtro_columna) {
                $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' and fecha_registro<='$fecha_termino'
                        $filtro_lugar
                        and $filtro_fila 
                        and $filtro_columna ";
                $row = mysql_fetch_array(mysql_query($sql));
                if ($row) {
                    $total = $row['total'];
                } else {
                    $total = 0;
                }
                $fila .= '<td>' . $total . '</td>';
            }
            echo '<tr>';
            echo '<td>'.$FILA.'</td>';
            echo $fila;
            echo '</tr>';




        }

        ?>
    </table>
</section>
