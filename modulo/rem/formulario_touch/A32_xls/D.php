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
    "registro_rem.edad like '%MENOR 1 AÑO%'",
    "registro_rem.edad like '%1%'",
    "registro_rem.edad like '%2%'",
    "registro_rem.edad like '%3%'",
    "registro_rem.edad like '%4%'",
    "registro_rem.edad like '%5%'",
    "registro_rem.edad like '%6%'",
    "registro_rem.edad like '%12%'",
    "registro_rem.edad like '%<15%'",
    "registro_rem.edad like '%15 A 19%'",
    "registro_rem.edad like '%20 A 64%'",
    "registro_rem.edad like '%65 Y MAS%'",
];
$rango_seccion_text = [
    'MENOR DE 1 AÑO',
    '1',
    '2',
    '3',
    '4',
    '5',
    '6',
    '12',
    'RESTO <15 AÑOS',
    '15 A 19',
    '20 A 64',
    '65 Y MAS',


];

$FILA_HEAD = [
    'Contactabilidad de Pacientes',
    'Seguimiento Clínico Remoto de Pacientes',
    'Educación, Promoción Remota en Salud Bucal',
    'Atención Domiciliaria Odontológica',
    'Visita Domiciliaria Integral',
    'Pauta CERO Remota',
    'TOTAL',


];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"Contactabilidad de Pacientes"%\'',
    'valor like \'%"tipo_atencion":"Seguimiento Clínico Remoto de Pacientes"%\'',
    'valor like \'%"tipo_atencion":"Educación, Promoción Remota en Salud Bucal"%\'',
    'valor like \'%"tipo_atencion":"Atención Domiciliaria Odontológica"%\'',
    'valor like \'%"tipo_atencion":"Visita Domiciliaria Integral"%\'',
    'valor like \'%"tipo_atencion":"Pauta CERO Remota"%\'',
    'valor like \'%"tipo_atencion":"TOTAL"%\'',
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
            <header>SECCIÓN D: ATENCIÓN ODONTOLÓGICA
                <BR />SECCIÓN D1: ATENCIÓN ODONTOLÓGICA NIVEL PRIMARIO [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ACTIVIDADES
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="12" rowspan="1">
                SEGÚN GRUPOS DE EDAD O DE RIESGO
            </td>
            <td rowspan="3">
                EMBARAZADAS
            </td>
            <td rowspan="3"  >
                60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)
            </td>
            <td rowspan="3"  >
                USUARIOS EN SITUACIÓN DE DISCAPACIDAD
            </td>
            <td rowspan="3"  >
                NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME
            </td>
            <td rowspan="3"  >
                MIGRANTES
            </td>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td ROWSPAN="2">'.$item.'</td>';
            }
            ?>
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
            $total_hombre = 0;
            $total_mujer = 0;
            foreach ($rango_seccion as $c => $filtro_columna){
                if($c<8){
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
















