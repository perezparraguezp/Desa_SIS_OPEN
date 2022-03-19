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
    'valor like \'%"DISCAPACIDAD":"SI"%\'',
    'valor like \'%"SENAME":"SI"%\'',
    'valor like \'%"MIGRANTE":"SI"%\'',
    'valor like \'%"CARDIOVASCULAR":"SI"%\'',



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
    'INGRESOS A TRATAMIENTO ODONTOLOGÍA GENERAL',
    'INGRESO CONTROL CON ENFOQUE RIESGO ODONTOLÓGICO (CERO)',
    'EGRESO CONTROL CON ENFOQUE RIESGO ODONTOLÓGICO (CERO)',
    'ALTAS ODONTOLÓGICAS PREVENTIVAS',
    'ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)',
    'ALTAS ODONTOLÓGICAS TOTALES',
    'EGRESOS POR ABANDONO',
    /* SUB*/
    'ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)',
    'TOTAL',
    /*SUB*/
    ' N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)',
    'TOTAL',
    /*SUB*/
    'CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"PINGRESOS A TRATAMIENTO ODONTOLOGÍA GENERAL"%\'',
    'valor like \'%"tipo_atencion":"INGRESO CONTROL CON ENFOQUE RIESGO ODONTOLÓGICO (CERO)"%\'',
    'valor like \'%"tipo_atencion":"EGRESO CONTROL CON ENFOQUE RIESGO ODONTOLÓGICO (CERO)"%\'',
    'valor like \'%"tipo_atencion":"ALTAS ODONTOLÓGICAS PREVENTIVAS"%\'',
    'valor like \'%"tipo_atencion":"ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)"%\'',
    'valor like \'%"tipo_atencion":"ALTAS ODONTOLÓGICAS TOTALES"%\'',
    'valor like \'%"tipo_atencion":"EGRESOS POR ABANDONO"%\'',
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\'',
    'valor like \'%"tipo_atencion":"TOTAL"%\'',
    'valor like \'%"tipo_atencion":" N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)"%\'',
    'valor like \'%"tipo_atencion":"TOTAL"%\'',
    'valor like \'%"tipo_atencion":"CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS"%\'',

];
$PROFESIONES[0] = [
    '',

];
$FILTRO_PROFESION[0] = [

];
$PROFESIONES[1] = [
    '',

];
$FILTRO_PROFESION[1] = [

];
$PROFESIONES[2] = [
    '',

];
$FILTRO_PROFESION[2] = [

];
$PROFESIONES[3] = [
    '',

];
$FILTRO_PROFESION[3] = [

];
$PROFESIONES[4] = [
    '',

];
$FILTRO_PROFESION[4] = [

];
$PROFESIONES[5] = [
    '',

];
$FILTRO_PROFESION[5] = [

];
$PROFESIONES[6] = [
    '',

];
$FILTRO_PROFESION[6] = [

];

$PROFESIONES[7] = [
    '0',
    '1 a 2',
    '3 a 4',
    '5 a 6',
    '7 a 8',
    '9 o más',

];
$FILTRO_PROFESION[7] = [
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\' AND  valor like \'%"tipo_horario":"0"%\'',
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\' AND  valor like \'%"tipo_horario":"1 a 2"%\'',
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\' AND  valor like \'%"tipo_horario":"3 a 4"%\'',
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\' AND  valor like \'%"tipo_horario":"5 a 6"%\'',
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\' AND  valor like \'%"tipo_horario":"7 a 8"%\'',
    'valor like \'%"tipo_atencion":"ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD)"%\' AND  valor like \'%"tipo_horario":"9 o más"%\'',

];
$PROFESIONES[8] = [
    '',

];
$FILTRO_PROFESION[8] = [

];
$PROFESIONES[9] = [
    '0',
    '1 a 9',
    '10 a 19',
    '20 a 27',
    '28 y más',

];
$FILTRO_PROFESION[9] = [
    'valor like \'%"tipo_atencion":" N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)"%\' AND  valor like \'%"tipo_horario":"0"%\'',
    'valor like \'%"tipo_atencion":" N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)"%\' AND  valor like \'%"tipo_horario":"1 a 9"%\'',
    'valor like \'%"tipo_atencion":" N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)"%\' AND  valor like \'%"tipo_horario":"10 a 19"%\'',
    'valor like \'%"tipo_atencion":" N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)"%\' AND  valor like \'%"tipo_horario":"20 a 27"%\'',
    'valor like \'%"tipo_atencion":" N° de dientes (total de dientes en boca. En dentición mixta se suman los dientes primarios y permanentes)"%\' AND  valor like \'%"tipo_horario":"28 y MAS"%\'',


];
$PROFESIONES[10] = [
    '',

];
$FILTRO_PROFESION[10] = [

];
$PROFESIONES[11] = [
    '0',
    '1,2,3',
    '4 y *',
    'TOTAL',


];
$FILTRO_PROFESION[7] = [
    'valor like \'%"tipo_atencion":"CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS"%\' AND  valor like \'%"tipo_horario":"0"%\'',
    'valor like \'%"tipo_atencion":"CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS"%\' AND  valor like \'%"tipo_horario":"1,2,3"%\'',
    'valor like \'%"tipo_atencion":"CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS"%\' AND  valor like \'%"tipo_horario":"4 y *"%\'',
    'valor like \'%"tipo_atencion":"CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS"%\' AND  valor like \'%"tipo_horario":"TOTAL"%\'',

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
<section id="seccion_A03A2" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCIÓN C : INGRESOS Y EGRESOS EN APS [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                CONCEPTO
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
                60 años (incluido en grupos de 60-64 años)
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
            <td ROWSPAN="3">
                Paciente en Control Programa Salud Cardiovascular
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

            $total_fila = 0;


            echo '<tr>';
            echo '<td rowspan="'.count($PROFESIONES[$i]).'">' . $FILA . '</td>';
            foreach ($PROFESIONES[$i] AS $indice => $profesion){
                $filtro_fila = $FILTRO_PROFESION[$i][$indice];
                $total_hombre = 0;
                $total_mujer = 0;
                echo '<td>'.$profesion.'</td>';
                $fila = '';
                foreach ($rango_seccion as $c => $filtro_columna) {
                    $sql = "select count(*) as total from registro_rem  
                        where fecha_registro>='$fecha_inicio' 
                          and fecha_registro<='$fecha_termino'
                          and sexo='M'
                          and valor like '%:%".$profesion."%'
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
                          and valor like '%:%".$profesion."%'
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

                echo $fila;

                echo '</tr>';
                echo '<tr>';
            }
            echo '</tr>';
        }
        ?>

    </table>
</section>



