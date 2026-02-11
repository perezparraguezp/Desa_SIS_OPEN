<?php

include("../../php/config.php");

include("../../php/objetos/persona.php");

require_once '../reader/Classes/PHPExcel/IOFactory.php';
//Funciones extras
$offset =$_POST['offset'];
$batch = $_POST['batch'];

$id_establecimiento = $_SESSION['id_establecimiento'];

function get_cell($cell, $objPHPExcel) {
    //select one cell
    $objCell = ($objPHPExcel->getActiveSheet()->getCell($cell));
    //get cell value
    return $objCell->getvalue();
}

function pp(&$var) {
    $var = chr(ord($var) + 1);
    return true;
}

$name = $_FILES['file']['name'];
$tname = $_FILES['file']['tmp_name'];
$type = $_FILES['file']['type'];

if ($type == 'application/vnd.ms-excel') {
    // Extension excel 97
    $ext = 'xls';
} else if ($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
    // Extension excel 2007 y 2010
    $ext = 'xlsx';
} else {
    // Extension no valida
    echo -1;
    echo 'parsererror';
    exit();
}

//$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha);

$xlsx = 'Excel2007';
$xls = 'Excel5';

//creando el lector
$objReader = PHPExcel_IOFactory::createReader($$ext);

//cargamos el archivo
$objPHPExcel = $objReader->load($tname);

$dim = $objPHPExcel->getActiveSheet()->calculateWorksheetDimension();

// list coloca en array $start y $end
list($start, $end) = explode(':', $dim);


if (!preg_match('#([A-Z]+)([0-9]+)#', $start, $rslt)) {
    return false;
}
list($start, $start_h, $start_v) = $rslt;
if (!preg_match('#([A-Z]+)([0-9]+)#', $end, $rslt)) {
    return false;
}
list($end, $end_h, $end_v) = $rslt;

$columnas = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ'];
$error = '';
$fila_excel = 0;
for ($v = $offset; $v <= $end_v; $v++) {
    //empieza lectura horizontal
    $fechas = "";
    $coma = 0;
    if($v > 2){

        $fila_excel++;
        //desde la fila 3 en adelante
        $fila = array();
        $rut = '';

        for ($c = 0; $c < count($columnas); $c++) {
            $h = $columnas[$c];

            $cellValue = get_cell($h . $v, $objPHPExcel);//ASIGNAMOS EL CONTENIDO DE LA CELDA A LA VARIABLE

            if($cellValue !== null){
                //tiene datos
                $dato = trim($cellValue);


                if($h == "A"){
                    //columna con RUT
                    $rut = $cellValue;
                    $rut = str_replace(".","",$rut);//limpiamos el rut
                }else{
                    if($h == "B" ){
                        //COLUMNAS CON FECHAS
                        $timestamp = PHPExcel_Shared_Date::ExcelToPHP($cellValue);
                        //$timestamp = strtotime("+1 day",$timestamp);
                        $fecha_php = date("Y-m-d H:i:s",$timestamp);
                        $dato = $fecha_php;
                        $fecha_antropometria = $dato;
                    }

                }

            }else{
                $dato = '';
            }
            //ASIGNAMOS EL VALOR AL ARRAY FILA

            $fila[$h] = $dato;
        }


        if($rut!=''){
//            print_r($fila);echo '<br />';
            if(valida_rut($rut)==true){

//                $rut , $fecha_antropometria;

                $rut = strtoupper($fila['A']);
                $pe = strtoupper($fila['C']);
                $pt = strtoupper($fila['D']);
                $te = strtoupper($fila['E']);
                $imce = strtoupper($fila['F']);
                $pcint = strtoupper($fila['G']);
                $presion_arterial = strtoupper($fila['H']);

                $paciente = new persona($rut);
                $paciente->rut= $rut;
                //antropometria
                $paciente->update_Antropometria('PE',$pe,$fecha_antropometria);
                $paciente->update_Antropometria('PT',$pt,$fecha_antropometria);
                $paciente->update_Antropometria('TE',$te,$fecha_antropometria);
                $paciente->update_Antropometria('IMC',$imce,$fecha_antropometria);
                $paciente->update_Antropometria('PCINT',$pcint,$fecha_antropometria);
                $paciente->update_Antropometria('presion_arterial',$presion_arterial,$fecha_antropometria);

                }
        }else{
            $error .='<div style="padding: 5px;background-color: #ff898b;margin-bottom: 2px;border: solid 2px red;">EL RUT '.$rut.' NO ES VALIDO EN LA FILA '.$v.', NO SE PUEDE REGISTRAR</div>';
        }

        }else{
            $error .='<div style="padding: 5px;background-color: #ff898b;margin-bottom: 2px;border: solid 2px red;">NO EXISTE RUT EN LA FILA '.$v.', NO SE PUEDE REGISTRAR'.$rut.'</div>';
        }


        $porcentaje = $fila_excel*100/$batch;
        $row = array(
            'executed' => $offset,
            'total' => trim($batch),
            'percentage' => round($porcentaje, 0),
            'execute_time' => 1
        );
        die(json_encode($row));
    }//fin if cabecera de excel
echo $error;


