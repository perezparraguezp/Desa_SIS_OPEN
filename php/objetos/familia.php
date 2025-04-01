<?php

/**
 * Created by PhpStorm.
 * User: iPapo
 * Date: 07-10-18
 * Time: 22:41
 */
class familia
{
    public $existe,$id_profesional,$puntaje,$vdi_actual;
    public $id_familia, $codigo_familia,$valor_indicador,$plan_intervencion;
    public $nombre, $direccion, $id_sector, $observacion_familia, $integrantes,$estado_plan;
    public $nombre_establecimiento, $nombre_sector_comunal, $nombre_centro,$id_centro_medico;


    function __construct($id_familia)
    {
        $this->id_familia = $id_familia;

        $sql = "select * from familia
                    inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                    where id_familia='$id_familia' limit 1;";


        $row = mysql_fetch_array(mysql_query($sql));

        if ($row) {
            $this->nombre = $row['nombre_familia'];
            $this->id_centro_medico = $row['id_centro_interno'];
            $this->vdi_actual = $this->ultimoVDI();
            $this->puntaje = $this->calcularPuntaje();
            $this->plan_intervencion = $this->tienePlanVigente();

            $this->direccion = $row['direccion_familia'];
            $this->observacion_familia = $row['observacion_familia'];
            $this->estado_evaluacion = $row['estado_evaluacion'];
            $this->estado_general = $row['estado_general'];
            $this->codigo_familia = $row['codigo_familia'];
            $this->nombre_establecimiento = $row['nombre_centro_interno'];
            $this->nombre_centro = $row['nombre_sector_interno'];
            $this->nombre_sector_comunal = $row['nombre_sector_comunal'];
            $this->integrantes = $this->calcularIntegrantes();

            if($this->estado_general=='ALTO'){
                $this->valor_indicador=10;
            }else{
                if($this->estado_general=='MEDIO'){
                    $this->valor_indicador=50;
                }else{
                    if($this->estado_general=='BAJO'){
                        $this->valor_indicador=90;
                    }else{
                        $this->valor_indicador=10;
                    }
                }
            }
            $this->existe = true;
        } else {
            $this->existe = false;
        }
    }
    function getSQL($column){
        $sql = "select * from familia where id_familia='$this->id_familia' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));

        return $row[$column];
    }

    function updateSQL($column, $value)
    {
        $sql = "update familia set $column='$value' where id_familia='$this->id_familia' limit 1";
        mysql_query($sql) or die('ERROR updateSQL:'.$sql);
    }

    function calcularIntegrantes()
    {
        $sql1 = "select count(*) as total from integrante_familia where id_familia='$this->id_familia' group by id_familia limit 1";

        $row1 = mysql_fetch_array(mysql_query($sql1));
        $total = $row1['total'];
        return $total;
    }

    function indicador($valor)
    {
        $html = '
<style>
        

        /* Contenedor del semáforo */
        .semaforo {
            width: 30px;
            height: 100px;
            background-color: #333;
            border-radius: 20px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }

        /* Luces del semáforo */
        .light {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #555;
            transition: background-color 0.3s ease;
        }

        /* Colores de las luces encendidas */
        .redS.active {
            background-color: red;
        }

        .yellowS.active {
            background-color: yellow;
        }

        .greenS.active {
            background-color: green;
        }

    </style>
<!-- Contenedor del semáforo -->
<div class="semaforo">
    <div class="light redS" id="light-red"></div>
    <div class="light yellowS" id="light-yellow"></div>
    <div class="light greenS" id="light-green"></div>
</div>';
        $html .= "
        <script type='text/javascript'>
            function activarSemaforo(valor) {
                var luz = '';
                if(parseInt(valor)>=30){
                    
                    luz = 'red';
                }else{
                    if(parseInt(valor)>=20 && parseInt(valor)<30){
                        luz = 'yellow';
                    }else{
                        if(parseInt(valor)<20){
                            luz='green';
                        }else{
                            
                        }
                    }
                }
                
                // Apagar todas las luces
                $('.light').removeClass('active');
                // Encender la luz según el nivel de riesgo
                $('#light-' + luz).addClass('active');
            }
        activarSemaforo(".$this->puntaje.");
</script>
        ";

        return $html;
    }

