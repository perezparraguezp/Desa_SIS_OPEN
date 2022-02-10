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
$filtro_lugar .= "and tipo_form='$form' and valor like '%sub_seccion%:%$seccion%' ";


//rango de meses en dias
$rango_seccion = [
    "registro_rem.edad like '%MENOR%'",
    "registro_rem.edad like '1 MESES'",
    "registro_rem.edad like '2 MESES'",
    "registro_rem.edad like '3 MESES'",
    "registro_rem.edad like '4 MESES'",
    "registro_rem.edad like '5 MESES'",
    "registro_rem.edad like '6 MESES'",
    "registro_rem.edad like '7 A 11 MESES'",
    "registro_rem.edad like '12 A 17 MESES'",
    "registro_rem.edad like '18 A 24 MESES'",

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
    'APLICACION PAUTA BREVE',
    'RESULTADO NORMAL',
    'RESULTADO ALTERADO',
];
$FILA_HEAD_SQL = [
    "valor like '%pauta_breve%:%AL%'",
    "valor like '%pauta_breve%:%NORMAL%'",
    "valor like '%pauta_breve%:%ALTERAD%'",
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
<section id="seccion_A01A1" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN A: APLICACIÓN DE INSTRUMENTO Y RESULTADO EN EL NIÑO (A)
                <BR />SECCIÓN A.1: APLICACIÓN Y RESULTADOS DE PAUTA BREVE [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A1" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                EVALUACIONES POR EDAD DEL NIÑO
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="20">
                POR EDAD
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
        foreach ($FILA_HEAD as $i => $FILA){
            $filtro_fila =$FILA_HEAD_SQL[$i];
            $total_fila = 0;
            $fila = '';
            foreach ($rango_seccion as $c => $filtro_columna){
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

            }

            echo '<tr>';
            echo '<td>'.$FILA.'</td>';

            echo '<td>S</td>';
            echo '<td>S</td>';
            echo '<td>S</td>';

            echo $fila;
            echo '</tr>';

        }
        ?>
    </table>
</section>
