<?php
//echo 1;
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");


session_start();
$id_establecimiento = $_SESSION['id_establecimiento'];
$tipo = $_GET['tipo'];
$filtro = '';
if($tipo!='TODOS'){
    if($tipo=='+ ADULTOS MAYORES'){
        $filtro = " AND mas_adulto_mayor='SI' ";
    }else{
        if($tipo=='ELEAM'){
            $filtro = " AND eleam='SI' ";
        }
    }
}

$sql = "select * from paciente_establecimiento
                inner join paciente_adultomayor on paciente_establecimiento.rut=paciente_adultomayor.rut
                where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                and paciente_establecimiento.m_adulto_mayor='SI' $filtro";


$res = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_array($res)){
    $rut = trim($row['rut']);


    $paciente = new persona($rut);

    $FECHA = $paciente->getUltimaEval();
    if($FECHA=='PENDIENTE'){
        $pendiente = 'NUNCA';
    }else{
        $ultima_fecha = new DateTime($FECHA);
        $hoy   = new DateTime();

        $diferencia = $ultima_fecha->diff($hoy);

        if ($diferencia->y >= 1) {
            $pendiente = 'PENDIENTE';

        } else {
            $pendiente = 'AL DIA';
        }
    }


    if($paciente->existe==true){
        if($paciente->nombre!=''){

            $resumen_centro = $paciente->getEstablecimiento();
            if(strtoupper($paciente->nombre_sector_comunal)!=''){
                $customers[] = array(
                    'rut' => strtoupper($paciente->rut),
                    'link' => strtoupper($paciente->rut),
                    'editar' => strtoupper($paciente->rut),
                    'nombre' => strtoupper($paciente->nombre),
                    'sexo' => strtoupper($paciente->sexo),
                    'nacimiento' => fechaNormal($paciente->fecha_nacimiento),
                    'comuna' => strtoupper($paciente->comuna),
                    'establecimiento' => strtoupper($paciente->nombre_centro_medico),
                    'sector_comunal' => strtoupper($paciente->nombre_sector_comunal),
                    'sector_interno' => strtoupper($paciente->nombre_sector_interno),
                    'edad' => $paciente->total_meses,
                    'anios' => $paciente->edad_anios,
                    'meses' => $paciente->edad_meses,
                    'dias' => $paciente->edad_dias,
                    'ultima' => $FECHA,
                    'pendiente' => $pendiente,
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
