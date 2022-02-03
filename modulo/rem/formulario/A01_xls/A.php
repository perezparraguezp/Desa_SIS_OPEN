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
    "registro_rem.edad like '%MENOR%'",
    "registro_rem.edad like '5 A 9'",
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
    "registro_rem.edad like '60 A 64'",
    "registro_rem.edad like '65 A 69'",
    "registro_rem.edad like '70 A 74'",
    "registro_rem.edad like '75 A 79'",
    "registro_rem.edad like '80 %'",
    "registro_rem.sexo='M'",
    "registro_rem.sexo='F'",
    "registro_rem.valor like '%beneficiario%:%SI%'",
    "registro_rem.valor like '%control_con%:%SI%'",
    "registro_rem.valor like '%control_con_padre%:%SI%'",
    "registro_rem.valor like '%lactancia%:%LME%'",
    "registro_rem.valor like '%lactancia%:%MIXTA%'",
    "registro_rem.valor like '%lactancia%:%FORMULA%'",

];
$rango_seccion_text = [
    '< 1 MES', //menor 1 MES
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
    'HOMBRES',//
    'MUJERES',//
    'LME',//
    'LME/FORMULA',//
    'FORMULA',//
];

$FILA_HEAD = [
    'PRE-CONCEPCIONAL',
    'PRE-NATAL',
    'POST PARTO',
    'POST ABORTO',
    'PÚERPERA CON RECIEN NACIDO HASTA 10 DIAS DE VIDA',
    'PÚERPERA CON RECIEN NACIDO ENTRE 11 Y 28 DIAS',
    'RECIEN NACIDO HASTA 10 DIAS DE VIDA',
    'RECIEN NACIDO ENTRE 11 Y 28 DIAS',
    'GINECOLÓGICO',
    'CLIMATERIO',
    'REGULACION FECUNDIDAD',
];
$FILA_HEAD_SQL = [
    "valor like '%tipo_control%:%CONCEPCIONAL%'",
    "valor like '%tipo_control%:%NATAL%'",
    "valor like '%tipo_control%:%POST PARTO%'",
    "valor like '%tipo_control%:%POST ABORTO%'",
    "valor like '%tipo_control%:%ERPERA CON RECIEN NACIDO HASTA 10%'",
    "valor like '%tipo_control%:%ERPERA CON RECIEN NACIDO ENTRE 11 Y %'",
    "valor like '%tipo_control%:%RECIEN NACIDO HASTA 10%'",
    "valor like '%tipo_control%:%RECIEN NACIDO ENTRE 11 Y %'",
    "valor like '%tipo_control%:%GINECO%'",
    "valor like '%tipo_control%:%CLIMA%'",
    "valor like '%tipo_control%:%REGULAC%'",
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

<section id="seccion_A01A" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN A: CONTROLES DE SALUD SEXUAL Y REPRODUCTIVA [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO DE CONTROL
            </td>
            <td rowspan="2">
                PROFESIONAL
            </td>
            <td rowspan="2">
                TOTAL
            </td>
            <td colspan="17">
                POR EDAD
            </td>
            <td colspan="2">
                SEXO
            </td>
            <td  rowspan="2">
                BENEFICIARIO
            </td>
            <td  rowspan="2">
                CONTROL CON PAREJA O FAMILIAR
            </td>
            <td  rowspan="2">
                CONTROL DE DIADA CON PRESENCIA DEL PADRE
            </td>
            <td colspan="3">
                TIPOS DE LACTANCIA
            </td>
        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td>'.$item.'</td>';
            }
            ?>
        </tr>
        <?php
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila =$FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';
            foreach ($rango_seccion as $c => $filtro_columna){
                $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' and fecha_registro<='$fecha_termino'
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
                if($c<17){
                    $total_fila+=$total;
                }
            }

            echo '<tr>';
            echo '<td rowspan="2">'.$FILA.'</td>';
            echo '<td>MEDICO</td>';
            echo '<td>'.$total_fila.'</td>';
            echo $fila;
            echo '</tr>';

            $total_fila = 0;
            $fila = '';
            foreach ($rango_seccion as $c => $filtro_columna){
                $sql = "select count(*) as total from registros  
                        where fecha_registro>='$fecha_inicio' and fecha_registro<='$fecha_termino'
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
                if($c<17){
                    $total_fila+=$total;
                }
            }
            echo '<tr>';
            echo '<td>MATRONA(ON)</td>';
            echo '<td>'.$total_fila.'</td>';
            echo $fila;
            echo '</tr>';
        }
        ?>
    </table>
</section>
