<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

$id_sector_interno = $_GET['id_sector_interno'];

$id_establecimiento = $_SESSION['id_establecimiento'];

$filtro = '';
$sql = "select * from paciente_establecimiento 
                inner join persona on paciente_establecimiento.rut=persona.rut 
                where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                and paciente_establecimiento.m_infancia='SI' 
                and persona.rut!='' 
                group by paciente_establecimiento.rut 
                ";
$res = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($res)){

    $paciente = new persona($row['rut']);

    if($paciente->existe==true){
        if($paciente->nombre!=''){
            $resumen_centro = $paciente->getEstablecimiento();
            $sql1 = "select * from antropometria 
                    where rut='$paciente->rut' limit 1";
            $row1 = mysql_fetch_array(mysql_query($sql1));

            $sql2 = "select * from paciente_psicomotor 
                    where rut='$paciente->rut' limit 1";
            $row2 = mysql_fetch_array(mysql_query($sql2));

            $sql3 = "select * from vacunas_paciente 
                    where rut='$paciente->rut' limit 1";
            $row3 = mysql_fetch_array(mysql_query($sql3));



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

                    'PE' => trim($row1['PE']),
                    'PT' => trim($row1['PT']),
                    'TE' => trim($row1['TE']),
                    'DNI' =>trim( $row1['DNI']),
                    'PCINT' => trim($row1['PCINT']),
                    'IMCE' => trim($row1['IMCE']),
                    'LME' => trim($row1['LME']),
                    'RIMALN' => trim($row1['RIMALN']),
                    'SCORE_IRA' => trim($row1['SCORE_IRA']),
                    'presion_arterial' => trim($row1['presion_arterial']),
                    'perimetro_craneal' => trim($row1['perimetro_craneal']),
                    'agudeza_visual' => trim($row1['agudeza_visual']),
                    'evaluacion_auditiva' => trim($row1['evaluacion_auditiva']),
                    'atencion_secundaria' => trim($row1['atencion_secundaria']),

                    'ev_neurosensorial' => trim($row2['ev_neurosensorial']),
                    'rx_pelvis' => trim($row2['rx_pelvis']),
                    'eedp' => trim($row2['eedp']),
                    'tepsi' => trim($row2['tepsi']),
                    'pauta_breve' => trim($row2['pauta_breve']),
                    'mchat' => trim($row2['mchat']),
                    'otra_vulnerabilidad' => trim($row2['otra_vulnerabilidad']),

                    '2m' => trim($row3['2m']),
                    '4m' => trim($row3['4m']),
                    '6m' => trim($row3['6m']),
                    '12m' => trim($row3['12m']),
                    '18m' => trim($row3['18m']),
                    '3anios' => trim($row3['3anios']),
                    '5anios' => trim($row3['5anios']),

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
