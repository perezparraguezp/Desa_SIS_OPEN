<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

session_start();
$id_establecimiento = $_SESSION['id_establecimiento'];

$sql = "select * from paciente_establecimiento
                where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                and paciente_establecimiento.m_salud_mental='SI' 
                ";
//echo $sql."<br />";


$res = mysql_query($sql);

$i = 0;
$customers=Array() ;
while($row = mysql_fetch_array($res)){
    $rut = trim($row['rut']);

    $paciente = new persona($rut);

    if($paciente->existe==true){

        if($paciente->nombre!=''){

            $resumen_centro = $paciente->getEstablecimiento();
            if(strtoupper($paciente->nombre_sector_comunal)!=''){

                $variable  = array(
                    'fila' => $i,
                    'rut' => strtoupper($paciente->rut),
                    'link' => strtoupper($paciente->rut),
                    'editar' => strtoupper($paciente->rut),
                    'nombre' => strtoupper($paciente->nombre),
                    'sexo' => strtoupper($paciente->sexo),
                    'nacimiento' => ($paciente->fecha_nacimiento),
                    'comuna' => strtoupper($paciente->comuna),
                    'establecimiento' => strtoupper($paciente->nombre_centro_medico),
                    'sector_comunal' => strtoupper($paciente->nombre_sector_comunal),
                    'sector_interno' => strtoupper($paciente->nombre_sector_interno),
                    'edad' => $paciente->total_meses,
                    'anios' => $paciente->edad_anios,
                    'meses' => $paciente->edad_meses,
                    'dias' => $paciente->edad_dias
                );
                $customers[] = $variable;


                $i++;
            }
        }
    }
}//fin while

//echo $i;
//print_r($customers);
$data[] = array(
    'TotalRows' => $i,
    'Rows' => $customers
);
echo json_encode($data);

?>
