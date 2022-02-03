<?php
include '../../config.php';
include '../../objetos/mysql.php';
include '../../objetos/persona.php';

$mysq = new mysql($_SESSION['id_usuario']);


$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$nacimiento = $_POST['nacimiento'];
$sexo = $_POST['sexo'];
$pueblo = $_POST['pueblo'];
$nanea = $_POST['nanea'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$ficha = $_POST['ficha'];
$carpeta_familiar = $_POST['carpeta_familiar'];
$comuna = $_POST['comuna'];

//datos mamá
$rut_mama = $_POST['rut_mama'];
$nombre_mama = $_POST['nombre_mama'];
$nacimiento_mama = $_POST['nacimiento_mama'];
$telefono_mama = $_POST['telefono_mama'];
$mysq->insert_persona($rut_mama,$nombre_mama,$telefono_mama,'');
$mama = new persona($rut_mama);
$mama->updateFechaNacimiento($nacimiento);

//datos papá
$rut_papa = $_POST['rut_papa'];
$nombre_papa = $_POST['nombre_papa'];
$nacimiento_papa = $_POST['nacimiento_papa'];
$telefono_papa = $_POST['telefono_papa'];
$mysq->insert_persona($rut_papa,$nombre_papa,$telefono_papa,'');
$papa = new persona($rut_papa);
$papa->updateFechaNacimiento($nacimiento_papa);



$mysq->update_persona_column($rut,'nombre_completo',$nombre);
$mysq->update_persona_column($rut,'direccion',$direccion);
$mysq->update_persona_column($rut,'comuna',$comuna);
$mysq->update_persona_column($rut,'fecha_nacimiento',$nacimiento);
$mysq->update_persona_column($rut,'sexo',$sexo);
$mysq->update_persona_column($rut,'nanea',$nanea);
$mysq->update_persona_column($rut,'pueblo',$pueblo);
$mysq->update_persona_column($rut,'numero_ficha',$ficha);
$mysq->update_persona_column($rut,'carpeta_familiar',$carpeta_familiar);

$mysq->insert_paciente_establecimiento($rut);

$mysq->updatePapaMamaPaciente($rut,$rut_mama,$rut_papa);

echo 'PACIENTE ACTUALIZADO';