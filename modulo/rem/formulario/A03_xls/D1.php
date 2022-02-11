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
$filtro_lugar .= 'and tipo_form=\''.$form.'\' and valor like \'%"seccion":"D"%\' ';


//rango de meses en dias
$rango_seccion = [
    "registro_rem.edad like '%10 A 14%'",
    "registro_rem.edad like '%15 A 19%'",
    "registro_rem.edad like '%20 A 24%'",
    "registro_rem.edad like '%25 A 44%'",
    "registro_rem.edad like '%45 A 64%'",
    "registro_rem.edad like '%65 A 69%'",
    "registro_rem.edad like '%70 A 79%'",
    "registro_rem.edad like '%80%'",

];
$rango_seccion_text = [
    '10 A 14', //menor 1 MES
    '15 A1 19', //menor 1 MES
    '20 A1 24', //menor 1 MES
    '25 A1 44', //menor 1 MES
    '45 A1 64', //menor 1 MES
    '65 A1 69', //menor 1 MES
    '70 A1 79', //menor 1 MES
    '80 y MAS', //menor 1 MES
];

$FILA_HEAD = [
    'Nº DE AUDIT (EMP/EMPAM)',
    'Nº DE AUDIT APLICADO',
    'Nº DE ASSIST (EMP/EMPAM)',
    'N° DE ASSIST APLICADO',
    'N° DE CRAFFT EN CONTROL DE SALUD INTEGRAL DEL ADOLESCENTE',
    'N° DE CRAFFT APLICADO',
];
$FILA_HEAD_SQL = [
    'valor like \'%"componente":%AUDIT (EMP/EMPAM)%\'',
    'valor like \'%"componente":%AUDIT APLICADO%\'',
    'valor like \'%"componente":%ASSIST (EMP/EMPAM)%\'',
    'valor like \'%"componente":%ASSIST APLICADO%\'',
    'valor like \'%"componente":%CRAFFT EN CONTROL DE SALUD INTEGRAL%\'',
    'valor like \'%"componente":%CRAFFT APLICADO%\'',
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
<section id="seccion_A03C" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN D: OTRAS EVALUACIONES, APLICACIONES Y RESULTADOS DE ESCALAS EN TODAS LAS EDADES
                <BR />SECCIÓN D.1: APLICACIÓN DE TAMIZAJE PARA EVALUAR EL NIVEL DE RIESGO DE CONSUMO DE  ALCOHOL, TABACO Y OTRAS DROGAS	[<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_C" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" colspan="2"  style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                COMPONENTE
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="16">POR EDAD</td>
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
            echo '<td colspan="2">'.$FILA.'</td>';
            echo '<td>'.($total_mujer+$total_hombre).'</td>';
            echo '<td>'.$total_hombre.'</td>';
            echo '<td>'.$total_mujer.'</td>';
            echo $fila;
            echo '</tr>';

        }

        echo '<tr><td rowspan="3">RESULTADOS DE EVALUACIÓN</td>';
        $FILA_HEAD = [
            'BAJO RIESGO',
            'CONSUMO RIESGOSO / INTERMEDIO',
            'POSIBLE CONSUMO PERJUDICIAL O DEPENDENCIA',
        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"resultado_componente":"BAJO RIESGO"%\'',
            'valor like \'%"resultado_componente":"CONSUMO RIESGOSO / INTERMEDIO"%\'',
            'valor like \'%"resultado_componente":"POSIBLE CONSUMO PERJUDICIAL O DEPENDENCIA"%\'',
        ];
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

            echo '<td>'.$FILA.'</td>';
            echo '<td>'.($total_mujer+$total_hombre).'</td>';
            echo '<td>'.$total_hombre.'</td>';
            echo '<td>'.$total_mujer.'</td>';
            echo $fila;
            echo '</tr><tr>';

        }
        echo '</tr>';
        ?>
    </table>
</section>
