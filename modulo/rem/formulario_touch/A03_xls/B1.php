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
$filtro_lugar .= 'and tipo_form=\''.$form.'\' and valor like \'%"seccion":"B"%\' ';


//rango de meses en dias
$rango_seccion = [
    "registro_rem.edad like '%'",

];
$rango_seccion_text = [
    '< 1 MES', //menor 1 MES
    '1 MES', //menor 1 MES
    '2 MESES', //menor 1 MES
    '3 MESES', //menor 1 MES
    '4 MESES', //menor 1 MES
    '5 MESES', //menor 1 MES
    '6 MESES', //menor 1 MES
    '7 A 11 MESES', //menor 1 MES
    '12 A 17 MESES', //menor 1 MES
    '18 A 24 MESES', //menor 1 MES
];

$FILA_HEAD = [
    'TOTAL',
    'OBESA',
    'SOBREPESO',
    'NORMAL',
    'BAJO PESO',
];
$FILA_HEAD_SQL = [
    "valor like '%imc%:%'",
    "valor like '%imc%:%OBES%'",
    "valor like '%imc%:%SOBRE%'",
    "valor like '%imc%:%NORMAL%'",
    "valor like '%imc%:%BAJO%'",
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
<section id="seccion_A03B1" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCION B: EVALUACIÓN, APLICACIÓN Y RESULTADOS DE ESCALAS EN  LA MUJER
                <BR />SECCIÓN B.1: EVALUACIÓN DEL ESTADO NUTRICIONAL A MUJERES CONTROLADAS AL OCTAVO MES POST PARTO [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_B1" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td  style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ESTADO NUTRICIONAL
            </td>
            <td>
                TOTAL
            </td>
        </tr>

        <?php
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila =$FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';
            $total_hombre = 0;
            $total_mujer = 0;
            foreach ($rango_seccion as $c => $filtro_columna){
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
                $total_hombre+=$total;

            }

            echo '<tr>';
            echo '<td>'.$FILA.'</td>';
            echo $fila;
            echo '</tr>';

        }
        ?>
    </table>
</section>
