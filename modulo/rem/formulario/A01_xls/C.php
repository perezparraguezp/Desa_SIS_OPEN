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
    "(registro_rem.sexo='M' or registro_rem.sexo='F')",
    "registro_rem.sexo='M'",
    "registro_rem.sexo='F'",
    "registro_rem.edad like '0 A 4%' and sexo='M'",
    "registro_rem.edad like '0 A 4%' and sexo='F'",
    "registro_rem.edad like '5 A 9%' and sexo='M'",
    "registro_rem.edad like '5 A 9%' and sexo='F'",
    "registro_rem.edad like '10 A 14%' and sexo='M'",
    "registro_rem.edad like '10 A 14%' and sexo='F'",
    "registro_rem.edad like '15 A 19%' and sexo='M'",
    "registro_rem.edad like '15 A 19%' and sexo='F'",
    "registro_rem.edad like '20 A 24%' and sexo='M'",
    "registro_rem.edad like '20 A 24%' and sexo='F'",
    "registro_rem.edad like '25 A 29%' and sexo='M'",
    "registro_rem.edad like '25 A 29%' and sexo='F'",
    "registro_rem.edad like '30 A 34%' and sexo='M'",
    "registro_rem.edad like '30 A 34%' and sexo='F'",
    "registro_rem.edad like '35 A 39%' and sexo='M'",
    "registro_rem.edad like '35 A 39%' and sexo='F'",
    "registro_rem.edad like '40 A 44%' and sexo='M'",
    "registro_rem.edad like '40 A 44%' and sexo='F'",
    "registro_rem.edad like '45 A 49%' and sexo='M'",
    "registro_rem.edad like '45 A 49%' and sexo='F'",
    "registro_rem.edad like '50 A 54%' and sexo='M'",
    "registro_rem.edad like '50 A 54%' and sexo='F'",
    "registro_rem.edad like '55 A 59%' and sexo='M'",
    "registro_rem.edad like '55 A 59%' and sexo='F'",
    "registro_rem.edad like '60 A 64%' and sexo='M'",
    "registro_rem.edad like '60 A 64%' and sexo='F'",
    "registro_rem.edad like '65 A 69%' and sexo='M'",
    "registro_rem.edad like '65 A 69%' and sexo='F'",
    "registro_rem.edad like '70 A 74%' and sexo='M'",
    "registro_rem.edad like '70 A 74%' and sexo='F'",
    "registro_rem.edad like '75 A 79%' and sexo='M'",
    "registro_rem.edad like '75 A 79%' and sexo='F'",
    "registro_rem.edad like '80 %' and sexo='M'",
    "registro_rem.edad like '80 %' and sexo='F'",
    "registro_rem.valor like '%beneficiario%:%SI%'"

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
    'DE SALUD CARDIOVASCULAR',
    'DE TUBERCULOSIS',
    'SEGUIMIENTO AUTOVALENTE CON RIESGO',
    'SEGUIMIENTO RIESGO DEPENDENCIA',
    'DE INFECCIÓN TRANSMISIÓN SEXUAL',
    'OTROS PROBLEMAS DE SALUD',
    'NIÑOS CON NECESIDADES ESPECIALES',
];
$PROFESIONES[0] = ['MEDICO','ENFERMERO','NUTRICIONISTA','TENS'];
$PROFESIONES[1] = ['MEDICO','ENFERMERO'];
$PROFESIONES[2] = ['MEDICO','ENFERMERO'];
$PROFESIONES[3] = ['MEDICO','ENFERMERO'];
$PROFESIONES[4] = ['MEDICO','ENFERMERO','MATRONA'];
$PROFESIONES[5] = ['MEDICO','ENFERMERO','MATRONA','NUTRICIONISTA','TENS'];
$PROFESIONES[6] = ['MEDICO','ENFERMERO','MATRONA','NUTRICIONISTA','TENS'];

$FILA_HEAD_SQL = [
    "valor like '%tipo_control%:%CARDIOVAS%'",
    "valor like '%tipo_control%:%TUBER%'",
    "valor like '%tipo_control%:%AUTOVALENTE%'",
    "valor like '%tipo_control%:%RIESGO DEPENDENCIA%'",
    "valor like '%tipo_control%:%SEXUAL%'",
    "valor like '%tipo_control%:%OTROS PROBLEMA%'",
    "valor like '%tipo_control%:%NECESIDADES ESPECIALES%'",
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
            <header>SECCIÓN C: CONTROLES DE SALUD SEGÚN PROBLEMA DE SALUD [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO DE CONTROL
            </td>
            <td rowspan="3">
                PROFESIONAL
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="34">
                POR EDAD
            </td>
            <td  rowspan="3">
                BENEFICIARIO
            </td>
        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="2">'.$item.'</td>';
            }
            ?>
        </tr>
        <tr>
            <td>AMBOS</td>
            <td>HOMBRE</td>
            <td>MUJER</td>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td>HOMBRE</td>';
                echo '<td>MUJER</td>';
            }
            ?>
        </tr>
        <?php
        foreach ($FILA_HEAD as $i => $FILA) {
            $filtro_fila = $FILA_HEAD_SQL[$i];
            $total_fila = 0;

            echo '<tr>';
            echo '<td rowspan="'.count($PROFESIONES[$i]).'">' . $FILA . '</td>';
            foreach ($PROFESIONES[$i] AS $indice => $profesion){
                echo '<td>'.$profesion.'</td>';
                $fila = '';
                foreach ($rango_seccion as $c => $filtro_columna) {
                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' and fecha_registro<='$fecha_termino'
                        $filtro_lugar
                        and $filtro_fila 
                        and profesion='$profesion'
                        and $filtro_columna ";
                    $row = mysql_fetch_array(mysql_query($sql));
                    if ($row) {
                        $total = $row['total'];
                    } else {
                        $total = 0;
                    }
                    $fila .= '<td>' . $total . '</td>';
                    if ($c < 17) {
                        $total_fila += $total;
                    }
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
