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
    "( registro_rem.sexo='M' or registro_rem.sexo='F')",
    "registro_rem.sexo='M'",
    "registro_rem.sexo='F'",

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
    'TOTAL',
    'MEDICO',
    'ENFERMERA',
    'MATRONA',
    'NUTRICIONISTA',
    'OTRO PROFESIONAL',
    'TECNICO PARAMEDICO',
];
$FILA_HEAD_SQL = [
    "profesion!='ADMINISTRADOR'",
    "profesion='MEDICO'",
    "profesion='ENFERMERO'",
    "profesion='MATRONA'",
    "profesion='NUTRICIONISTA'",
    "(profesion!='NUTRICIONISTA' or profesion!='MATRONA' or profesion!='ENFERMERO' or profesion!='MEDICO' or profesion!='ADMINISTRADOR') ",
    "profesion='TENS' ",
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

<section id="seccion_A02A" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN A: EMP REALIZADO POR PROFESIONAL [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                PROFESIONAL
            </td>
            <td colspan="3">
                TOTAL
            </td>
        </tr>
        <tr>
            <td>AMBOS</td>
            <td>HOMBRE</td>
            <td>MUJER</td>
        </tr>
        <?php
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila =$FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';
            echo '<tr>';
            echo '<td>'.$FILA.'</td>';
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
            }

            echo $fila;
            echo '</tr>';


        }
        ?>
    </table>
</section>
