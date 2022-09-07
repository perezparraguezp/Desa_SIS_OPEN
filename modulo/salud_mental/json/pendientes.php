<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");



$id_establecimiento = $_SESSION['id_establecimiento'];

$indicador = $_GET['indicador'];

if($indicador!=''){

}
$rut = trim($_GET['rut']);
if($rut!=''){
    $filtro_rut =" and paciente_establecimiento.rut='$rut' ";
    $persona_filtro = new persona($rut);
}else{
    $filtro_rut = "";
}

//filtro tope de edad

$sql = "select * from paciente_establecimiento
              where paciente_establecimiento.m_salud_mental='SI'
              and paciente_establecimiento.rut!=''
              and paciente_establecimiento.id_establecimiento='$id_establecimiento' $filtro_rut
              group by paciente_establecimiento.rut";

$res = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_array($res)){
    $rut = $row['rut'];
    $paciente = new persona($row['rut']);




    $sql1 = "select * from historial_paciente 
                where tipo_historial='SALUD MENTAL' 
                and rut='$rut' 
                order by fecha_registro desc limit 1";
    $row1 = mysql_fetch_array(mysql_query($sql1));
    if($row1){
        list($fecha,$hora) = explode(" ",$row1['fecha_registro']);
        $fecha_nac = new DateTime(date('Y/m/d', strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
        $fecha_hoy = new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy
        $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto

        if($edad->format('%Y')>0){
            $customers[] = array(
                'rut' => $paciente->rut,
                'link' => $paciente->rut,
                'mail' => $paciente->email,'nombre' => $paciente->nombre,
                'tipo' => 'CONTROL DE SALUD',
                'indicador' => 'MAS DE UN AÑO',
                'ultima_ev' => $paciente->getUltimaEval(),
                'edad_actual' => $paciente->edad,
                'contacto' => $paciente->telefono,
                'establecimiento' => $paciente->getEstablecimiento()
            );
            $i++;
        }
    }else{
        $customers[] = array(
            'rut' => $paciente->rut,
            'link' => $paciente->rut,
            'mail' => $paciente->email,'nombre' => $paciente->nombre,
            'tipo' => 'CONTROL DE SALUD',
            'indicador' => 'NUNCA',
            'ultima_ev' => '',
            'edad_actual' => $paciente->edad,
            'contacto' => $paciente->telefono,
            'establecimiento' => $paciente->getEstablecimiento()
        );
        $i++;
    }
    //agendamiento
    $sql1 = "select * from historial_paciente 
                where tipo_historial='SALUD MENTAL' 
                and rut='$rut' order by fecha_registro desc limit 1";
    $row1 = mysql_fetch_array(mysql_query($sql1));
}

if($i>0){
    $data[] = array(
        'TotalRows' => ''.$i,
        'Rows' => $customers
    );
    echo json_encode($data);
}

?>
