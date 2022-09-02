<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

$tipo = $_GET['tipo'];

$filtro_tipo = '';
if($tipo!='TODOS'){
    if($tipo=='CARDIOVASCULAR'){
        $filtro_tipo = " and m_cardiovascular='SI' ";
    }else{
        if($tipo=='INFANTIL'){
            $filtro_tipo = " and m_infancia='SI' ";
        }else{
            if($tipo=='ADOLESCENTE'){
                $filtro_tipo = " and m_adolescente='SI' ";
            }else{
                if($tipo=='ADULTO MAYOR'){
                    $filtro_tipo = " and m_adulto_mayor='SI' ";
                }else{
                    if($tipo=='DE LA MUJER'){
                        $filtro_tipo = " and m_mujer='SI' ";
                    }else{
                        if($tipo=='SALUD MENTAL'){
                            $filtro_tipo = " and m_salud_mental='SI' ";
                        }else{
                            if($tipo=='SIN ASIGNAR'){
                                $filtro_tipo = "and (
                                                      m_salud_mental='NO'
                                                      AND m_mujer='NO'
                                                      AND m_adulto_mayor='NO'
                                                      AND m_adolescente='NO'
                                                      AND m_infancia='NO'
                                                      AND m_cardiovascular='NO')
                                                      ";
                            }
                        }
                    }
                }
            }
        }
    }
}else{
    $filtro_tipo = " and (
    m_salud_mental='SI' 
    or m_mujer='SI' 
    or m_adulto_mayor='SI' 
    or m_adolescente='SI' 
    or m_infancia='SI' 
    or m_cardiovascular='SI') ";
}
$id_establecimiento = $_SESSION['id_establecimiento'];


$sql = "select * from persona 
                    inner join paciente_establecimiento on persona.rut=paciente_establecimiento.rut 
                     where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                     and persona.fecha_nacimiento!='' 
                     $filtro_tipo 
                     group by persona.rut";
//echo $sql;
$res = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($res)){
//    echo $row['rut'].'<- ultimo<br />';
    $paciente = new persona($row['rut']);
//    echo $paciente->rut;
    if($paciente->existe==true){

        $meses = $paciente->total_meses;
        $anios = (int)abs($meses/12);
        $meses = (int)abs($meses%12);
        $dias = 0;
        $d = date('d');//dia actual
        list($a1,$m1,$d1) =explode("-",$paciente->fecha_nacimiento);

        if($d > $d1){//ya paso el mes
            $dias = $d-$d1;
        }else{
            $dias = abs(30-$d1-$d);
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
            'establecimiento' => strtoupper($paciente->nombre_centro_medico),
            'sector_comunal' => strtoupper($paciente->nombre_sector_comunal),
            'sector_interno' => strtoupper($paciente->nombre_sector_interno),
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

}

if($i>0){
    $data[] = array(
        'TotalRows' => ''.$i,
        'Rows' => $customers
    );
    echo json_encode($data);
}

?>
