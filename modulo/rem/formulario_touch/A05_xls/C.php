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
    "registro_rem.edad like 'MENOR 15'",
    "registro_rem.edad like '15 A 19'",
    "registro_rem.edad like '20 A 24'",
    "registro_rem.edad like '25 A 29'",
    "registro_rem.edad like '30 A 34'",
    "registro_rem.edad like '35 A 39'",
    "registro_rem.edad like '40 A 44'",
    "registro_rem.edad like '45 A 49'",
    "registro_rem.edad like '50 y 54'",
    "registro_rem.edad like '55 y 59'",
    "registro_rem.edad like '60 y 64'",
    "registro_rem.edad like '65 y 69'",
    "registro_rem.edad like '70 y MAS'",
    'valor like \'%"Espacios Amigables":"SI"%\'',
    'valor like \'%"Ingreso por cambio de Método Anticonceptivo":"SI"%\'',



];
$rango_seccion_text = [
    'MENOR 15',//
    '15 A 19',//
    '20 A 24',//
    '25 A 29',//
    '30 A 34',//
    '35 A 39',//
    '40 A 44',//
    '45 A 49',//
    '50 Y 54',//
    '55 Y 59',//
    '60 A 64',//
    '65 A 69',//
    '70 Y MAS',//

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
            <header>SECCIÓN C: INGRESOS A PROGRAMA DE REGULACIÓN DE FERTILIDAD Y SALUD SEXUAL.[<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_C" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="2" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                MÉTODOS
            </td>
            <td  rowspan="2">
                TOTAL
            </td>
            <td colspan="13" >
                POR DE EDAD (en años)
            </td>
            <td rowspan="2">
                Espacios Amigables
            </td>
            <td rowspan="2">
                Ingreso por cambio de Método Anticonceptivo
            </td>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td rowspan="1">'.$item.'</td>';
            }
            ?>
        </tr>

        <?php

        echo '<tr><td COLSPAN="2" >TOTAL REGULACIÓN DE FERTILIDAD</td>';
        $FILA_HEAD = [
            '',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":"TOTAL REGULACIÓN DE FERTILIDAD"%\'',
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
        echo '<tr><td COLSPAN="2" >D.I.U. T con Cobre</td>';
        $FILA_HEAD = [
            '',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":"D.I.U T con Cobre"%\'',
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
        echo '<tr><td COLSPAN="2" >D.I.U con Levonorgestrel</td>';
        $FILA_HEAD = [
            '',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":"D.I.U con Levonorgestrel"%\'',
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
        echo '<tr><td ROWSPAN="6" >HORMONAL</td>';
        $FILA_HEAD = [
            'Oral Combinado',
            'Oral Progestágeno',
            'Inyectable Combinado',
            'Inyectable Progestágeno',
            'Implante Etonogestrel (3 años)',
            'Implante Levonorgestrel (5 años)',


        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":"Oral Combinado"%\'',
            'valor like \'%"tipo_hormona":"Oral Progestágeno"%\'',
            'valor like \'%"tipo_hormona":"Inyectable Combinado"%\'',
            'valor like \'%"tipo_hormona":"Inyectable Progestágeno"%\'',
            'valor like \'%"tipo_hormona":"Implante Etonogestrel (3 años)"%\'',
            'valor like \'%"tipo_hormona":"Implante Levonorgestrel (5 años)"%\'',

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
        echo '<tr><td ROWSPAN="2" >SÓLO PRESERVATIVO MAC</td>';
        $FILA_HEAD = [
            'HOMBRE',
            'MUJER',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"HOMBRE"%\'',
            'valor like \'%"MUJER"%\'',

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
        echo '<tr><td ROWSPAN="2" >ESTERILIZACIÓN QUIRÚRGICA</td>';
        $FILA_HEAD = [
            'HOMBRE',
            'MUJER',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"HOMBRE"%\'',
            'valor like \'%"MUJER"%\'',

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
        echo '<tr><td COLSPAN="2" > Metodo de Regulación de Fertilidad más Preservativos</td>';
        $FILA_HEAD = [
            '',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":" Metodo de Regulacion de Fertilidad mas Preservativos"%\'',
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
        echo '<tr><td COLSPAN="2" >Gestantes que reciben preservativo</td>';
        $FILA_HEAD = [
            '',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":"Gestantes que reciben preservativo"%\'',
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
        echo '<tr><td ROWSPAN="2" >PRESERVATIVO/PRACTICA SEXUAL SEGURA</td>';
        $FILA_HEAD = [
            'HOMBRE',
            'MUJER',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"HOMBRE"%\'',
            'valor like \'%"MUJER"%\'',

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
        echo '<tr><td ROWSPAN="2" >LUBRICANTES</td>';
        $FILA_HEAD = [
            'HOMBRE',
            'MUJER',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"HOMBRE"%\'',
            'valor like \'%"MUJER"%\'',

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
        echo '<tr><td COLSPAN="2" >CONDÓN FEMENINO</td>';
        $FILA_HEAD = [
            '',

        ];
        $FILA_HEAD_SQL = [
            'valor like \'%"tipo_hormona":"CONDÓN FEMENINO"%\'',
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
            echo $fila;
            echo '</tr><tr>';

        }

        echo '</tr>';
        ?>
    </table>
</section>



