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

];


$FILA_HEAD = [
    'Recién nacidos vivos hijos de mujer VIH (+) confirmada por ISP que recibieron leche maternizada al alta (para ser consumida en su casa)',
    'Recién nacidos vivos hijos de mujer VIH (+) confirmada por ISP',
    'RRecien nacidos vivos hijos de mujer con serología VIH (+) no confirmada por el ISP  que recibieron leche maternizada al alta (para ser consumida en su casa)',
    'Recien nacidos vivos hijos de mujer con serología VIH (+) no confirmada por el ISP',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"Recién nacidos vivos hijos de mujer VIH (+) confirmada por ISP que recibieron leche maternizada al alta (para ser consumida en su casa)"%\'',
    'valor like \'%"tipo_atencion":"Recién nacidos vivos hijos de mujer VIH (+) confirmada por ISP"%\'',
    'valor like \'%"tipo_atencion":"Recien nacidos vivos hijos de mujer con serología VIH (+) no confirmada por el ISP  que recibieron leche maternizada al alta (para ser consumida en su casa)"%\'',
    'valor like \'%"tipo_atencion":"Recien nacidos vivos hijos de mujer con serología VIH (+) no confirmada por el ISP"%\'',



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
            <header>SECCIÓN F: RECIEN NACIDOS EXPUESTOS AL VIH QUE RECIBE PROTOCOLO DE TRANSMISION VERTICAL[<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO DE ACTIVIDAD
            </td>
            <td  rowspan="2">
                TOTAL
            </td>

            <td ROWSPAN="2">
                Pueblos Originarios
            </td>
            <td ROWSPAN="2">
                Migrantes
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
                if($c<0){
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












