<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

$id_sector_interno = $_GET['id_sector_interno'];

$id_establecimiento = $_SESSION['id_establecimiento'];

$filtro = '';
$sql = "select * from paciente_establecimiento 
                inner join persona on paciente_establecimiento.rut=persona.rut
                INNER JOIN paciente_adultomayor on persona.rut=paciente_adultomayor.rut 
                where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                and paciente_establecimiento.m_adulto_mayor='SI' 
                and persona.rut!='' 
                and persona.fecha_nacimiento!=''
                and paciente_establecimiento.id_sector!=''
                group by paciente_establecimiento.rut 
                ";
$res = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($res)){

    $paciente = new persona($row['rut']);

    if($paciente->existe==true){
        if($paciente->nombre!=''){
            $resumen_centro = $paciente->getEstablecimiento();

            if(strtoupper($paciente->nombre_sector_comunal)!=''){
                $customers[] = array(
                    'rut' => strtoupper($paciente->rut),
                    'link' => strtoupper($paciente->rut),
                    'nombre' => strtoupper($paciente->nombre),
                    'sexo' => strtoupper($paciente->sexo),
                    'edad' => strtoupper($paciente->edad),
                    'anios' => strtoupper($paciente->edad_anios),
                    'dias' => strtoupper($paciente->edad_dias),
                    'meses' => strtoupper($paciente->edad_meses),
                    'establecimiento' => strtoupper($paciente->nombre_centro_medico),
                    'sector_comunal' => strtoupper($paciente->nombre_sector_comunal),
                    'sector_interno' => strtoupper($paciente->nombre_sector_interno),

                    'IMC' => trim($row['imc']),
                    'ACTIVIDAD_FISICA' => trim($row['actividad_fisica']),
                    'RIESGO_CAIDA' => trim($row['riesgo_caida']),
                    'SOSPECHA_MALTRATO' => trim($row['sospecha_maltrato']),
                    'YESAVAGE' => trim($row['yesavage']),
                    'MAS_ADULTO_MAYOR' => trim($row['mas_adulto_mayor']),
                    'FUNCIONALIDAD' => trim($row['funcionalidad']),
                    'CHILE_CUIDA' => trim($row['chile_cuida']),
                    'MINIMENTAL' => trim($row['minimental']),
                    'ESTACION_UNIPODAL' => trim($row['estacion_unipodal']),
                    'ELEAM' => trim($row['eleam']),


                    'ultimo_control' => $paciente->getUltimaEval(),
                    'proximo_control' => $paciente->getProximoControl(),

                );

                $i++;
            }
        }
    }
}

if($i>0){
    $data[] = array(
        'TotalRows' => ''.$i,
        'Rows' => $customers
    );
    echo json_encode($data);
}

?>
