<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");
include("../../../php/objetos/familia.php");


function calcularDiferenciaDias($fechaInicio, $fechaFin) {
    // Convertir las fechas en objetos DateTime
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinObj = new DateTime($fechaFin);

    // Calcular la diferencia entre las fechas
    $diferencia = $fechaInicioObj->diff($fechaFinObj);

    // Devolver la diferencia en días
    return $diferencia->days;
}

function sumarDiasAFecha($fecha, $dias) {
    // Convertir la fecha en un objeto DateTime
    $fechaObj = new DateTime($fecha);

    // Sumar los días
    $fechaObj->modify("+$dias days");

    // Devolver la nueva fecha en formato YYYY-MM-DD
    return $fechaObj->format('Y-m-d');
}


session_start();
$id_establecimiento = $_SESSION['id_establecimiento'];

$sql = "select * from familia
inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                where familia.id_establecimiento='$id_establecimiento' 
                order by nombre_familia ";

$res = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_array($res)){
    $id_familia = $row['id_familia'];
    $familia = new familia($id_familia);

    $fecha = $familia->getFechaPautaRiesgo();
    if($fecha!=''){
        $fecha_pauta_final = fechaNormal(sumarDiasAFecha($fecha,720));
    }else{
        $fecha_pauta_final = '';
    }
    $familia->updateSQL('fecha_riesgo',$fecha);

    $fecha = $familia->getFechaVDI();
    if($fecha!=''){
        $fecha_vdi_final = fechaNormal(sumarDiasAFecha($fecha,720));
    }else{
        $fecha_vdi_final = '';
    }
    $familia->updateSQL('fecha_vdi',$fecha);


    $fecha = $familia->getFechaPlanIntv();
    if($fecha!=''){
        $fecha_plan_final = fechaNormal(sumarDiasAFecha($fecha,720));
    }else{
        $fecha_plan_final = '';
    }
    $familia->updateSQL('fecha_plan',$fecha);



    $customers[] = array(
        'codigo' => $row['codigo_familia'],
        'nombre' => $row['nombre_familia'],
        'puntaje' => $row['puntaje'],
        'plan' => $familia->plan_intervencion,
        'fecha_plan' => $fecha_plan_final,
        'vdi' => $familia->vdi_actual,
        'fecha_vdi' => $fecha_vdi_final,
        'integrantes' => $familia->integrantes,
        'direccion' => strtoupper($row['direccion_familia']),
        'estado_evaluacion' => $familia->estadoFamilia(),
        'fecha_pauta' => $fecha_pauta_final,
        'color' => $familia->estadoFamilia(),
        'establecimiento' => $row['nombre_centro_interno'],
        'sector_comunal' => $row['nombre_sector_comunal'],
        'sector_interno' => $row['nombre_sector_interno'],
        'editar' => $id_familia,
        'link' => $id_familia,
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
