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
    'FAMILIA CON NIÑO PREMATURO',
    'FAMILIA CON NIÑO RECIÉN NACIDO',
    'FAMILIA CON NIÑO CON DÉFICIT DEL DSM',
    'FAMILIA CON NIÑO EN RIESGO VINCULAR AFECTIVO',
    'FAMILIA CON NIÑO < 7 MESES CON SCORE DE RIESGO MODERADO DE MORIR POR NEUMONÍA',
    'FAMILIA CON NIÑO < 7 MESES CON SCORE DE RIESGO GRAVE DE MORIR POR NEUMONÍA',
    'FAMILIA CON NIÑO CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO',
    'FAMILIA CON NIÑO MALNUTRIDO',
    'FAMILIA CON NIÑO CON RIESGO PSICOSOCIAL (EXCLUYE VINCULAR AFECTIVO)',
    'FAMILIA CON ADOLESCENTE EN RIESGO O PROBLEMA PSICOSOCIAL',
    'FAMILIA CON INTEGRANTE CON PATOLOGÍA CRÓNICA DESCOMPENSADA',
    'FAMILIA CON ADULTO MAYOR DEPENDEDIENTE (EXCLUYE DEPENDIENTE SEVERO)',
    'FAMILIA CON ADULTO MAYOR EN RIESGO PSICOSOCIAL',
    'FAMILIA CON GESTANTE ADOLESCENTE 10 A 14 AÑOS',
    'FAMILIA CON GESTANTE >20 AÑOS EN RIESGO PSICOSOCIAL',
    'FAMILIA CON GESTANTE ADOLESCENTE EN RIESGO PSICOSOCIAL 15 A 19 AÑOS',
    'FAMILIA CON ADOLESCENTE CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO',
    'FAMILIA CON ADULTO CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO',
    'FAMILIA CON GESTANTE EN RIESGO BIOMÉDICO',
    'FAMILIA CON OTRO RIESGO PSICOSOCIAL',
    'FAMILIA CON INTEGRANTE CON PROBLEMA DE SALUD MENTAL',
    'FAMILIA CON NIÑOS/AS DE 5 A 9 AÑOS CON PROBLEMAS Y/O TRASTORNOS DE SALUD MENTAL',
    'FAMILIA CON INTEGRANTE CON MULTIMORBILIDAD CRONICA (excluye dependencia severa)',
    'A PERSONAS CON DEPENDENCIA SEVERA',

];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO PREMATURO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO RECIÉN NACIDO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO CON DÉFICIT DEL DSM"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO EN RIESGO VINCULAR AFECTIVO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO < 7 MESES CON SCORE DE RIESGO MODERADO DE MORIR POR NEUMONÍA"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO < 7 MESES CON SCORE DE RIESGO GRAVE DE MORIR POR NEUMONÍA"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO MALNUTRIDO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO CON RIESGO PSICOSOCIAL (EXCLUYE VINCULAR AFECTIVO)"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON ADOLESCENTE EN RIESGO O PROBLEMA PSICOSOCIAL"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON INTEGRANTE CON PATOLOGÍA CRÓNICA DESCOMPENSADA"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON ADULTO MAYOR DEPENDEDIENTE (EXCLUYE DEPENDIENTE SEVERO)"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON ADULTO MAYOR EN RIESGO PSICOSOCIAL"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON GESTANTE ADOLESCENTE 10 A 14 AÑOS"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON GESTANTE >20 AÑOS EN RIESGO PSICOSOCIAL"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON GESTANTE ADOLESCENTE EN RIESGO PSICOSOCIAL 15 A 19 AÑOS"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON ADOLESCENTE CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON ADULTO CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON GESTANTE EN RIESGO BIOMÉDICO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON OTRO RIESGO PSICOSOCIAL"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON INTEGRANTE CON PROBLEMA DE SALUD MENTAL"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑOS/AS DE 5 A 9 AÑOS CON PROBLEMAS Y/O TRASTORNOS DE SALUD MENTAL"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON INTEGRANTE CON MULTIMORBILIDAD CRONICA (excluye dependencia severa)"%\'',
    'valor like \'%"tipo_atencion":"A PERSONAS CON DEPENDENCIA SEVERA"%\'',

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
    '',
];
$FILTRO_PROFESION[7] = [
];
$PROFESIONES[8] = [
    '',
];
$FILTRO_PROFESION[8] = [
];
$PROFESIONES[9] = [
    '',
];
$FILTRO_PROFESION[9] = [
];
$PROFESIONES[10] = [
    '',
];
$FILTRO_PROFESION[10] = [
];
$PROFESIONES[11] = [
    '',
];
$FILTRO_PROFESION[11] = [
];
$PROFESIONES[12] = [
    '',
];
$FILTRO_PROFESION[12] = [
];
$PROFESIONES[13] = [
    '',
];
$FILTRO_PROFESION[13] = [
];
$PROFESIONES[14] = [
    '',
];
$FILTRO_PROFESION[14] = [
];
$PROFESIONES[15] = [
    '',
];
$FILTRO_PROFESION[15] = [
];
$PROFESIONES[16] = [
    '',
];
$FILTRO_PROFESION[16] = [
];
$PROFESIONES[17] = [
    '',
];
$FILTRO_PROFESION[17] = [
];
$PROFESIONES[18] = [
    '',
];
$FILTRO_PROFESION[18] = [
];
$PROFESIONES[19] = [
    '',
];
$FILTRO_PROFESION[19] = [
];
$PROFESIONES[20] = [
    '',
];
$FILTRO_PROFESION[20] = [
];
$PROFESIONES[21] = [
    '',
];
$FILTRO_PROFESION[21] = [
];
$PROFESIONES[22] = [
    '',
];
$FILTRO_PROFESION[22] = [
];

