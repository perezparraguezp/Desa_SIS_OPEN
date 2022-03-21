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
    "registro_rem.edad like '0 A 4'",
    "registro_rem.edad like '5 A 9'",
    "registro_rem.edad like '10 A 14'",
    "registro_rem.edad like '15 A 19'",
    "registro_rem.edad like '20 A 24'",
    "registro_rem.edad like '25 A 29'",
    "registro_rem.edad like '30 A 34'",
    "registro_rem.edad like '35 A 39'",
    "registro_rem.edad like '40 A 44'",
    "registro_rem.edad like '45 A 49'",
    "registro_rem.edad like '50 A 54'",
    "registro_rem.edad like '55 A 59'",
    "registro_rem.edad like '60 A 64'",
    "registro_rem.edad like '65 A 69'",
    "registro_rem.edad like '70 A 74'",
    "registro_rem.edad like '75 A 79'",
    "registro_rem.edad like '80 %'",
    'valor like \'%"Espacios Amigables/adolescentes":"SI"%\'',
    'valor like \'%"TRANS":"SI"%\'',
    'valor like \'%"Pueblos Originarios":"SI"%\'',
    'valor like \'%"Migrantes":"SI"%\'',
    'valor like \'%"SENAME":"SI"%\'',
];
$rango_seccion_text = [
    '0 A 4',//
    '5 A 9',//
    '10 A 14',//
    '15 A 19',//
    '20 A 24',//
    '25 A 29',//
    '30 A 34',//
    '35 A 39',//
    '40 A 44',//
    '45 A 49',//
    '50 A 54',//
    '55 A 59',//
    '60 A 64',//
    '65 A 69',//
    '70 A 74',//
    '75 A 79',//
    '80 Y MÁS',//

];

$FILA_HEAD = [
    'ACTIVIDAD FÍSICA',
    'ALIMENTACIÓN SALUDABLE',
    'TABAQUISMO',
    'CONSUMO DE DROGAS',
    'SALUD SEXUAL Y REPRODUCTIVA',
    'REGULACIÓN DE FERTILIDAD',
    'PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)',
    'PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)',
    'DESARROLLO INFANTIL INTEGRAL',
    'OTRAS ÁREAS',
];
$FILA_HEAD_SQL = [
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\'',
    'valor like \'%"tipo_atencion":"REGULACIÓN DE FERTILIDAD"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)"%\'',
    'valor like \'%"tipo_atencion":"DESARROLLO INFANTIL INTEGRAL"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\'',
];

