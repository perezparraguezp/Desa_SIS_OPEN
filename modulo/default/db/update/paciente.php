<?php
include '../../../../php/config.php';
include '../../../../php/objetos/mysql.php';
include '../../../../php/objetos/persona.php';

$mysq = new mysql($_SESSION['id_usuario']);
$id_establecimiento = $_SESSION['id_establecimiento'];

$rut = $_POST['rut_old'];
$rut_new = str_replace(".","",$_POST['rut']);

$id_sector_centro = $_POST['id_sector_centro'];
$id_centro = $_POST['id_centro'];
$nombre = $_POST['nombre'];
$nacimiento = $_POST['nacimiento'];
$sexo = $_POST['sexo'];
$pueblo = $_POST['pueblo'];
$nanea = $_POST['naneas'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$ficha = $_POST['ficha'];
$carpeta_familiar = $_POST['carpeta_familiar'];
$comuna = $_POST['comuna'];
$modulos = $_POST['modulo'];
$estado_paciente = $_POST['estado_paciente'];
$complejidad = $_POST['complejidad'];

$ninez = $_POST['sename'];
$sename = $_POST['ninez'];

$sql = "update paciente_establecimiento set estado_registro='$estado_paciente',complejidad='$complejidad' 
                    where id_establecimiento='$id_establecimiento' 
                    and rut='$rut'";
echo $sql;
mysql_query($sql);


//datos mamá
$rut_mama = str_replace(".","",$_POST['rut_mama']);
$nombre_mama = $_POST['nombre_mama'];
$nacimiento_mama = $_POST['nacimiento_mama'];
$telefono_mama = $_POST['telefono_mama'];
$mysq->insert_persona($rut_mama,$nombre_mama,$telefono_mama,'');
$mama = new persona($rut_mama);
$mama->updateFechaNacimiento($nacimiento);

//datos papá
$rut_papa = str_replace(".","",$_POST['rut_papa']);
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
$mysq->update_persona_column($rut,'email',$email);
$mysq->update_persona_column($rut,'telefono',$telefono);

$mysq->update_persona_column($rut,'sename',$sename);
$mysq->update_persona_column($rut,'ninez',$ninez);



$mysq->updatePapaMamaPaciente($rut,$rut_mama,$rut_papa);

//datos modulos
//limpiamos los modulos del paciente
$mysq->limpiarModulos($rut);

$modulos = $_POST['modulo'];
foreach ($modulos as $i => $menu){
    $mysq->updateModuloPaciente($rut,$menu,'SI');
}

$mysq->updateRUTPaciente($rut,$rut_new);
$mysq->insert_paciente_establecimiento($rut_new,$id_sector_centro);





echo 'PACIENTE ACTUALIZADO';