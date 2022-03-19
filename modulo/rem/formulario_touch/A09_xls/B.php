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

    "registro_rem.edad like 'MENO 1 AÑO'",
    "registro_rem.edad like '1'",
    "registro_rem.edad like '2'",
    "registro_rem.edad like '3'",
    "registro_rem.edad like '4'",
    "registro_rem.edad like '5'",
    "registro_rem.edad like '6'",
    "registro_rem.edad like '7'",
    "registro_rem.edad like '8-9 '",
    "registro_rem.edad like '10-14'",
    "registro_rem.edad like '15 A 19'",
    "registro_rem.edad like '20 A 24'",
    "registro_rem.edad like '25 A 34'",
    "registro_rem.edad like '35 A 44'",
    "registro_rem.edad like '45 A 59'",
    "registro_rem.edad like '60 A 64 %'",
    "registro_rem.edad like '65 A 74 %'",
    "registro_rem.edad like '75 Y MAS %'",
    'valor like \'%"EMBARAZADAS":"SI"%\'',
    'valor like \'%"BENEFICIARIO":"SI"%\'',
    'valor like \'%"COMPRA":"SI"%\'',
    'valor like \'%"DISCAPACIDAD":"SI"%\'',
    'valor like \'%"SENAME":"SI"%\'',
    'valor like \'%"MIGRANTE":"SI"%\'',



];
$rango_seccion_text = [


    'MENOS DE 1 AÑO',//
    '1 AÑO ',//
    '2 AÑOS',//
    '3 AÑOS',//
    '4 AÑOS',//
    '5 AÑOS',//
    '6 AÑOS',//
    '7 AÑOS',//
    '8 A 9',//
    '10 A 14',//
    '15 A 19',//
    '20 A 24',//
    '25 A 35',//
    '35 A 44',//
    '45 A 59',//
    '60 A 64',//
    '65 A 74',//
    '75 Y MÁS',//
];


$FILA_HEAD = [
    'EDUCACIÓN INDIVIDUAL CON INSTRUCCIÓN DE TÉCNICA DE CEPILLADO',
    'CONSEJERÍA BREVE EN TABACO',
    'EXAMEN DE SALUD ORAL',
    'APLICACIÓN DE SELLANTES',
    'FLUORURACIÓN TÓPICA BARNIZ',
    'ACTIVIDAD INTERCEPTIVA DE ANOMALÍAS DENTO MAXILARES (OPI) (ACTIVIDAD OPI)',
    'ADESTARTRAJE SUPRAGINGIVAL Y PULIDO CORONARIO',
    'EXODONCIA',
    'PROCEDIMIENTO PULPAR',
    'ACCESO CAVITARIO',
    'RESTAURACIÓN ESTÉTICA',
    'RESTAURACIÓN DE AMALGAMAS',
    'OBTURACIÓN DE VIDRIO IONÓMERO ',
    'DESTARTRAJE SUBGINGIVAL Y PULIDO RADICULAR POR SEXTANTE',
    'TRATAMIENTO RESTAURADOR ATRAUMÁTICO (ART)',
    'PROCEDIMIENTOS MÉDICO-QUIRÚRGICOS',
    'RADIOGRAFÍA INTRAORAL (RETROALVEOLARES, BITE WING Y OCLUSALES)',
    'TOTAL ACTIVIDADES',


];
$FILA_HEAD_SQL = [

    'valor like \'%"tipo_atencion":"EDUCACIÓN INDIVIDUAL CON INSTRUCCIÓN DE TÉCNICA DE CEPILLADO"%\'',
    'valor like \'%"tipo_atencion":"CONSEJERÍA BREVE EN TABACO"%\'',
    'valor like \'%"tipo_atencion":"EXAMEN DE SALUD ORAL"%\'',
    'valor like \'%"tipo_atencion":"APLICACIÓN DE SELLANTES"%\'',
    'valor like \'%"tipo_atencion":"FLUORURACIÓN TÓPICA BARNIZ"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD INTERCEPTIVA DE ANOMALÍAS DENTO MAXILARES (OPI) (ACTIVIDAD OPI)"%\'',
    'valor like \'%"tipo_atencion":"ADESTARTRAJE SUPRAGINGIVAL Y PULIDO CORONARIO"%\'',
    'valor like \'%"tipo_atencion":"EXODONCIA"%\'',
    'valor like \'%"tipo_atencion":"PROCEDIMIENTO PULPAR"%\'',
    'valor like \'%"tipo_atencion":"ACCESO CAVITARIO"%\'',
    'valor like \'%"tipo_atencion":"RESTAURACIÓN ESTÉTICA"%\'',
    'valor like \'%"tipo_atencion":"RESTAURACIÓN DE AMALGAMAS"%\'',
    'valor like \'%"tipo_atencion":"OBTURACIÓN DE VIDRIO IONÓMERO "%\'',
    'valor like \'%"tipo_atencion":"DESTARTRAJE SUBGINGIVAL Y PULIDO RADICULAR POR SEXTANTE"%\'',
    'valor like \'%"tipo_atencion":"TRATAMIENTO RESTAURADOR ATRAUMÁTICO (ART)"%\'',
    'valor like \'%"tipo_atencion":"PROCEDIMIENTOS MÉDICO-QUIRÚRGICOS"%\'',
    'valor like \'%"tipo_atencion":"RADIOGRAFÍA INTRAORAL (RETROALVEOLARES, BITE WING Y OCLUSALES)"%\'',
    'valor like \'%"tipo_atencion":"TOTAL ACTIVIDADES"%\'',


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
            <header>SECCIÓN A: CONSULTAS Y CONTROLES ODONTOLÓGICOS REALIZADOS EN APS.  [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                TIPO DE ACTIVIDAD
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="36">
                POR DE EDAD (en años)
            </td>
            <td ROWSPAN="3">
                12 años (incluido en el grupo de 10-14 años)
            </td>
            <td ROWSPAN="3">
                Embarazadas
            </td>
            <td ROWSPAN="3">
                Beneficiarios
            </td>
            <td ROWSPAN="3">
                60 años (incluido en grupos de 60-64 años)
            </td>
            <td ROWSPAN="3">
                Compra de Servicio
            </td>
            <td ROWSPAN="3">
                Usuarios con Discapacidad
            </td>
            <td ROWSPAN="3">
                Niños, niñas, adolescentes y jóvenes población SENAME
            </td>
            <td ROWSPAN="3">
                Migrantes
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
            $total_hombre = 0;
            $total_mujer = 0;
            foreach ($rango_seccion as $c => $filtro_columna){
                if($c<20){
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
            echo '<td>'.($total_mujer+$total_hombre).'</td>';
            echo '<td>'.$total_hombre.'</td>';
            echo '<td>'.$total_mujer.'</td>';

            echo $fila;
            echo '</tr>';

        }
        ?>
    </table>
</section>







