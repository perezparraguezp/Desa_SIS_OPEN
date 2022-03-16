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
    "registro_rem.edad like 'DEL 1 MES'",
    "registro_rem.edad like 'DEL 3 MES'",
    "registro_rem.edad like 'DEL 6 MES'",
    "registro_rem.edad like 'DEL 12 MES'",
    "registro_rem.edad like 'DEL 24 MES'",

];
$rango_seccion_text = [
    'DEL 1º MES', //menor 1 MES
    'DEL 3º MES', //menor 1 MES
    'DEL 6º MES', //menor 1 MES
    'DEL 12º MES', //menor 1 MES
    'DEL 24º MES', //menor 1 MES
];

$FILA_HEAD = [
    'LACTANCIA MATERNA EXCLUSIVA',
    'LACTANCIA MATERNA / FORMULA LACTEA',
    'FORMULA LACTEA',
    'LACTANCIA MATERNA MAS SOLIDOS',
    'LACTANCIA MATERNA/FORMULA LACTEA MAS SOLIDOS',
    'FORMULA LACTEA MAS SOLIDOS',
];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_alimentacion":"LME"%\'',
    'valor like \'%"tipo_alimentacion":"LME/FL"%\'',
    'valor like \'%"tipo_alimentacion":"FL"%\'',
    'valor like \'%"tipo_alimentacion":"LM + SOLIDOSL"%\'',
    'valor like \'%"tipo_alimentacion":"LM/FL + SOLIDOSL"%\'',
    'valor like \'%"tipo_alimentacion":"FL + SOLIDOSL"%\'',
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
            <header>SECCIÓN A: APLICACIÓN DE INSTRUMENTO Y RESULTADO EN EL NIÑO (A)
                <BR />SECCIÓN A.5:  LACTANCIA MATERNA EN MENORES CONTROLADOS [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO DE ALIMENTACIÓN
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="10">
                SEGÚN CONTROL PROGRAMÁTICO
            </td>
            <td rowspan="3">Pueblos Originarios</td>
            <td rowspan="3">Migrantes</td>
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
            $total_hombre = 0;
            $total_mujer = 0;
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

            }

            echo '<tr>';
            echo '<td>'.$FILA.'</td>';

            echo '<td>'.($total_mujer+$total_hombre).'</td>';
            echo '<td>'.$total_hombre.'</td>';
            echo '<td>'.$total_mujer.'</td>';

            $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and pueblo='SI'
                        $filtro_lugar
                        and $filtro_fila";
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
                          and migrante='SI'
                        $filtro_lugar
                        and $filtro_fila  ";
            $row = mysql_fetch_array(mysql_query($sql));
            if($row){
                $total = $row['total'];
            }else{
                $total = 0;
            }
            $fila .= '<td>'.$total.'</td>';

            echo $fila;
            echo '</tr>';

        }
        ?>
    </table>
</section>
