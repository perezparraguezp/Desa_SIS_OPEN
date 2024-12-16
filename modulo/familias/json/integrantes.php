<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

session_start();
$id = $_GET['id'];

$sql = "select * from integrante_familia inner join persona using(rut)
                where integrante_familia.id_familia='$id' 
                order by nombre_completo ";


$res = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_array($res)){
    $persona = new persona($row['rut']);



    $fecha_nac = new DateTime(date('Y/m/d', strtotime($row['fecha_nacimiento']))); // Creo un objeto DateTime de la fecha ingresada
    $fecha_hoy = new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy

    $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto


    $anios = $edad->format('%Y');
    $meses = $edad->format('%m');



    $customers[] = array(
        'rut' => $row['rut'],
        'editar' => $row['rut'],
        'parentesco' => $persona->parentesco,
        'nombre' => $row['nombre_completo'],
        'sexo' => $row['sexo'],
        'anio' => $anios,
        'meses' => $meses,
        'nacimiento' => fechaNormal($row['fecha_nacimiento']),
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
