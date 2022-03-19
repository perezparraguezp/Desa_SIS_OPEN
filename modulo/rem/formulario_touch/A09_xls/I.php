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
    'MENOS de 1 AÑO - 1 AÑO',//
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
    'CONSULTAS',
    'CIRUGÍA BUCAL',
    'CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL',
    'ENDODONCIA',
    'ODONTOPEDIATRÍA',
    'OPERATORIA',
    'ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA',
    'ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE',
    'PERIODONCIA',
    'REHABILITACIÓN: PRÓTESIS FIJA',
    'REHABILITACIÓN: PRÓTESIS REMOVIBLE',
    'REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA',
    'IMPLANTOLOGÍA BUCO MAXILOFACIAL',
    'PATOLOGÍA ORAL',
    'TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL',
    'TOTAL',

];
$FILA_HEAD_SQL = [
    'valor like \'%"sub_seccion":"CONSULTAS"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\'',
    'valor like \'%"sub_seccion":"ENDODONCIA"%\'',
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\'',
    'valor like \'%"sub_seccion":"OPERATORIA"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\'',
    'valor like \'%"sub_seccion":"PERIODONCIA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\'',
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\'',
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\'',
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\'',
    'valor like \'%"sub_seccion":"TOTAL"%\'',

];
$PROFESIONES[0] = [
    'CONSULTA DE URGENCIA GES',
    'CONSULTA DE URGENCIA NO GES',

];
$FILTRO_PROFESION[0] = [
    'valor like \'%"sub_seccion":"CONSULTAS"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA DE URGENCIA GES"%\'',
    'valor like \'%"sub_seccion":"CONSULTAS"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA DE URGENCIA NO GES"%\'',


];
$PROFESIONES[1] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[1] = [
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA BUCAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',

];
$PROFESIONES[2] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[2] = [
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];
$PROFESIONES[3] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[3] = [
    'valor like \'%"sub_seccion":"ENDODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"ENDODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"ENDODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ENDODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ENDODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"ENDODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];
$PROFESIONES[4] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[4] = [
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"ODONTOPEDIATRÍA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];
$PROFESIONES[5] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[5] = [
    'valor like \'%"sub_seccion":"OPERATORIA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"OPERATORIA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"OPERATORIA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"OPERATORIA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"OPERATORIA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"OPERATORIA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',

];
$PROFESIONES[6] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[6] = [
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];

$PROFESIONES[7] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',
];
$FILTRO_PROFESION[7] = [
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',



];
$PROFESIONES[8] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[8] = [
    'valor like \'%"sub_seccion":"PERIODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"PERIODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"PERIODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"PERIODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"PERIODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"PERIODONCIA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];
$PROFESIONES[9] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',
];
$FILTRO_PROFESION[9] = [
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS FIJA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',

];
$PROFESIONES[10] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[10] = [
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS REMOVIBLE"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',
];
$PROFESIONES[11] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[11] = [
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',
];
$PROFESIONES[12] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[12] = [
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"IMPLANTOLOGÍA BUCO MAXILOFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',
];
$PROFESIONES[13] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[13] = [
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"PATOLOGÍA ORAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];
$PROFESIONES[14] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[14] = [
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


];
$PROFESIONES[15] = [
    'CONSULTA NUEVA',
    'CONTROL',
    'INGRESOS A TRATAMIENTO',
    'ALTAS DE TRATAMIENTO',
    'CONTROL DE ESPECIALIDAD POST ALTA',
    'ALTAS ADMINISTRATIVAS',

];
$FILTRO_PROFESION[15] = [
    'valor like \'%"sub_seccion":"TOTAL"%\' AND  valor like \'%"tipo_profeisonal":"CONSULTA NUEVA"%\'',
    'valor like \'%"sub_seccion":"TOTAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL"%\'',
    'valor like \'%"sub_seccion":"TOTAL"%\' AND  valor like \'%"tipo_profeisonal":"INGRESOS A TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"TOTAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS DE TRATAMIENTO"%\'',
    'valor like \'%"sub_seccion":"TOTAL"%\' AND  valor like \'%"tipo_profeisonal":"CONTROL DE ESPECIALIDAD POST ALTA"%\'',
    'valor like \'%"sub_seccion":"TOTAL"%\' AND  valor like \'%"tipo_profeisonal":"ALTAS ADMINISTRATIVAS"%\'',


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
            <header>SECCIÓN I:  CONSULTAS, INGRESOS Y EGRESOS EN ESPECIALIDADES ODONTOLÓGICAS REALIZADOS EN NIVEL PRIMARIO Y SECUNDARIO DE SALUD. ESPECIAIDADES EN APS [<?php echo fechaNormal($fecha_inicio).' al '.fechaNormal($fecha_termino) ?>]</header>
        </div>
    </div>
    <table id="table_seccion_A2" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td rowspan="3" colspan="2" style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                ESPECIALIDAD Y TIPO DE INGRESO O EGRESO.
            </td>
            <td colspan="3" rowspan="2">
                TOTAL
            </td>
            <td colspan="36">
                POR DE EDAD (en años)
            </td>
            <td ROWSPAN="3">
                Embarazadas
            </td>
            <td ROWSPAN="3">
                60 años (incluido en grupos de  60-64 años)
            </td>
            <td ROWSPAN="2" COLSPAN="2">
                CONSULTAS PERTINENTES
            </td>
            <td ROWSPAN="3">
                Inasistente
            </td>
            <td ROWSPAN="3">
                Compra de Servicio
            </td>
            <td ROWSPAN="3">
                Usuarios con Discapacidad
            </td>
            <td ROWSPAN="3">
                Niños, niñas, adolescentes y jovenes RED SENAME
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
            <td>Según Protocolo de Referencia</td>
            <td>Según condición clínica</td>

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