    function info()
    {
        $html = '
<style type="text/css">
#info_familia strong{
font-size: 1em;
font-weight: bold;
color: #0D47A1;
}
</style>
            <div class="card-panel" id="info_familia">
                <div class="row">
                        <div class="col l0 center-align center">
                            '.$this->indicador($this->valor_indicador).'
                        </div>
                        <div class="col l4" style="padding-left: 15px;">
                            <div class="row">
                                <div class="col l12" style="height: 1.3em;">FAMILIA <strong>' . $this->nombre . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">Nº FAMILIA <strong>' . $this->codigo_familia . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">PUNTAJE <strong>' . $this->puntaje . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">PAUTA DE RIESGO <strong>' . $this->getSQL('estado_evaluacion') . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">VDI <strong>' . $this->vdi_actual . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">PLAN <strong>' . $this->plan_intervencion . '</strong></div>
                            </div>
                        </div>
                        <div class="col l2">
                            <div class="row">
                                <div class="col l12 right-align">
                                    <img src="images/map2.png" onclick="abrirMapa()" width="150" style="padding: 0px;position: relative;top: -15px;left: 0px;" />
                                </div>
                            </div>
                        </div>
                        <div class="col l4">
                            <div class="row">
                                <div class="col l12" style="height: 1.3em;">DIRECCIÓN: <strong>' . $this->direccion . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">SECTOR COMUNAL <strong>' . $this->nombre_sector_comunal . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">CENTRO MEDICO: <strong>' . $this->nombre_establecimiento . '</strong></div>
                                <div class="col l12" style="height: 1.3em;">SECTOR INTERNO: <strong>' . $this->nombre_centro . '</strong></div>
                              </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col l6">
                        <button style="width: 100%;height: 30px;line-height: 20px;"
                                onclick="boxEditarFamilia('.$this->id_familia.')" class="btn-large open_principal white-text">
                                <i class="mdi-image-edit right " style="font-size: 0.9em;"></i> EDITAR FAMILIA
                         </button>
                    </div>        
                    <div class="col l6">
                    <button style="width: 100%;height: 30px;line-height: 20px;"
                            onclick="boxEditarUbicacionFamilia(\''.$this->id_familia.'\')"
                            class="btn-large open_principal white-text">
                        <i class="mdi-maps-map right" style="font-size: 0.9em;"></i> EDITAR UBICACION
                    </button>
                </div>        
                </div>
            </div>
        ';
        return $html;
    }

    function historialVDI()
    {
        $html = '
            <div class="row blue lighten-3">
                <div class="col l1">-</div>
                <div class="col l2">FECHA</div>
                <div class="col l8">PROFESIONAL</div>
                <div class="col l1">INFO</div>
            </div>';
        $sql = "select * from historial_vdi_familia
                inner join personal_establecimiento using(id_profesional)
                inner join persona on personal_establecimiento.rut=persona.rut
                where id_familia='$this->id_familia'
                order by fecha_registro desc";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            $html .= '<div class="row">
                        <div class="col l12">
                            <div class="row">
                                <div class="col l1"><i style="cursor: pointer;" onclick="deleteVDI('.$row['id_registro'].')" class="mdi-action-delete tiny red-text"></i> </div>
                                <div class="col l2"><strong>' . fechaNormal($row['fecha_registro']) . '</strong></div>
                                <div class="col l8"><strong>' . $row['nombre_completo'] . '</strong></div>
                                <div class="col l1 center-align"><i style="cursor:help;;"  onclick="alert(\''.$row['comentario'].'\')" class="mdi-communication-message tiny blue-text"></i> </div>
                            </div>
                        </div>
                </div>';
        }
        return $html;

    }
    function historialPautaRiesgo()
    {
        $html = '
            <div class="row blue lighten-3">
                <div class="col l1">-</div>
                <div class="col l2">FECHA</div>
                <div class="col l2">ESTADO</div>
                <div class="col l6">PROFESIONAL</div>
                <div class="col l1">INFO</div>
            </div>';
        $sql = "select * from historial_pauta_riesgo_familia
                inner join personal_establecimiento using(id_profesional)
                inner join persona on personal_establecimiento.rut=persona.rut
                where id_familia='$this->id_familia'
                order by fecha_registro desc";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            $html .= '<div class="row">
                        <div class="col l12">
                            <div class="row">
                                <div class="col l1"><i style="cursor: pointer;" onclick="deletePautaRiesgo('.$row['id_registro'].')" class="mdi-action-delete tiny red-text"></i> </div>
                                <div class="col l2"><strong>' . fechaNormal($row['fecha_registro']) . '</strong></div>
                                <div class="col l2"><strong>' . $row['estado'] . '</strong></div>
                                <div class="col l6"><strong>' . $row['nombre_completo'] . '</strong></div>
                                <div class="col l1 center-align"><i style="cursor:help;;"  onclick="alert(\''.$row['comentario'].'\')" class="mdi-communication-message tiny blue-text"></i> </div>
                            </div>
                        </div>
                </div>';
        }
        return $html;

    }
    function historialPlanIntervencion(){
        $html = '
            <div class="row blue lighten-3">
                <div class="col l1">-</div>
                <div class="col l2">FECHA</div>
                <div class="col l6">PROFESIONAL</div>
               
                <div class="col l3">ESTADO</div>
            </div>';
        $sql = "select * from historial_plan_intervencion_familia
                inner join personal_establecimiento using(id_profesional)
                inner join persona on personal_establecimiento.rut=persona.rut
                where id_familia='$this->id_familia'
                order by fecha_registro desc";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            if($row['estado']=='VIGENTE'){
                $icono='mdi-navigation-refresh tiny blue-text';
            }else{
                $icono='mdi-notification-event-available tiny green-text';
            }
            $html .= '<div class="row">
                        <div class="col l12">
                            <div class="row">
                                <div class="col l1"><i style="cursor: pointer;" onclick="deletePlanIntervencion('.$row['id_registro'].')" class="mdi-action-pageview tiny black-text"></i> </div>
                                <div class="col l2"><strong>' . fechaNormal($row['fecha_registro']) . '</strong></div>
                                <div class="col l6"><strong>' . $row['nombre_completo'] . '</strong></div>
                                
                                <div class="col l3"><i style="cursor:help;;"  onclick="alert(\''.$row['nombre_completo'].'\')" class="'.$icono.'"></i> '.$row['estado'].'</div>
                            </div>
                        </div>
                </div>';
        }
        return $html;
    }

    function updateParametroFamilia($columna,$valor,$fecha){
        $sql = "select * from parametros_familia 
                where id_familia='$this->id_familia' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update parametros_familia 
                            set $columna=upper('$valor') 
                            where id_familia='$this->id_familia' ";
        } else {
            $sql1 = "insert into parametros_familia(id_familia,$columna) 
                        values('$this->id_familia',upper('$valor'))";
        }
        mysql_query($sql1);
        $this->insertHistorialParametrosFamilia($columna, $valor, $fecha);
    }
    function insertHistorialParametrosFamilia($column,$valor,$fecha){
        $texto = str_replace("_"," ",$column).' ->  '.$valor;
        $sql1 = "insert into historial_parametros_familia(id_familia,fecha_registro,id_profesional,texto) 
                        values('$this->id_familia','$fecha','$this->id_profesional',upper('$texto'))";
        mysql_query($sql1);
    }
    function estadoFamilia(){
        $sql = "select * from historial_pauta_riesgo_familia
                where id_familia='$this->id_familia'
                order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        $this->estado_evaluacion = $row['estado'];
        if($this>$this->estado_evaluacion==''){
            $this->estado_evaluacion = 'SIN EVALUACION';
        }

        return $this->estado_evaluacion;
    }
    function ultimoVDI(){
        $sql = "select * from historial_vdi_familia
                where id_familia='$this->id_familia'
                and fecha_registro<current_date()
                order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if($row){
            if($row['fecha_registro']!=''){
                $fecha_nac = new DateTime(date('Y/m/d', strtotime($row['fecha_registro']))); // Creo un objeto DateTime de la fecha ingresada
                $fecha_hoy = new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy
                $edad = date_diff($fecha_hoy, $fecha_nac);
                $anios = $edad->format('%Y');
                if($anios<=2){
                    //menor a 2 años
                    return 'VIGENTE';
                }else{
                    //mayor a 2 años
                    return 'NO VIGENTE';
                }
            }else{
                //no quedo una fecha de registro valida
                return 'SIN VDI';
            }

        }else{
            return 'SIN VDI';
        }

    }
    function calcularPuntaje(){
        $sql = "select * from historial_pauta_riesgo_familia
                where id_familia='$this->id_familia'                
                order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if($row){
            if($row['estado']=='MEDIO'){
                $puntaje = 20;
            }else{
                if($row['estado']=='ALTO'){
                    $puntaje = 30;
                }else{
                    $puntaje = 10;
                }
            }

        }else{
            $puntaje = 0;
        }

        $sql1= "select * from registro_trazadores_familia where id_familia='$this->id_familia' order by fecha_registro desc limit 1";
        $res1 = mysql_query($sql1);
        $i = 0;
        while ($row1 = mysql_fetch_array($res1)) {

            $trazadores = explode(";", $row1['trazadores']);

            foreach ($trazadores as $j => $id_trazador) {
                if ($id_trazador != '') {
                    $sql2 = "select * from trazadores_familia where id_trazador='$id_trazador' limit 1";

                    $row2 = mysql_fetch_array(mysql_query($sql2));

                    $puntaje += $row2['puntaje_trazador'];
                }
            }
        }


        $this->updateSQL('puntaje',$puntaje);
        if($puntaje==10){
            $evaluacion = 'RIESGO BAJO';
        }else{
            if($puntaje>10 && $puntaje<20){
                $evaluacion = 'RIESGO BAJO CON TRAZADORES';
            }else{
                if($puntaje==20){
                    $evaluacion = 'RIESGO MEDIO';
                }else{
                    if($puntaje>20 && $puntaje<30){
                        $evaluacion = 'RIESGO MEDIO CON TRAZADORES';
                    }else{
                        if($puntaje==30){
                            $evaluacion = 'RIESGO ALTO';
                        }else{
                            if($puntaje>30){
                                $evaluacion = 'RIESGO ALTO CON TRAZADORES';
                            }else{
                                $evaluacion = 'SIN EVALUACION';
                            }
                        }
                    }
                }
            }
        }
        $this->updateSQL('estado_evaluacion',$evaluacion);
        return $puntaje;
    }
    function insertTrazador($trazadores,$fecha,$obs){
        $sql1 = "select * from registro_trazadores_familia where id_familia='$this->id_familia' and fecha_registro='$fecha' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if($row1){
            //existe registro en la fecha indicada
            $sql2 = "delete from registro_trazadores_familia where id_familia='$this->id_familia' and fecha_registro='$fecha' ";
            mysql_query($sql2);
        }


        $sql = "insert into registro_trazadores_familia(id_familia,fecha_registro,id_profesional,trazadores,observaciones) 
                values('$this->id_familia','$fecha','$this->id_profesional','$trazadores',upper('$obs'))";
        mysql_query($sql);
        $this->addHistorialFamilia($fecha,'SE REGISTRARON TRAZADORES NUEVOS: '.$trazadores);
    }
    function addHistorialFamilia($fecha,$texto){
        $sql1 = "insert into historial_familia(id_familia,fecha_registro,id_profesional,texto) 
                        values('$this->id_familia','$fecha','$this->id_profesional',upper('$texto'))";
        mysql_query($sql1);
    }
    function tienePlanVigente(){
        $sql1 = "select * from historial_plan_intervencion_familia 
                    where id_familia='$this->id_familia' 
                    and estado='VIGENTE' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if($row1){
            $this->updateSQL('plan_intervencion','VIGENTE');
            return 'VIGENTE';
        }else{
            $sql1 = "select * from historial_plan_intervencion_familia 
                    where id_familia='$this->id_familia' 
                     and estado='EGRESADO' limit 1";
            $row1 = mysql_fetch_array(mysql_query($sql1));
            if($row1){
                $this->updateSQL('plan_intervencion','EGRESADO');
                return 'EGRESADO';
            }else{
                return 'SIN PLAN';
            }
        }

    }

    function getFechaPlanIntv(){
        $sql = "select * FROM historial_plan_intervencion_familia
        where id_familia='".$this->id_familia."' 
        and estado='VIGENTE' 
        order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if($row){
            return $row['fecha_registro'];
        }else{
            return '';
        }
    }

    function getFechaVDI(){
        $sql = "select * FROM historial_vdi_familia
        where id_familia='".$this->id_familia."' 
        order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if($row){
            return $row['fecha_registro'];
        }else{
            return '';
        }
    }

    function getFechaPautaRiesgo(){
        $sql = "select * FROM historial_pauta_riesgo_familia
        where id_familia='".$this->id_familia."' 
        order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if($row){
            return $row['fecha_registro'];
        }else{
            return '';
        }
    }


}
