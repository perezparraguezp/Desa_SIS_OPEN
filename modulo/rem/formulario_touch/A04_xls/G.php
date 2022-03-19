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
    "PUEBLOS ORIGINARIOS",
    "PUEBLOS NO ORIGINARIOS",


];
$rango_seccion_text = [
    'PUEBLOS ORIGINARIOS',
    'PUEBLOS NO ORIGINARIOS',

];

$FILA_HEAD = [
    'ATENCIONES POR AGENTE MEDICINA INDÍGENA',
];
$FILA_HEAD_SQL = [
    "valor like '%ATENCIONES POR AGENTE MEDICINA INDÍGENA%:%##%'",
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
            <header>SECCIÓN G: ATENCIONES DE MEDICINA INDÍGENA ASOCIADA AL PROGRAMA ESPECIAL DE SALUD Y PUEBLOS ORIGINARIOS [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_B1" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td  style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                COMPONENTE
            </td>
            <td colspan="1" rowspan="1">
                TOTAL
            </td>
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
            $total_hombre = 0;
            $total_mujer = 0;
            foreach ($rango_seccion as $c => $filtro_columna){
                $filtro_fila1 = str_replace("##",$filtro_columna,$filtro_fila);
                $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                        $filtro_lugar
                        and $filtro_fila1 ";

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