$PROFESIONES[0] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'NUTRICIONISTA',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'KINESIÓLOGO',
    'TERAPEUTA OCUPACIONAL',
    'OTRO PROFESIONAL',
    'FACILITADOR/A INTERCULTURAL',
    'TÉCNICO PARAMÉDICO',

];
$FILTRO_PROFESION[0] = [
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"NUTRICIONISTA"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"KINESIÓLOGO"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"TERAPEUTA OCUPACIONAL"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"ACTIVIDAD FÍSICA"%\' AND  valor like \'%"profeisonal":"TENS"%\'',

];
$PROFESIONES[1] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'NUTRICIONISTA',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'KINESIÓLOGO',
    'TERAPEUTA OCUPACIONAL',
    'OTRO PROFESIONAL',
    'FACILITADOR/A INTERCULTURAL',
    'TÉCNICO PARAMÉDICO',

];
$FILTRO_PROFESION[1] = [
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"NUTRICIONISTA"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"KINESIÓLOGO"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"TERAPEUTA OCUPACIONAL"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"ALIMENTACIÓN SALUDABLE"%\' AND  valor like \'%"profeisonal":"TENS"%\'',

];
$PROFESIONES[2] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'NUTRICIONISTA',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'KINESIÓLOGO',
    'TERAPEUTA OCUPACIONAL',
    'OTRO PROFESIONAL',
    'FACILITADOR/A INTERCULTURAL',
    'TÉCNICO PARAMÉDICO',

];
$FILTRO_PROFESION[2] = [
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"NUTRICIONISTA"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"KINESIÓLOGO"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"TERAPEUTA OCUPACIONAL"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"TABAQUISMO"%\' AND  valor like \'%"profeisonal":"TENS"%\'',

];
$PROFESIONES[3] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'NUTRICIONISTA',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'KINESIÓLOGO',
    'TERAPEUTA OCUPACIONAL',
    'OTRO PROFESIONAL',
    'FACILITADOR/A INTERCULTURAL',
    'TÉCNICO PARAMÉDICO',

];
$FILTRO_PROFESION[3] = [
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"NUTRICIONISTA"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"KINESIÓLOGO"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"TERAPEUTA OCUPACIONAL"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"CONSUMO DE DROGAS"%\' AND  valor like \'%"profeisonal":"TENS"%\'',

];
$PROFESIONES[4] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'FACILITADOR/A INTERCULTURAL',
    'OTRO PROFESIONAL',


];
$FILTRO_PROFESION[4] = [
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"SALUD SEXUAL Y REPRODUCTIVA"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',

];
$PROFESIONES[5] = [
    'MÉDICO',
    'MATRONA/ÓN',
    'FACILITADOR/A INTERCULTURAL',
    'OTRO PROFESIONAL',


];
$FILTRO_PROFESION[5] = [
    'valor like \'%"tipo_atencion":"REGULACIÓN DE FERTILIDAD"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"REGULACIÓN DE FERTILIDAD"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"REGULACIÓN DE FERTILIDAD"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"REGULACIÓN DE FERTILIDAD"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',

];
$PROFESIONES[6] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'FACILITADOR/A INTERCULTURAL',
    'OTRO PROFESIONAL',


];
$FILTRO_PROFESION[6] = [
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',

];
$PROFESIONES[7] = [
    'MÉDICO PRE TEST',
    'MATRONA /ÓN PRE TEST',
    'MÉDICO POST TEST',
    'MATRONA /ÓN POST TEST',
    'FACILITADOR/A INTERCULTURAL',

];
$FILTRO_PROFESION[7] = [
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)"%\' AND  valor like \'%"profeisonal":"MÉDICO PRE TEST"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)"%\' AND  valor like \'%"profeisonal":"MATRONA /ÓN PRE TEST"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)"%\' AND  valor like \'%"profeisonal":"MÉDICO POST TEST"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)"%\' AND  valor like \'%"profeisonal":"MATRONA /ÓN POST TEST"%\'',
    'valor like \'%"tipo_atencion":"PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
];
$PROFESIONES[8] = [
    'ENFERMERA /O',
];
$FILTRO_PROFESION[8] = [
    'valor like \'%"tipo_atencion":"DESARROLLO INFANTIL INTEGRAL"%\' AND  valor like \'%"profeisonal":"ENFERMERA /O"%\'',
];
$PROFESIONES[8] = [
    'MÉDICO',
    'ENFERMERA/O',
    'MATRONA/ÓN',
    'ASISTENTE SOCIAL',
    'PSICÓLOGO/A',
    'TERAPEUTA OCUPACIONAL',
    'FACILITADOR/A INTERCULTURAL',
    'OTRO PROFESIONAL',
];
$FILTRO_PROFESION[8] = [
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"MÉDICO"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"ENFERMERA/O"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"MATRONA/ÓN"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"ASISTENTE SOCIAL"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"PSICÓLOGO/A"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"TERAPEUTA OCUPACIONAL"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"FACILITADOR/A INTERCULTURAL"%\'',
    'valor like \'%"tipo_atencion":"OTRAS ÁREAS"%\' AND  valor like \'%"profeisonal":"OTRO PROFESIONAL"%\'',

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
            <header>SECCIÓN A: CONSEJERÍAS
                <BR />SECCIÓN A.1: CONSEJERÍAS INDIVIDUALES [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A5" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ACTIVIDADES Y ÁREAS TEMÁTICAS
            </td>
            <td colspan="1" rowspan="3">
                PROFESIONAL
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="34">
                GRUPOS DE EDAD (en años)
            </td>
            <td ROWSPAN="3">
                Espacios Amigables / adolescentes
            </td>
            <td ROWSPAN="2" colspan="2">
                TRANS
            </td>
            <td ROWSPAN="3">
                Pueblos Originarios
            </td>
            <td ROWSPAN="3">
                Migrantes
            </td>
            <td ROWSPAN="3">
                14-18 años
            </td>
            <td ROWSPAN="3">
                Niños, Niñas, Adolescentes y Jóvenes Población SENAME
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
            <td>Masculino</td>
            <td>Femenino</td>

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










