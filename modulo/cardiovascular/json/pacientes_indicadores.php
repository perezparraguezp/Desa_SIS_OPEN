<?php
#Include the connect.php file
include("../../../php/config.php");
include("../../../php/objetos/persona.php");

$id_sector_interno = $_GET['id_sector_interno'];

$id_establecimiento = $_SESSION['id_establecimiento'];

$filtro = '';
$sql = "select * from paciente_establecimiento inner join paciente_pscv using(rut)
                where paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                and paciente_establecimiento.m_cardiovascular='SI'
                
                ";
$res = mysql_query($sql);
$i = 0;

while($row = mysql_fetch_array($res)){

    $paciente = new persona($row['rut']);

    if($paciente->existe==true){
        if($paciente->nombre!=''){
            $resumen_centro = $paciente->getEstablecimiento();
            $sql1 = "select * from parametros_pscv where rut='$paciente->rut' limit 1";

            $row1 = mysql_fetch_array(mysql_query($sql1));
            $imc = $row1['imc'];
            //PA
            if($row1['pa_fecha']==''){
                $sql11 = "select * from historial_parametros_pscv 
                    where rut='$paciente->rut' 
                    and indicador='pa' order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                $pa_fecha = $row11['fecha_registro'];
                mysql_query("update parametros_pscv set pa_fecha='$pa_fecha' 
                            where rut='$paciente->rut' ");
            }else{
                $pa_fecha = $row1['pa_fecha'];
            }
            //LDL
            if($row1['ldl_fecha']==''){
                $sql11 = "select * from historial_parametros_pscv 
                    where rut='$paciente->rut' 
                    and indicador='ldl' order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                $ldl_fecha = $row11['fecha_registro'];
                mysql_query("update parametros_pscv set ldl_fecha='$ldl_fecha' 
                            where rut='$paciente->rut' ");
            }else{
                $ldl_fecha = $row1['ldl_fecha'];
            }
            //RAC
            if($row1['rac_fecha']==''){
                $sql11 = "select * from historial_parametros_pscv 
                    where rut='$paciente->rut' 
                    and indicador='rac' order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                $rac_fecha = $row11['fecha_registro'];
                mysql_query("update parametros_pscv set rac_fecha='$rac_fecha' 
                            where rut='$paciente->rut' ");
            }else{
                $rac_fecha = $row1['rac_fecha'];
            }
            //VFG
            if($row1['vfg_fecha']==''){
                $sql11 = "select * from historial_parametros_pscv 
                    where rut='$paciente->rut' 
                    and indicador='vfg' order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                $vfg_fecha = $row11['fecha_registro'];
                mysql_query("update parametros_pscv set vfg_fecha='$vfg_fecha' 
                            where rut='$paciente->rut' ");
            }else{
                $vfg_fecha = $row1['vfg_fecha'];
            }
            $sql1 = "select * from paciente_pscv where rut='$paciente->rut' limit 1";
            $row1 = mysql_fetch_array(mysql_query($sql1));
            $riesgo_cv = $row1['riesgo_cv'];
            $hta = $row1['patologia_hta'];
            $dm = $row1['patologia_dm'];
            $dlp = $row1['patologia_dlp'];
            //HTA
            if($row1['hta_fecha']==''){
                $sql11 = "select * from historial_paciente 
                    where rut='$paciente->rut' 
                    and tipo_historial like '%patologia_hta con un valor SI%' 
                    order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                if($row11){
                    list($hta_fecha,$hora) = explode(" ",$row11['fecha_registro']);
                    mysql_query("update paciente_pscv set hta_fecha='$hta_fecha' 
                            where rut='$paciente->rut' ");
                }else{
                    $hta_fecha ='';
                }
            }else{
                $hta_fecha = $row1['hta_fecha'];
            }

            if($row1['dm_fecha']==''){
                $sql11 = "select * from historial_paciente 
                    where rut='$paciente->rut' 
                    and tipo_historial like '%patologia_dm con un valor SI%' 
                    order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                if($row11){
                    list($dm_fecha,$hora) = explode(" ",$row11['fecha_registro']);
                    mysql_query("update paciente_pscv set dm_fecha='$dm_fecha' 
                            where rut='$paciente->rut' ");
                }else{
                    $dm_fecha ='';
                }
            }else{
                $dm_fecha = $row1['dm_fecha'];
            }

            if($row1['dlp_fecha']==''){
                $sql11 = "select * from historial_paciente 
                    where rut='$paciente->rut' 
                    and tipo_historial like '%patologia_dlp con un valor SI%' 
                    order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                if($row11){
                    list($dlp_fecha,$hora) = explode(" ",$row11['fecha_registro']);
                    mysql_query("update paciente_pscv set dlp_fecha='$dlp_fecha' 
                            where rut='$paciente->rut' ");
                }else{
                    $dlp_fecha ='';
                }
            }else{
                $dlp_fecha = $row1['dlp_fecha'];
            }

            $sql1 = "select * from pscv_diabetes_mellitus where rut='$paciente->rut' limit 1";
            $row1 = mysql_fetch_array(mysql_query($sql1));
            $ev_pie = $row1['ev_pie'];
            $hba1c = $row1['hba1c'];
            $insulina = $row1['insulina'];
            $fondo_ojo = $row1['fondo_ojo'];
            //hba1c_fecha
            if($row1['hba1c_fecha']==''){
                $sql11 = "select * from historial_diabetes_mellitus 
                    where rut='$paciente->rut' 
                    and indicador='hba1c' 
                    order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                if($row11){
                    list($hba1c_fecha,$hora) = explode(" ",$row11['fecha_registro']);
                    mysql_query("update pscv_diabetes_mellitus set hba1c_fecha='$hba1c_fecha' 
                            where rut='$paciente->rut' ");
                }else{
                    $hba1c_fecha ='';
                }
            }else{
                $hba1c_fecha = $row1['hba1c_fecha'];
            }
            //$ev_pie_fecha
            if($row1['ev_pie_fecha']==''){
                $sql11 = "select * from historial_diabetes_mellitus 
                    where rut='$paciente->rut' 
                    and indicador='ev_pie' 
                    order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                if($row11){
                    list($ev_pie_fecha,$hora) = explode(" ",$row11['fecha_registro']);
                    mysql_query("update pscv_diabetes_mellitus set ev_pie_fecha='$ev_pie_fecha' 
                            where rut='$paciente->rut' ");
                }else{
                    $ev_pie_fecha ='';
                }
            }else{
                $ev_pie_fecha = $row1['hba1c_fecha'];
            }
            //$ev_pie_fecha
            if($row1['fondo_ojo_fecha']==''){
                $sql11 = "select * from historial_diabetes_mellitus 
                    where rut='$paciente->rut' 
                    and indicador='fondo_ojo' 
                    order by id_historial desc limit 1";

                $row11 = mysql_fetch_array(mysql_query($sql11));
                if($row11){
                    list($fondo_ojo_fecha,$hora) = explode(" ",$row11['fecha_registro']);
                    mysql_query("update pscv_diabetes_mellitus set fondo_ojo_fecha='$fondo_ojo_fecha' 
                            where rut='$paciente->rut' ");
                }else{
                    $fondo_ojo_fecha ='';
                }
            }else{
                $fondo_ojo_fecha = $row1['fondo_ojo_fecha'];
            }
            $sql1 = "select * from parametros_pscv where rut='$paciente->rut' limit 1";

            $row1 = mysql_fetch_array(mysql_query($sql1));

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
                    'pa' => strtoupper(limpiaCadena($row1['pa'])),
                    'electro' => fechaNormal($row1['ekg']),
                    'ldl' => ($row1['ldl']),
                    'erc' => strtoupper(limpiaCadena($row1['erc_vfg'])),
                    'rac' => strtoupper(limpiaCadena($row1['rac'])),
                    'vfg' => strtoupper(limpiaCadena($row1['vfg'])),
                    'imc' => strtoupper(limpiaCadena($row1['imc'])),
                    'pa_fecha' => fechaNormal($pa_fecha),
                    'ldl_fecha' => fechaNormal($ldl_fecha),
                    'rac_fecha' => fechaNormal($rac_fecha),
                    'vfg_fecha' => fechaNormal($vfg_fecha),
                    'riesgo_cv' => strtoupper(limpiaCadena($riesgo_cv)),
                    'hta' => strtoupper(limpiaCadena($hta)),
                    'dm' => limpiaCadena($dm),
                    'dlp' => limpiaCadena($dlp),
                    'hba1c' => strtoupper(limpiaCadena($hba1c)),
                    'hba1c_fecha' => fechaNormal($hba1c_fecha),
                    'ev_pie' => strtoupper(limpiaCadena($ev_pie)),
                    'ev_pie_fecha' => fechaNormal($ev_pie_fecha),
                    'fondo_ojo' => strtoupper(limpiaCadena($fondo_ojo)),
                    'fondo_ojo_fecha' => fechaNormal($fondo_ojo_fecha),
                    'insulina' => limpiaCadena($insulina),
                    'hta_fecha' => fechaNormal($hta_fecha),
                    'dm_fecha' => fechaNormal($dm_fecha),
                    'dlp_fecha' => fechaNormal($dlp_fecha),
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
