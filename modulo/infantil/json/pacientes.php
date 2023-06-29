<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

$tipo = $_GET['tipo'];

$filtro_tipo = '';
if($tipo!='TODOS'){
    if($tipo=='NANEAS'){
        $filtro_tipo = " and persona.nanea!='' and persona.nanea!='NO' ";
    }else{
        if($tipo=='PUEBLOS ORIGINARIOS'){
            $filtro_tipo = " and persona.pueblo!='' and persona.pueblo!='NO' ";
        }else{
            if($tipo=='POBLACION MIGRANTE'){
                $filtro_tipo = " and persona.migrante!='' and persona.migrante!='NO' ";
            }
        }
    }
}

$id_establecimiento = $_SESSION['id_establecimiento'];


$sql = "select * from persona
                inner join paciente_establecimiento pe on persona.rut = pe.rut
                inner join sectores_centros_internos sci on sci.id_sector_centro_interno=pe.id_sector
                inner join centros_internos ci on sci.id_centro_interno = ci.id_centro_interno
                where pe.m_infancia = 'SI'
                  and pe.id_establecimiento = '1'
                   and estado_registro = 'ACTIVO'
                 $filtro_tipo ";
//echo $sql;
$res = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($res)){
    $paciente = new persona($row['rut']);

    $meses = $paciente->total_meses;
    $anios = (int)abs($meses/12);
    $meses = (int)abs($meses%12);
    $dias = 0;
    $d = date('d');//dia actual
    list($a1,$m1,$d1) =explode("-",$paciente->fecha_nacimiento);

    if($d > $d1){//ya paso el mes
        $dias = $d-$d1;
    }else{
        $dias =  abs( 30 - ($d1-$d) );
    }


    $customers[] = array(
        'rut' => strtoupper($paciente->rut),
        'link' => strtoupper($paciente->rut),
        'editar' => strtoupper($paciente->rut),
        'nombre' => strtoupper($paciente->nombre),
        'CONTACTO' => strtoupper($paciente->getContacto()),
        'sexo' => strtoupper($paciente->sexo),
        'nacimiento' => fechaNormal($paciente->fecha_nacimiento),
        'comuna' => strtoupper($paciente->comuna),
        'establecimiento' => strtoupper($row['nombre_centro_interno']),
        'sector_comunal' => strtoupper($row['nombre_sector_comunal']),
        'sector_interno' => strtoupper($row['nombre_sector_interno']),
        'nanea' => strtoupper($paciente->getNaneas()),
        'originarios' => strtoupper($paciente->pueblo),
        'migrantes' => strtoupper($paciente->migrante),
        'edad' => $paciente->total_meses,
        'anios' => $anios,
        'meses' => $meses,
        'dias' => $dias,
    );
    $i++;
}

if($i>0){
    $data[] = array(
        'TotalRows' => ''.$i,
        'Rows' => $customers
    );
    echo json_encode($data);
}

?>