$PROFESIONES[23] = [
    'FAMILIA CON ADULTO MAYOR CON DEMENCIA',
    'FAMILIA CON INTEGRANTE CON ENFERMEDAD TERMINAL',
    'FAMILIA CON INTEGRANTE ALTA HOSPITALIZACIÓN PRECOZ',
    'FAMILIA CON INTEGRANTE CON DEPENDENCIA SEVERA (excluye adulto mayor)',
    'FAMILIA CON ADULTO MAYOR DEPENDIENTE SEVERO',

];
$FILTRO_PROFESION[23] = [
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO PREMATURO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO PREMATURO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO PREMATURO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO PREMATURO"%\'',
    'valor like \'%"tipo_atencion":"FAMILIA CON NIÑO PREMATURO"%\'',

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
            <header>SECCIÓN A: VISITAS DOMICILIARIAS INTEGRALES A FAMILIAS (ESTABLECIMIENTOS APS) [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="1" COLSPAN="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                CONCEPTOS
            </td>
            <td  rowspan="1">
                TOTAL
            </td>
            <td  rowspan="1">
                UN PROFESIONAL
            </td>
            <td  rowspan="1">
                DOS O MÁS PROFESIONALES
            </td>
            <td  rowspan="1">
                UN PROFESIONAL Y UN TÉCNICO PARAMÉDICO
            </td>
            <td  rowspan="1">
                TÉCNICO PARAMÉDICO
            </td>
            <td  rowspan="1">
                FACILITADOR/A INTERCULTURAL PUEBLOS ORIGINARIOS
            </td>
            <td  rowspan="1">
                AGENTE COMUNITARIO
            </td>
            <td  rowspan="1">
                PRIMERA VISITA
            </td>
            <td  rowspan="1">
                SEGUNDA VISITA
            </td>
            <td  rowspan="1">
                TERCERA O MÁS VISITAS DE SEGUIMIENTO
            </td>
            <td  rowspan="1">
                PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN APS
            </td>
            <td  rowspan="1">
                MIGRANTES
            </td>
            <td  rowspan="1">
                MULTIMORBILIDAD CRÓNICA
            </td>

        </tr>
        <tr>
            <?php
            foreach ($rango_seccion_text as $i => $item){
                echo '<td colspan="1">'.$item.'</td>';
            }
            ?>
        </tr>
        <tr>

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









