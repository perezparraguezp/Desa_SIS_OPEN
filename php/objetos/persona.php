<?php

/**
 * Created by PhpStorm.
 * User: iPapo
 * Date: 07-10-18
 * Time: 22:41
 */
class persona
{
    public $rut, $nombre, $telefono, $direccion, $email;
    public $edad, $sexo, $fecha_nacimiento;
    public $anios, $meses, $dias, $total_meses;
    public $edad_anios, $edad_meses, $edad_dias;
    public $myID, $myEstablecimiento, $pueblo, $nanea, $comuna, $migrante;
    public $ev_neurosensorial, $edad_total, $ultimo_historial,$rx_pelvis;
    public $eedp, $eedp_coordinacion, $eedp_motrocidad, $eedp_lenguaje, $eedp_social;
    public $tepsi, $tepsi_coordinacion, $tepsi_motrocidad, $tepsi_lenguaje;
    public $dental_cero, $dental_ges6;

    public $nombre_centro_medico, $nombre_sector_comunal, $nombre_sector_interno;
    public $id_region, $nombre_region, $id_provincia, $nombre_provincia, $id_comuna, $nombre_comuna;

    public $pt, $pe, $te, $imce, $dni, $lme, $pcint, $rimaln, $presion_arterial, $ira;
    public $perimetro_craneal,$obs_personal;
    public $eoa, $pku, $hc, $apego_inmediato, $vacuna_bcg,$semanas_gestacion;
    public $agudeza_visual, $evaluacion_auditiva,$parentesco;

    //datos padres
    public $rut_mama;
    public $rut_papa;
    public $sename,$ninez_2;


    public $existe, $ultima_actualizacion;

    function __construct($rut)
    {
        $rut = trim($rut);
        $this->rut = str_replace(".", "", $this->rut);
        $this->myID = $_SESSION['id_usuario'];
        $this->myEstablecimiento = $_SESSION['id_establecimiento'];
        $sql = "select * from persona 
                where upper(trim(rut))=upper(trim('$rut')) limit 1";


        $row = mysql_fetch_array(mysql_query($sql));

        if ($row) {
            $this->rut = strtoupper(trim($row['rut']));
            $this->nombre = limpiaCadena(strtoupper(trim($row['nombre_completo'])));
            $this->telefono = limpiaCadena($row['telefono']);
            $this->email = $row['email'];
            $this->direccion = limpiaCadena($row['direccion']);
            $this->fecha_nacimiento = $row['fecha_nacimiento'];
            $this->obs_personal = $row['obs_personal'];
            $this->parentesco = $row['parentesco'];
            if($this->fecha_nacimiento==''){

            }else{

            }

            $this->sexo = $row['sexo'];
            if($this->sexo==''){
                $this->sexo = '?';
            }
            $this->pueblo = $row['pueblo'];
            $this->migrante = $row['migrante'];
            $this->nanea = $row['nanea'];
            $this->comuna = $row['comuna'];

            $this->numero_ficha = $row['numero_ficha'];
            $this->carpeta_familiar = $row['carpeta_familiar'];

            $this->ultima_actualizacion = $row['ultima_actualizacion'];

            $this->sename = $row['sename'];
            $this->ninez = $row['ninez'];

            $this->semanas_gestacion = $row['semanas_gestacion'];

            list($fecha, $hora) = explode(" ", $this->ultima_actualizacion);
            $this->ultima_actualizacion = fechaNormal($fecha) . " [" . $hora . "]";
            $this->calcularEdad();
            $this->psicomotor();
            $this->dental();
            $this->getEstablecimiento();
            $this->getDatosComunas();
            $this->getUltimoHistorial();
            $this->load_DatosNacimiento();
            $this->existe = true;
        } else {
            $this->existe = false;
        }
    }

    function getModuloPaciente($modulo)
    {
        $sql = "select * from paciente_establecimiento where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $modulo = $row[$modulo];
            if ($modulo != '') {
                return $modulo;
            } else {
                return 'NO';
            }
        } else {
            return 'NO';
        }
    }

    function getPsicomotor($column){
        $sql = "select * from paciente_psicomotor where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return 'PENDIENTE';
        }
    }
    function getUltimoHistorial()
    {
        $sql1 = "select * from historial_paciente where rut='$this->rut' order by id_historial desc limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            list($fecha, $hora) = explode(" ", $row1['fecha_registro']);
            $this->ultimo_historial = $fecha;
        } else {
            $this->ultimo_historial = 'NUNCA';
        }
    }
    function getProximoControl(){
        $sql1 = "select * from agendamiento 
                where rut='$this->rut'
                and estado_control='PENDIENTE'
                order by id_agendamiento asc limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            return $row1['mes_proximo_control'].'-'.$row1['anio_proximo_control'];;
        } else {
            return 'SIN AGENDAR';;
        }
    }

    function getUltimaEval()
    {
        $sql = "select * from historial_paciente 
                where upper(rut)=upper('$this->rut') order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            list($fecha, $hora) = explode(" ", $row['fecha_registro']);
            return $fecha;
        } else {
            return 'PENDIENTE';
        }
    }

    function getDatosNacimiento($column)
    {
        $sql1 = "select * from datos_nacimiento
                            where rut='$this->rut' 
                            limit 1";

        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            return $row1[$column];
        } else {
            return 'S/R';
        }
    }

    function getDatosComunas()
    {
        $comuna = $this->comuna;
        $sql1 = "select regiones.id as id_region,
                        regiones.region as nombre_region,
                        provincias.id as id_provincia,
                        provincias.provincia as nombre_provincia,
                        comunas.id as id_comuna,
                        comunas.comuna as nombre_comuna 
                        from regiones 
                        inner join provincias on regiones.id=provincias.region_id 
                        inner join comunas on comunas.provincia_id=provincias.id 
                        where comunas.id='$comuna' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $this->id_region = $row1['id_region'];
            $this->nombre_region = $row1['nombre_region'];
            $this->id_provincia = $row1['id_provincia'];
            $this->nombre_provincia = $row1['nombre_provincia'];
            $this->id_comuna = $row1['id_comuna'];
            $this->nombre_comuna = $row1['nombre_comuna'];
        }

    }

    function getEdadEnAnios()
    {
        if ($this->edad_total != '' && $this->edad_total != 0) {
            return (int)($this->edad_total / 12);
        } else {
            return 0;
        }
    }

    function getContacto()
    {
        return 'Telefono: ' . $this->telefono;
    }

    function getNaneas()
    {
        return $this->nanea;
    }

    function getArrayCentroMedico()
    {
        $sql1 = "select * from paciente_establecimiento 
                  inner join sectores_centros_internos on id_sector=id_sector_centro_interno
                  inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                  inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal 
                  where paciente_establecimiento.rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $centro_medico = array(
                'nombre_centro_interno' => $row1['nombre_centro_interno'],
                'id_centro_interno' => $row1['id_centro_interno'],
                'nombre_sector_interno' => $row1['nombre_sector_interno'],
                'id_sector_centro_interno' => $row1['id_sector_centro_interno'],
                'id_sector_comunal' => $row1['id_sector_comunal'],
                'nombre_sector_comunal' => $row1['nombre_sector_comunal'],

            );
            return $centro_medico;
        } else {
            return null;
        }
    }

    function getArrayCiudad()
    {
        $sql1 = "select comunas.comuna as nombre_comuna,comunas.id as id_comuna,
                               provincias.provincia as nombre_provincia,provincias.id as id_provincia,
                               regiones.id as id_region, regiones.region as nombre_region
                        from persona
                        inner join comunas on persona.comuna=comunas.comuna
                        inner join provincias on comunas.provincia_id=provincias.id
                        inner join regiones on provincias.region_id=regiones.id 
                  where persona.rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $info = array(
                'id_comuna' => $row1['id_comuna'],
                'id_provincia' => $row1['id_provincia'],
                'id_region' => $row1['id_region'],
                'nombre_comuna' => $row1['nombre_comuna'],
                'nombre_provincia' => $row1['nombre_provincia'],
                'nombre_region' => $row1['nombre_region'],

            );
            return $info;
        } else {
            return null;
        }
    }

    function loadDatosPadres()
    {
        $sql = "select * from paciente_establecimiento
        where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $this->rut_mama = $row['rut_mama'];
            $this->rut_papa = $row['rut_papa'];
        }
    }

    function getEstablecimiento()
    {
        $rut = $this->rut;
        $sql = "select * from paciente_establecimiento
                inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal 
                where trim(paciente_establecimiento.rut)=trim('$rut') 
                limit 1";


        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sector_comunal = $row['nombre_sector_comunal'];
            $establecimiento = $row['nombre_centro_interno'];
            $sector_interno = $row['nombre_sector_interno'];

            $this->nombre_centro_medico = $establecimiento;
            $this->nombre_sector_comunal = $sector_comunal;
            $this->nombre_sector_interno = $sector_interno;

            return $establecimiento . ":[$sector_interno]:[$sector_comunal]";

        } else {
            return 'NO SE ENCUENTRA REGISTRADO EN NINGUN CENTRO';
        }
    }

    function getFechaUltimoControl()
    {
        $sql = "select * from historial_paciente 
                where rut='$this->rut' 
                order by fecha_registro desc limit 1;";
        $row = mysql_fetch_array(mysql_query($sql));
        list($fecha, $hora) = explode(" ", $row['fecha_registro']);
        return $fecha;
    }

    function addHistorial($texto, $tipo,$modulo)
    {
        $fecha_dias = $this->calcularEdadDias(date('Y-m-d'));
        $sql = "insert into historial_paciente(rut,texto,id_profesional,id_establecimiento,tipo_historial,edad_dias,modulo) 
                  values('$this->rut',upper('$texto'),'$this->myID','$this->myEstablecimiento','$tipo','$fecha_dias','$modulo')";
        mysql_query($sql);

    }

    function addHistorialEspecial($texto, $tipo, $fecha)
    {
        $fecha_dias = $this->calcularEdadDias($fecha);
        $sql = "insert into historial_paciente(rut,texto,id_profesional,id_establecimiento,tipo_historial,fecha_registro,edad_dias) 
                  values('$this->rut',upper('$texto'),'$this->myID','$this->myEstablecimiento','$tipo','$fecha','$fecha_dias')";
        mysql_query($sql);
    }

    function html_cardPersona($cargo)
    {
        echo '
            <div class="card-panel">
                <div class="row">
                    <strong>Cargo</strong><br />
                    ' . $cargo . '
                </div>
                <div class="row">
                    <strong>Nombre Completo</strong><br />
                    ' . $this->nombre . '
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="row">
                            <i class="mdi-maps-directions tiny"></i> Dirección: ' . $this->direccion . '
                        </div>
                        <div class="row">
                            <i class="mdi-notification-phone-in-talk tiny"></i> Teléfono: ' . $this->telefono . '
                        </div>
                        <div class="row">
                            <i class="mdi-communication-email tiny"></i> E-mail: ' . $this->email . '
                        </div>
                    </div>
                </div>
            </div>
            ';
    }

    function insert_contrato($rut, $contrato, $desde, $hasta, $horas, $establecimiento)
    {
        if ($hasta == 'INDEFINIDO') {
            $hasta = '';
            $indefinido = 'SI';
        } else {
            $indefinido = 'NO';
        }

        $sql = "insert into personal_establecimiento(rut,id_establecimiento,fecha_inicio,fecha_termino,horas_asignadas,indefinido,tipo_contrato) 
            values(upper('$rut'),'$establecimiento','$desde','$hasta','$horas','$indefinido','$contrato')";
        mysql_query($sql);
//        echo $sql;

        $sql1 = "select * from personal_establecimiento where rut=upper('$rut') order by id_profesional desc limit 1";
//        echo $sql1;
        $row = mysql_fetch_array(mysql_query($sql1));

        return $row['id_profesional'];

    }

    function getIDProfesional($rut, $establecimiento)
    {
        $sql = "select * from personal_establecimiento 
                            where rut='$rut' 
                            and id_establecimiento='$establecimiento' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return 0;
        } else {
            return $row['id_profesional'];
        }
    }

    function insertUsuario($rut, $id_establecimiento, $tipo, $profesional)
    {
        list($clave, $dv) = explode("-", $rut);
        $sql = "insert into usuarios(rut,tipo_usuario,id_profesional,clave,estado_usuario) 
            values(upper('$rut'),'$tipo','$profesional','$clave','ACTIVO')";
//        echo $sql;
        mysql_query($sql);
    }

    function updateNombre($nombre)
    {
        $sql = "update persona 
                  set nombre_completo=upper('$nombre'),ultima_actualizacion=now() 
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
        $this->nombre = strtoupper($nombre);
    }

    function updateTelefono($telefono)
    {
        $sql = "update persona 
                  set telefono=upper('$telefono'),ultima_actualizacion=now() 
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
        $this->telefono = strtoupper($telefono);
    }

    function updateEmail($email)
    {
        $sql = "update persona 
                  set email=upper('$email'),ultima_actualizacion=now() 
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
        $this->email = strtoupper($email);
    }

    function updateDireccion($direccion)
    {
        $sql = "update persona 
                  set direccion=upper('$direccion'),ultima_actualizacion=now() 
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
        $this->direccion = strtoupper($direccion);
    }

    function updateSexo($sexo)
    {
        $sql = "update persona 
                  set sexo=upper('$sexo'),ultima_actualizacion=now() 
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
        $this->sexo = strtoupper($sexo);
    }

    function updateFechaNacimiento($fecha)
    {
        $sql = "update persona 
                  set fecha_nacimiento='$fecha',ultima_actualizacion=now() 
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
        $this->fecha_nacimiento = strtoupper($fecha);

    }

    function calcularAtraso($plazo)
    {

        $fecha_vencimiento = date("Y-m-d", strtotime($this->fecha_nacimiento . ' ' . $plazo));

        $fecha_ven = new DateTime(date('Y/m/d', strtotime($fecha_vencimiento))); // Creo un objeto DateTime de la fecha ingresada
        $fecha_hoy = new DateTime(date('Y-m-d', time())); // Creo un objeto DateTime de la fecha de hoy

        $edad = date_diff($fecha_hoy, $fecha_ven); // La funcion ayuda a calcular la diferencia, esto seria un objeto

        $anios = $edad->format('%Y');
        $meses = $edad->format('%m');
        $dias = $edad->format('%d');

        $mensaje = '';
        if ($anios != '00') {
            $mensaje .= $anios . ' años ';
        }
        if ($meses != '00') {
            $mensaje .= $meses . ' meses y ';
        }
        if ($dias != '00') {
            $mensaje .= $dias . ' dias';
        }
        return $mensaje;

    }

    function calcularEdad()
    {
        if($this->fecha_nacimiento==''){
            $this->edad = 'S/R';
            $this->anios = 'S/R';
            $this->meses ='S/R';
            $this->dias = 'S/R';

            $this->edad_anios = 'S/R';
            $this->total_meses = 'S/R';
            $this->edad_meses = 'S/R';
            $this->edad_dias = 'S/R';
        }else{
            $fecha_nac = new DateTime(date('Y/m/d', strtotime($this->fecha_nacimiento))); // Creo un objeto DateTime de la fecha ingresada
            $fecha_hoy = new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy
            $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
            $this->edad = "{$edad->format('%Y')} años, {$edad->format('%m')} meses y {$edad->format('%d')} días.";
            $this->anios = $edad->format('%Y');
            $this->meses = $edad->format('%m');
            $this->dias = $edad->format('%d');

            $this->total_meses = (int)($this->edad * 12) + $this->meses;

            $this->updateEdadTotal($this->total_meses);
            $this->updateEdadTotal_dias($this->total_meses * 30);

            $meses = $this->total_meses;
            $this->edad_anios = (int)abs($meses / 12);
            $this->edad_meses = (int)abs($meses % 12);
            $dias = 0;
            $d = date('d');//dia actual
            list($a1, $m1, $d1) = explode("-", $this->fecha_nacimiento);

            if ($d > $d1) {//ya paso el mes
                $dias = $d - $d1;
            } else {
                $dias = abs(30 - $d1 - $d);
            }
            $this->edad_dias = $dias;
        }


    }

    function calcularEdadFecha($fecha_actual)
    {
        if($this->fecha_nacimiento!=''){
            $fecha_nac = new DateTime(date('Y/m/d', strtotime($this->fecha_nacimiento))); // Creo un objeto DateTime de la fecha ingresada
            $fecha_hoy = new DateTime(date('Y/m/d', strtotime($fecha_actual))); // Creo un objeto DateTime de la fecha registrada
            $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto

            $this->edad = "{$edad->format('%Y')} años, {$edad->format('%m')} meses y {$edad->format('%d')} días.";
            $this->anios = $edad->format('%Y');
            $this->meses = $edad->format('%m');
            $this->dias = $edad->format('%d');

            return $this->edad;
        }else{
            return 'S/R';
        }


    }

    function definirEdadFecha($fecha_actual){
        if($this->fecha_nacimiento!=''){
            $fecha_nac = new DateTime(date('Y/m/d', strtotime($this->fecha_nacimiento))); // Creo un objeto DateTime de la fecha ingresada
            $fecha_hoy = new DateTime(date('Y/m/d', strtotime($fecha_actual))); // Creo un objeto DateTime de la fecha registrada
            $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto

            $this->edad = "{$edad->format('%Y')} años, {$edad->format('%m')} meses y {$edad->format('%d')} días.";
            $this->anios = $edad->format('%Y');
            $this->meses = $edad->format('%m');
            $this->dias = $edad->format('%d');

            $this->total_meses = (int)($this->edad * 12) + $this->meses;

            $this->updateEdadTotal($this->total_meses);
            $this->updateEdadTotal_dias($this->total_meses * 30);

            $meses = $this->total_meses;
            $this->edad_anios = (int)abs($meses / 12);
            $this->edad_meses = (int)abs($meses % 12);
            $dias = 0;
            $d = date('d');//dia actual
            list($a1, $m1, $d1) = explode("-", $this->fecha_nacimiento);

            if ($d > $d1) {//ya paso el mes
                $dias = $d - $d1;
            } else {
                $dias = abs(30 - $d1 - $d);
            }
            $this->edad_dias = $dias;
        }else{
            $this->edad = 'S/R';
            $this->anios = 'S/R';
            $this->meses ='S/R';
            $this->dias = 'S/R';

            $this->edad_anios = 'S/R';
            $this->total_meses = 'S/R';
            $this->edad_meses = 'S/R';
            $this->edad_dias = 'S/R';
        }

    }

    function calcularEdadDias($fecha)
    {
        if($this->fecha_nacimiento!=''){
            $fecha_nacimiento = $this->fecha_nacimiento;
            $sql = "SELECT TIMESTAMPDIFF(DAY,'$fecha_nacimiento','$fecha' ) AS dias;";
            $row = mysql_fetch_array(mysql_query($sql));
            if ($row) {
                return $row['dias'];
            } else {
                return 0;
            }
        }else{
            return 0;
        }

    }

    function updateEdadTotal($edad)
    {
        $sql = "update persona 
                  set edad_total='$edad'  
                  where rut='$this->rut' 
                  limit 1";
        $this->total_meses = $edad;
        $this->edad_total = $edad;
        mysql_query($sql);
    }

    function updateEdadTotal_dias($dias)
    {
        $sql = "update persona 
                  set edad_total_dias='$dias'  
                  where rut='$this->rut' 
                  limit 1";
        mysql_query($sql);
    }

    function psicomotor()
    {
        $sql = "select * from paciente_psicomotor where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        $this->ev_neurosensorial = $row['ev_neurosensorial'];
        $this->rx_pelvis = $row['rx_pelvis'];
        $this->eedp = $row['eedp'];
        $this->eedp_lenguaje = $row['eedp_lenguaje'];
        $this->eedp_coordinacion = $row['eedp_coordinacion'];
        $this->eedp_motrocidad = $row['eedp_motrocidad'];
        $this->eedp_social = $row['eedp_social'];
        $this->tepsi = $row['tepsi'];
        $this->tepsi_coordinacion = $row['tepsi_coordinacion'];
        $this->tepsi_lenguaje = $row['tepsi_lenguaje'];
        $this->tepsi_motrocidad = $row['tepsi_motrocidad'];
    }

    function dental()
    {
        $sql = "select * from paciente_dental where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $this->dental_cero = $row['cero'];
            $this->dental_ges6 = $row['ges6'];
        } else {
            mysql_query("insert into paciente_dental(rut,ges,cero) values('$this->rut','NO','NO')");
            $this->dental_cero = 'NO';
            $this->dental_ges6 = 'NO';
        }

    }

    function getRutFormato()
    {
        list($rut, $dv) = explode('-', $this->rut);
        return number_format($rut, 0, '', '.') . "-" . $dv;
    }

    function validaNutricionista()
    {
        $id_profesional = $_SESSION['id_usuario'];
        $sql = "select * from personal_establecimiento where id_profesional='$id_profesional' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        $tipo = $row['tipo_contrato'];
        if ($tipo == 'NUTRICIONISTA') {
            return true;
        } else {
            return false;//cambiar
        }
        //return true;
    }

    function validaCERO()
    {
        if ($this->total_meses >= 6) {
            return true;
        } else {
            return false;
        }
    }

    function validaGES6()
    {
        if ($this->total_meses >= ((12 * 6))) {
            // 6 años y un mes
            return true;
        } else {
            return false;
        }
    }

    function validaPE()
    {
        if ($this->total_meses < (5 * 12)) {
            return true;//mostrar el formulario PE
        } else {
            return false; //no mostrar el formulario PE
        }
    }

    function validaPT()
    {
        if ($this->total_meses < (5 * 12)) {
            return true;//mostrar el formulario PE
        } else {
            return false; //no mostrar el formulario PE
        }

    }

    function validaTE()
    {
        return true;//para todas las edades

    }

    function validaIMCE()
    {
        if ($this->total_meses >= ((5 * 12) + 1)) {//5 años y un mes
            return true;
        } else {
            return false;
        }
    }

    function validaPCINT()
    {
        //menores de 5 años y un mes, es decir 5 años y 29 dias
        if ($this->total_meses >= (5 * 12)) {
            return true;//si mostrar este formulario
        } else {
            return false;//no mostrar este formulario
        }

    }

    function validaDNI()
    {
        return true;//para todas las edades
    }

    function validaTEPSI()
    {
        if ($this->total_meses >= (2 * 12)) { //DESDE LOS DOS AÑOS
            return true;//si mostrar este formulario
        } else {
            return false;
        }
    }

    function validaLME()
    {
        if ($this->total_meses <= 35) {
            return true;//si mostrar este formulario
        } else {
            return false;
        }
    }

    function validaRIMALNEXCESO()
    {

        if ($this->total_meses >= 4 && $this->total_meses <= 71) { //entre 4 meses a 5 años y 11 meses
            return true;//si mostrar este formulario
        } else {
            return false;
        }
    }

    function validaPRESIONARTERIAL()
    {

        if ($this->total_meses >= (3 * 12)) { //desde los 3 años
            return true;//si mostrar este formulario
        } else {
            return false;
        }
    }

    function validaIRA()
    {
        if ($this->total_meses < 13) {
            //para menores de 7 meses 29 dias
            return true;
        } else {
            return false;
        }
    }

    function validaPerimetroCraneal()
    {
        if ($this->total_meses < (3 * 12)) {
            return true;
        } else {
            return false;
        }
    }

    function valida_AgudezaVisual()
    {
        if ($this->total_meses >= (4 * 12)) {
            //para menores de 7 meses 29 dias
            return true;
        } else {
            return false;
        }
    }

    function getFormVacuna()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            if ($this->anios == 0) {
                if ($this->meses < 4) {
                    return '2';
                } else {
                    if ($this->meses < 6) {
                        return '4';
                    } else {
                        if ($this->meses < 12) {
                            return '6';
                        } else {
                            if ($this->meses < 18) {
                                return '12';
                            } else {
                                if ($this->meses >= 18) {
                                    return '18';
                                }
                            }
                        }
                    }
                }
            } else {
                return 'NO';
            }
        } else {
            return 'NO';
        }

    }

    function vacuna5Anios()
    {
        $sql = "select * from vacunas_paciente 
                  where rut='$this->rut' 
                  limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['5anios'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }
    function vacuna3Anios()
    {
        $sql = "select * from vacunas_paciente 
                  where rut='$this->rut' 
                  limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['3anios'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }

    function vacuna2M()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['2m'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }

    function vacuna4M()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['4m'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }

    function vacuna6M()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['6m'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }

    function vacuna12M()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['12m'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }

    function vacuna18M()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $v = $row['18m'];
            if ($v == '') {
                return 'NO';
            } else {
                return $v;
            }
        } else {
            return 'NO';
        }
    }
    function updateSQL($column, $value)
    {
        $sql = "update persona set $column='$value' where rut='$this->rut' limit 1";
        mysql_query($sql) or die('ERROR 1');
    }

    function loadAntropometria()
    {
        $sql = "select * from antropometria where rut='$this->rut' order by fecha_registro desc limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $this->pe = $row['PE'];
            $this->pt = $row['PT'];
            $this->te = $row['TE'];
            $this->dni = $row['DNI'];
            $this->pcint = $row['PCINT'];
            $this->imce = $row['IMC'];
            $this->lme = $row['LME'];
            $this->rimaln = $row['RIMALN'];
            $this->ira = $row['SCORE_IRA'];
            $this->perimetro_craneal = $row['perimetro_craneal'];
            $this->presion_arterial = $row['presion_arterial'];
            $this->agudeza_visual = $row['agudeza_visual'];
            $this->evaluacion_auditiva = $row['evaluacion_auditiva'];
        }
    }

    function getAntropometria($column)
    {
        $sql = "select * from antropometria where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $result = trim($row[$column]);
            if ($result == '') {
                $result = 'PENDIENTE';
            }
            return $result;
        } else {
            return 'PENDIENTE';
        }
    }

    function load_DatosNacimiento()
    {
        $sql = "select * from datos_nacimiento where rut='$this->rut'  limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $this->eoa = $row['EOA'];
            $this->pku = $row['PKU'];
            $this->hc = $row['HC'];
            $this->apego_inmediato = $row['APEGO_INMEDIATO'];
            $this->vacuna_bcg = $row['VACUNA_BCG'];
            $this->semanas_gestacion = $row['semanas_gestacion'];
        }
    }

    function vacunaALDIA()
    {
        return 'SI';
    }

    function update_Antropometria($column, $val, $fecha)
    {
        $sql1 = "select * from antropometria 
                  where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $sql2 = "update antropometria set $column='$val',fecha_sql=now(),
                      fecha_registro='$fecha' 
                      where rut='$this->rut' limit 1";

        } else {
            $sql2 = "insert into antropometria(rut,$column,fecha_registro) values('$this->rut','$val','$fecha')";
        }
        mysql_query($sql2);
        $this->hisotrialAntropometria($column, $val, $fecha);

        $this->addHistorial( 'SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $val . ' EN LA FECHA ' . $fecha,'ANTROPOMETRIA','INFANTIL');

    }

    function hisotrialAntropometria($column, $value, $fecha)
    {
        $fecha_dias = $this->calcularEdadDias($fecha);
        $sql2 = "insert into historial_antropometria(rut,indicador,valor,id_empleado,fecha_registro,edad_dias) 
                  values('$this->rut',upper('$column'),'$value','$this->myID','$fecha','$fecha_dias')";
        mysql_query($sql2);

        $texto = 'SE MODIFICO UN REGISTRO CORRESPONDIENTE A ' . $column . '=' . $value . ' EN LA FECHA ' . $fecha;
        $this->addHistorialEspecial($texto, 'ANTROPOMETRIA', $fecha);
    }

    function update_datosPersonal($colum, $value)
    {
        $sql2 = "update persona set $colum=upper('$value')  
                      where rut='$this->rut'  limit 1";

        mysql_query($sql2);
    }

    function update_DatosNacimiento($column, $val, $fecha)
    {
        $sql1 = "select * from datos_nacimiento 
                  where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $sql2 = "update datos_nacimiento set $column='$val'  
                      where rut='$this->rut'  limit 1";
        } else {
            $sql2 = "insert into datos_nacimiento(rut,$column) values('$this->rut','$val')";
        }
        mysql_query($sql2);

        $texto = 'SE MODIFICO UN REGISTRO EN LOS DATOS DE NACIMIENTO CORRESPONDIENTE A ' . $column . '=' . $val . ' EN LA FECHA ' . $fecha;
        $this->addHistorialEspecial($texto, 'DATOS DE NACIMIENTO', $fecha);
        $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $val . ' EN LA FECHA ' . $fecha,'DATOS DE NACIMIENTO', 'INFANTIL');
    }

    function update_presionArterial($val, $fecha)
    {
        $this->update_Antropometria('presion_arterial', $val, $fecha);

    }

    function update_scoreIRA($val)
    {
        $this->update_Antropometria('SCORE_IRA', $val, data('Y-m-d'));
    }

    function insertAntropometria($PE, $PT, $TE, $DNI, $IMCE, $PCINT, $LME, $RIMALN, $IRA, $fecha)
    {
        $sql = "insert into antropometria(PE,PT,TE,DNI,IMCE,PCINT,LME,RIMALN,SCORE_IRA,fecha_registro,id_profesional,id_establecimiento,rut) 
            values('$PE','$PT','$TE','$DNI','$IMCE','$PCINT','$LME','$RIMALN','$IRA','$fecha','$this->myID','$this->myEstablecimiento','$this->rut')";
        mysql_query($sql);
        //$this->addHistorial('SE REALIZO UN REGISTRO DE ANTROPOMETRIA','ANTROPOMETRIA');
    }

    //psicomotor
    function validarPsicomotor()
    {
        $sql1 = "select * from paciente_psicomotor 
                  where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {

        } else {
            $sql2 = "insert into paciente_psicomotor(rut) values('$this->rut')";
            mysql_query($sql2);
        }

    }

    function update_Psicomotor($column, $val, $fecha)
    {
        $sql1 = "select * from paciente_psicomotor 
                  where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            if ($val != '') {
                $sql2 = "update paciente_psicomotor set $column='$val' 
                      where rut='$this->rut' limit 1";
            } else {
                $sql2 = '';
            }
        } else {
            $sql2 = "insert into paciente_psicomotor(rut,$column) values('$this->rut','$val')";
        }
        mysql_query($sql2);
        $texto = 'SE MODIFICO UN REGISTRO CORRESPONDIENTE A ' . $column . '=' . $val . ' EN LA FECHA ' . $fecha;
        $this->update_historialPsicomotor($texto, $fecha, $column, $val);
        if ($column == 'eedp') {
            if ($val == '') {
                $sql3 = "update paciente_psicomotor set
                         eedp_lenguaje='',
                         eedp_motrocidad='',
                         eedp_coordinacion='',
                         eedp_social='' 
                         where rut='$this->rut' ";

                mysql_query($sql3);
                $sql4 = "delete from historial_psicomotor 
                         where 
                         rut='$this->rut' and fecha_registro='$fecha' 
                         and indicador like 'EEDP_%' ";
                mysql_query($sql4);
            }
        }
        if ($column == 'tepsi') {
            if ($val == '') {
                $sql3 = "update paciente_psicomotor set
                         tepsi_lenguaje='',
                         tepsi_motrocidad='',
                         tepsi_coordinacion='',
                         tepsi_social='' 
                         where rut='$this->rut' ";

                mysql_query($sql3);
                $sql4 = "delete from historial_psicomotor 
                         where 
                         rut='$this->rut' and fecha_registro='$fecha' 
                         and indicador like 'TEPSI_%' ";
                mysql_query($sql4);
            }
        }
        $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $val . ' EN LA FECHA ' . $fecha,'PSICOMOTOR', 'INFANTIL');
    }

    function update_historialPsicomotor($texto, $fecha_registro, $indicador, $valor)
    {
        $edad_paciente = $this->calcularEdadFecha($fecha_registro);
        $fecha_dias = $this->calcularEdadDias($fecha_registro);
        $sql3 = "insert into historial_psicomotor(id_profesional,fecha_registro,rut,indicador,valor_indicador,edad_paciente,edad_dias) 
                  values('$this->myID','$fecha_registro','$this->rut',upper('$indicador'),upper('$valor'),'$edad_paciente','$fecha_dias')";
        mysql_query($sql3);
        $texto .= ', LA EDAD DEL PACIENTE ES: ' . $edad_paciente;
        $this->addHistorialEspecial($texto, 'PSICOMOTOR', $fecha_registro);
    }

    function update_pautaBreve($val, $fecha)
    {
        $column = 'pauta_breve';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_ev_neurosensorial($val, $fecha)
    {
        $column = 'ev_neurosensorial';
        $this->update_Psicomotor($column, $val, $fecha);

    }

    function update_rx_pelvis($val, $fecha)
    {
        $column = 'rx_pelvis';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_eedp($val, $fecha)
    {
        $column = 'eedp';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_eedp_lenguaje($val, $fecha)
    {
        $column = 'eedp_lenguaje';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_eedp_coordinacion($val, $fecha)
    {
        $column = 'eedp_coordinacion';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_eedp_motrocidad($val, $fecha)
    {
        $column = 'eedp_motrocidad';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_eedp_social($val, $fecha)
    {
        $column = 'eedp_social';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_tepsi($val, $fecha)
    {
        $column = 'tepsi';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_tepsi_lenguaje($val, $fecha)
    {
        $column = 'tepsi_lenguaje';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_tepsi_coordinacion($val, $fecha)
    {
        $column = 'tepsi_coordinacion';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    function update_tepsi_motrocidad($val, $fecha)
    {
        $column = 'tepsi_motrocidad';
        $this->update_Psicomotor($column, $val, $fecha);
    }

    //dental
    function update_dental($column, $value, $fecha)
    {
        $sql1 = "select * from paciente_dental where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            if ($value != '') {
                $sql2 = "update paciente_dental set $column='$value' where rut='$this->rut' limit 1";
            } else {
                $sql2 = '';
            }

        } else {
            $sql2 = "insert into paciente_dental(rut,$column) values('$this->rut','$value')";
        }

        mysql_query($sql2);
        $this->addHistorialEspecial('SE REGISTRO UN CAMBIO EN LA INFORMACION DENTAL  ' . $column, 'DENTAL', $fecha);
        $this->insert_historial_dental($column, $value, $fecha);
        $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $value . ' EN LA FECHA ' . $fecha,'DENTAL', 'INFANTIL');

    }

    function insert_historial_dental($column, $value, $fecha)
    {
        $edad_dias = $this->calcularEdadDias($fecha);
        $sql = "insert into historial_dental(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$edad_dias')";
        mysql_query($sql);
    }

    function update_dental_ges6($val, $fecha)
    {
        $sql1 = "select * from paciente_dental where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            if ($val != '') {
                $sql2 = "update paciente_dental set ges6='$val' where rut='$this->rut' limit 1";
            } else {
                $sql2 = '';
            }

        } else {
            $sql2 = "insert into paciente_dental(rut,ges6) values('$this->rut','$val')";
        }
        mysql_query($sql2);
        $this->addHistorialEspecial('SE REGISTRO UN CAMBIO EN EL MODULO DENTAL GES6', 'DENTAL', $fecha);
        $this->insert_historial_dental('GES6', $val, $fecha);
        $this->addHistorial('SE REGISTRO UN CAMBIO EN GES6 con un valor ' . $val . ' EN LA FECHA ' . $fecha,'DENTAL', 'INFANTIL');
    }

    function update_dental_cero($val, $fecha)
    {
        $sql1 = "select * from paciente_dental where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            if ($val != '') {
                $sql2 = "update paciente_dental set cero='$val' where rut='$this->rut' limit 1";
            } else {
                $sql2 = '';
            }
        } else {
            $sql2 = "insert into paciente_dental(rut,cero) values('$this->rut','$val')";
        }
        mysql_query($sql2);
        $this->addHistorial('DENTAL', 'SE REGISTRO UN CAMBIO EN CERO, VALOR ' . $val . ' EN LA FECHA ' . $fecha,'INFANTIL');
        $this->addHistorialEspecial('SE REGISTRO UN CAMBIO EN EL MODULO DENTAL CERO, VALOR '.$val, 'DENTAL', $fecha);
        $this->insert_historial_dental('CERO', $val, $fecha);
    }

    function ultimoValorAntropometria($column)
    {
        $sql = "select * from antropometria 
                  where rut='$this->rut' and $column!='' 
                  order by fecha_registro desc limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql));

        if ($row1) {
            return $row1[$column];
        } else {
            return '';
        }
    }

    //vacunas
    function validaVacunas()
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));

        if ($row) {

            return true;
        } else {
            //no tiene vacunas registradas
            $sql1 = "insert into vacunas_paciente(rut) values('$this->rut') ";

        }

        mysql_query($sql1) or die(false);
        return true;
    }

    function update_vacuna($vacuna, $valor)
    {
        $sql = "select * from vacunas_paciente where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));

        if ($row) {

            //tiene vacunas registradas
            if ($valor != '') {
                $sql1 = "update vacunas_paciente set " . $vacuna . "=upper('$valor') WHERE rut='$this->rut' ";
            } else {
                $sql1 = '';
            }
            echo $sql1;

        } else {
            //no tiene vacunas registradas
            $sql1 = "insert into vacunas_paciente(" . $vacuna . ",rut) values('$valor','$this->rut')";
//            echo $sql1;
        }
        mysql_query($sql1) or die(false);
        return true;
    }

    //datos personales
    function getCentroMedico()
    {
        $sql = "select * from paciente_establecimiento
                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                  where paciente_establecimiento.rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return strtoupper($row['nombre_centro_interno'] . "[SECTOR: " . $row['nombre_sector_interno'] . "]");
        } else {
            return 'NO PERTENCE A NINGUN CENTRO MEDICO';
        }
    }

    function getSectorInterno()
    {
        $sql = "select * from paciente_establecimiento 
                  inner join centros_internos on id_centro_interno=centros_internos.id_establecimiento
                  inner join sectores_centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno 
                  where paciente_establecimiento.rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return strtoupper($row['nombre_sector_interno']);
        } else {
            return 'NO PERTENCE A NINGUN SECTOR INTERNO';
        }
    }

    function getPendiente($table, $indicador)
    {

        $sql1 = "select * from $table 
                 where rut='$this->rut' 
                 and $indicador!=''  
                 limit 1";

        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            return true;
        } else {
            return false;
        }
    }

    function getPendientes()
    {
        //validamos antropometria
        $sql1 = "select * from antropometria where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        $customers = array(
            'rut' => $this->rut,
            'nombre' => $this->nombre,
        );
        if ($row1) {
            if ($row1['PE'] == '') {
                if ($this->validaPE() == true) {
                    $customers[] = array(

                        'tipo' => 'ANTROPOMETRIA',
                        'indicador' => 'PE',
                        'edad_actual' => $this->edad,
                        'pendiente' => $this->calcularAtraso('+ 5 year'),
                        'profesional' => '',
                    );
                }
            }
        } else {
            $customers[] = array(
                'rut' => $this->rut,
                'nombre' => $this->nombre,
                'tipo' => 'ANTROPOMETRIA',
                'indicador' => 'TODOS',
                'edad_actual' => $this->edad,
                'pendiente' => '',
                'profesional' => '',
            );
        }

        return $customers;
    }

    //PSCV CARDIOVASCULAR
    function update_pscv($column, $value, $fecha)
    {
        if ($value != '') {
            if ($fecha != '') {
                $sql = "select * from paciente_pscv 
                where rut='$this->rut' limit 1";
                $row = mysql_fetch_array(mysql_query($sql));
                if ($row) {
                    $sql1 = "update paciente_pscv 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
                } else {
                    $sql1 = "insert into paciente_pscv(rut,$column) 
                        values('$this->rut',upper('$value'))";
                }
                mysql_query($sql1);
                $this->insert_historial_pscv($column, $value, $fecha);
                $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $value . ' EN LA FECHA ' . $fecha,'ATRIBUTOS PSCV', 'PSCV');
            }
        }

    }

    function update_diabetes_pscv($column, $value, $fecha)
    {
        if ($value != '') {
            if ($fecha != '') {
                $sql = "select * from pscv_diabetes_mellitus 
                where rut='$this->rut' limit 1";
                $row = mysql_fetch_array(mysql_query($sql));
                if ($row) {
                    $sql1 = "update pscv_diabetes_mellitus 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
                } else {
                    $sql1 = "insert into pscv_diabetes_mellitus(rut,$column) 
                        values('$this->rut',upper('$value'))";
                }
//                echo $sql1;
                mysql_query($sql1);
                $this->insert_historial_diabetes_pscv($column, $value, $fecha);
                $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $value . ' EN LA FECHA ' . $fecha,'PSCV DM', 'PSCV');
            }
        }

    }
    function update_parametro_pscv($column, $value, $fecha)
    {
        if ($value != '') {
            if ($fecha != '') {
                $sql = "select * from parametros_pscv 
                where rut='$this->rut' limit 1";

                $row = mysql_fetch_array(mysql_query($sql));
                if ($row) {
                    $sql1 = "update parametros_pscv 
                            set $column=upper('$value') ,".$column."_fecha='$fecha'
                            where rut='$this->rut' ";
                } else {
                    $sql1 = "insert into parametros_pscv(rut,$column,".$column."_fecha) 
                        values('$this->rut',upper('$value'),'$fecha')";
                }
                mysql_query($sql1);
                $this->insert_historial_parametro_pscv($column, $value, $fecha);
                $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $value . ' EN LA FECHA ' . $fecha,'PSCV PARAMETROS', 'PSCV');
            }
        }
    }


    function insert_historial_pscv($column, $value, $fecha)
    {
        $sql0 = "delete from historial_pscv 
                  where rut='$this->rut' 
                  and $column='$value' 
                  and fecha_registro='$fecha' ";
        mysql_query($sql0);
        mysql_query("delete from historial_pscv where fecha_registro='' OR fecha_registro is null ");
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_pscv(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";
            mysql_query($sql);
        }
    }

    function insert_historial_parametro_pscv($column, $value, $fecha)
    {
        $sql0 = "delete from historial_parametros_pscv 
        where rut='$this->rut' 
        and indicador='$column' 
        and fecha_registro='$fecha' ";
        mysql_query($sql0);
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_parametros_pscv(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";
            mysql_query($sql);
            $this->limpiarHistorial('historial_parametros_pscv');
        }
    }

    function limpiarHistorial($tabla)
    {
        $sql = "delete from $tabla where fecha_registro='0000-00-00' ";
        mysql_query($sql);
        $sql = "delete from $tabla where valor='' ";
        mysql_query($sql);
    }

    function insert_historial_diabetes_pscv($column, $value, $fecha)
    {
        $fecha_dias = $this->calcularEdadDias($fecha);
        $sql = "delete from historial_diabetes_mellitus 
                where rut='$this->rut' 
                and indicador='$column'
                and fecha_registro='$fecha'";

        mysql_query($sql);
        $sql = "insert into historial_diabetes_mellitus(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";
        mysql_query($sql);
        $this->limpiarHistorial('historial_diabetes_mellitus');
    }

    function getIndicadorPSCV($indicador)
    {
        $sql = "select * from paciente_pscv 
                where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $riesgo_cv = $row[$indicador];
            return $riesgo_cv;
        } else {
            return '';
        }
    }

    function getParametroPSCV($indicador)
    {
        $sql = "select * from parametros_pscv 
                where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $item = $row[$indicador];
            return $item;
        } else {
            return '';
        }
    }

    function getDiabetesPSCV($indicador)
    {
        $sql = "select * from pscv_diabetes_mellitus 
                where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $item = $row[$indicador];
            return $item;
        } else {
            return '';
        }
    }

    function getPSCV($atributo)
    {
        $sql = "select * from paciente_pscv 
                where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $item = $row[$atributo];
            return $item;
        } else {
            return '';
        }
    }

    function delete_registro_historial($table, $id)
    {
        $sql1 = "select * from $table where id_historial='$id' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $json = json_encode($row1);
            $sql2 = "delete from $table where id_historial='$id' limit 1";
            mysql_query($sql2);
            $sql3 = "insert into delete_table(id_profesional,table_sql,id,registro) 
                      values('$this->myID','$table','$id','$json')";
            mysql_query($sql3);
        }

    }

    //PROGRAMA MUJER
    function update_parametro_m($column, $value, $fecha)
    {
        $sql = "select * from paciente_mujer 
                where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update paciente_mujer 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
        } else {
            $sql1 = "insert into paciente_mujer(rut,$column) 
                        values('$this->rut',upper('$value'))";
        }
        mysql_query($sql1);

        $this->insert_historial_parametro_m($column, $value, $fecha);
    }

    function update_sexualidad_m($column, $value, $fecha)
    {
        $sql = "select * from paciente_mujer 
                where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update paciente_mujer 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
        } else {
            $sql1 = "insert into paciente_mujer(rut,$column) 
                        values('$this->rut',upper('$value'))";
        }


        mysql_query($sql1);

        $this->insert_historial_parametro_m($column, $value, $fecha);
    }

    function update_sexualidad_m_fertilidad($column, $value, $fecha)
    {
        $sql = "select * from practica_sexual_mujer 
                where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update practica_sexual_mujer 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
        } else {
            $sql1 = "insert into practica_sexual_mujer(rut,$column) 
                        values('$this->rut',upper('$value'))";
        }

        mysql_query($sql1);

        $this->insert_historial_parametro_m($column, $value, $fecha);
    }

    function insert_historial_parametro_m($column, $value, $fecha)
    {
        $sql0 = "delete from historial_parametros_m 
        where rut='$this->rut' 
          and indicador='$column' 
          and fecha_registro='$fecha' ";
        mysql_query($sql0);
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_parametros_m(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";

            mysql_query($sql);
            $this->limpiarHistorial('historial_parametros_am');
        }
    }

    function getParametro_M($column)
    {
        $sql = "select * from paciente_mujer where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return '';
        }
    }

    function getParametroTabla_M($tabla, $column)
    {
        $sql = "select * from $tabla where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return '';
        }
    }

    function getParametroGestacion_M($column, $id_gestacion)
    {
        $sql = "select * from gestacion_mujer 
                where rut='$this->rut' 
                  and id_gestacion='$id_gestacion' 
                limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return '';
        }
    }

    function getTotalGestaciones($tipo)
    {
        $sql = "select count(*) as total from gestacion_mujer 
                where rut='$this->rut' 
                and estado_gestacion='$tipo' 
                limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row['total'];
        } else {
            return 0;
        }
    }

    //ADULTO MAYOR
    function update_parametro_am($column, $value, $fecha)
    {
        $sql = "select * from paciente_adultomayor 
                where upper(rut)=upper('$this->rut') 
                limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update paciente_adultomayor 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
        } else {
            $sql1 = "insert into paciente_adultomayor(rut,$column) 
                        values('$this->rut',upper('$value'))";
        }
//        echo $sql1;
        mysql_query($sql1);
        $this->addHistorial('REGISTRO EN ' . $column . ' con el Valor ' . $value . ' en la fecha ' . $fecha,'ATRIBUTOS ADULTO MAYOR', 'ADULTO MAYOR');
        $this->insert_historial_parametro_am($column, $value, $fecha);

    }

    function update_parametro_ad($column, $value, $fecha)
    {
        $sql = "select * from paciente_adolescente 
                where rut='$this->rut' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update paciente_adolescente 
                            set $column=upper('$value') 
                            where rut='$this->rut' ";
        } else {
            $sql1 = "insert into paciente_adolescente(rut,$column) 
                        values('$this->rut',upper('$value'))";
        }

        mysql_query($sql1);

        $this->insert_historial_parametro_ad($column, $value, $fecha);
    }

    function update_riesgos_ad($column, $value, $fecha)
    {
        $sql = "select * from riesgo_adolescente 
                where rut='$this->rut' and id_tipo_riesgo='$value' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if (!$row) {
            $sql1 = "insert into riesgo_adolescente(rut,id_tipo_riesgo,estado_riesgo,edad_dias,fecha_registro) 
                        values('$this->rut',upper('$value'),'SI','$this->edad_total',current_date())";

        } else {
            $sql1 = "delete from riesgo_adolescente where rut='$this->rut' and id_tipo_riesgo='$value'";
        }
        mysql_query($sql1);
    }

    function getRiesgoAD($id)
    {
        $sql = "select * from riesgo_adolescente 
                where rut='$this->rut' and id_tipo_riesgo='$id' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return 'SI';
        } else {
            return 'NO';
        }
    }

    function update_consejeria_ad($column, $value, $amigable, $fecha)
    {
        $sql = "select * from consejerias_adolescente 
                where rut='$this->rut' and id_tipo_consejeria='$value' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if (!$row) {
            $sql1 = "insert into consejerias_adolescente(rut,id_tipo_consejeria,estado_consejeria,edad_dias,fecha_registro,amigable) 
                        values('$this->rut',upper('$value'),'SI','$this->edad_total',current_date(),'$amigable')";

        } else {
            $sql1 = "delete from consejerias_adolescente where rut='$this->rut' and id_tipo_consejeria='$value'";
        }

        mysql_query($sql1);
    }

    function update_conserjeria_ad_amigable($column, $value, $amigable, $fecha)
    {
        $sql1 = "update consejerias_adolescente 
                    set amigable='$amigable' 
                    where rut='$this->rut' 
                    and id_tipo_consejeria='$value'";
        mysql_query($sql1);
    }

    function getConsejeriaAD($id)
    {
        $sql = "select * from consejerias_adolescente 
                where rut='$this->rut' and id_tipo_consejeria='$id' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return 'SI';
        } else {
            return 'NO';
        }
    }

    function getConsejeriaAD_amigable($id)
    {
        $sql = "select * from consejerias_adolescente 
                where rut='$this->rut' and id_tipo_consejeria='$id' limit 1";

        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row['amigable'];
        } else {
            return '';
        }
    }

    function insert_historial_parametro_ad($column, $value, $fecha)
    {
        $sql0 = "delete from historial_parametros_ad 
                where rut='$this->rut' 
                  and indicador='$column' 
                  and fecha_registro='$fecha' ";
        mysql_query($sql0);
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_parametros_ad(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";

            mysql_query($sql);
            $this->limpiarHistorial('historial_parametros_am');
        }
    }

    function insert_historial_parametro_am($column, $value, $fecha)
    {
        $sql0 = "delete from historial_parametros_am 
                where rut='$this->rut' 
                  and indicador='$column' 
                  and fecha_registro='$fecha' ";

        mysql_query($sql0);
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_parametros_am(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";

            mysql_query($sql);

        }
    }

    function getParametro_AM($column)
    {
        $sql = "select * from paciente_adultomayor where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return '';
        }
    }

    function getParametro_AD($column)
    {
        $sql = "select * from paciente_adolescente where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return '';
        }
    }

    //mujer
    function getParametro_M_table($tabla, $column)
    {
        $sql = "select * from $tabla where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row[$column];
        } else {
            return 0;
        }
    }

    function update_mgestacion($id_gestacion, $column, $value, $fecha)
    {
        $sql = "update gestacion_mujer 
                            set $column=upper('$value')
                            where id_gestacion='$id_gestacion' 
                            and rut='$this->rut' ";

        mysql_query($sql);
        $this->insert_historial_m($column, $value, $fecha, $id_gestacion);

    }

    function insert_historial_m($column, $value, $fecha, $id_gestacion)
    {
        $sql0 = "delete from historial_gestacion_m 
                where rut='$this->rut' 
                  and indicador='$column' 
                  and fecha_registro='$fecha' ";
        mysql_query($sql0);//borramos en caso de modificar el mismo indicador la misma fecha
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_gestacion_m(rut,id_profesional,indicador,valor,fecha_registro,edad_dias,id_gestacion) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias','$id_gestacion')";

            mysql_query($sql);

        }
    }

    function insert_historial_m_obs($column, $value, $fecha, $id_gestacion, $obs)
    {
        $sql0 = "delete from historial_gestacion_m 
                where rut='$this->rut' 
                  and indicador='$column' 
                  and fecha_registro='$fecha' ";
        mysql_query($sql0);//borramos en caso de modificar el mismo indicador la misma fecha
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_gestacion_m(rut,id_profesional,indicador,valor,fecha_registro,edad_dias,id_gestacion,obs) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias','$id_gestacion',upper('$obs'))";
            mysql_query($sql);
//            echo $sql;

        }
    }

    function insertExamen_M($origen, $tipo, $fecha, $valor, $obs)
    {
        $sql = "insert into examen_mujer(rut,id_profesional,fecha_examen,origen_examen,tipo_examen,valor_examen,obs_examen) 
                values('$this->rut','$this->myID','$fecha','$origen','$tipo','$valor',upper('$obs'))";
        mysql_query($sql);

        $texto = "Se Registro un Examen de Tipo " . $tipo . " en la fecha " . fechaNormal($fecha) . " de origen " . $origen . ', Con Resultado ' . $valor;
        $this->addHistorial($texto, 'REGISTRO DE EXAMENES','MUJER');
    }

    function insertTALLER_CLIMATERIO_M($fecha, $obs)
    {
        $sql = "insert into talleres_climaterio(rut,id_profesional,fecha_taller,obs_taller) 
                values('$this->rut','$this->myID','$fecha',upper('$obs'))";
        mysql_query($sql);

        $texto = "Se Registro un taller en la fecha " . fechaNormal($fecha);
        $this->addHistorial($texto, 'REGISTRO DE TALLERES','MUJER');
    }

    function insert_pauta_mrs($fecha, $valor, $obs)
    {
        $sql = "insert into pauta_mrs(rut,id_profesional,fecha_pauta,estado_pauta,obs_pauta) 
                values('$this->rut','$this->myID','$fecha','$valor',upper('$obs'))";
        mysql_query($sql);
        $this->update_parametro_m('pauta_mrs', $valor, $fecha);

        $texto = "Se Registro una Evaluacion de Pauta MRS en la fecha " . fechaNormal($fecha);
        $this->addHistorial($texto, 'PAUTA MRS','MUJER');
    }

    function deletePautaMRS($id)
    {
        $sql = "delete from pauta_mrs where id_pauta='$id' limit 1";
        mysql_query($sql);
        $texto = "El profesional codigo #" . $this->myID . " elimino la Pauta MRS";
        $this->addHistorial($texto, 'PAUTA MRS','MUJER');
    }

    function deleteTallerClimaterio($id)
    {
        $sql = "delete from talleres_climaterio where id_taller='$id' limit 1";
        mysql_query($sql);
        $texto = "El profesional codigo #" . $this->myID . " elimino el Taller Educativo";
        $this->addHistorial($texto, 'REGISTRO DE TALLERES','MUJER');
    }

    function deleteHormonaReemplazo($id)
    {
        $sql = "delete from hormona_reemplazo_m where id_hormona='$id' limit 1";
        mysql_query($sql);
        $texto = "El profesional codigo #" . $this->myID . " elimino Hormona de Reemplazo";
        $this->addHistorial($texto, 'REGISTRO DE HORMONAS','MUJER');
    }

    function insert_hormona_reemplazo($tipo, $desde, $obs)
    {
        $sql = "insert into hormona_reemplazo_m(rut,id_profesional,fecha_desde,tipo_hormona,obs_hormona) 
                values('$this->rut','$this->myID','$desde','$tipo',upper('$obs'))";
        mysql_query($sql);

        $texto = "Se Registro una Evaluacion de Pauta MRS en la fecha " . fechaNormal($desde);
        $this->addHistorial($texto, 'REGISTRO DE HORMONAS','MUJER');
    }

    function deleteExamen_M($tipo, $id)
    {
        $sql = "delete from examen_mujer where id_examen='$id' and tipo_examen='$tipo' limit 1";
        mysql_query($sql);
        $texto = "El profesional codigo #" . $this->myID . " elimino el examen tipo " . $tipo;;
        $this->addHistorial($texto, 'REGISTRO DE EXAMENES','MUJER');
    }

    function getIdGestacion()
    {
        $sql = "select * from gestacion_mujer 
                    where rut='$this->rut' 
                    and (estado_gestacion='ACTIVA'  or estado_gestacion='NO ACTIVA' )
                    limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row['id_gestacion'];
        } else {
            return 0;
        }
    }

    function getEstadoGestacion($id)
    {
        $sql = "select * from gestacion_mujer 
                    where rut='$this->rut' 
                    and id_gestacion='$id'
                    limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            return $row['estado_gestacion'];
        } else {
            return 'NO ACTIVA';
        }
    }

    function crearGestacion()
    {
        $sql = "insert into gestacion_mujer(rut) values('$this->rut')";
        mysql_query($sql);
        $texto = 'SE CREA PROCESO DE GESTACION, EN LA FECHA '.date('d-m-Y');
        $this->addHistorial($texto, 'GESTACION','MUJER');
    }

    //SALUD MENTAL
    function hisotrial_SM_Antecedentes($column, $value, $fecha)
    {
        $sql0 = "delete from historial_antecedentes_sm
                where rut='$this->rut' 
                  and indicador='$column' 
                  and fecha_registro='$fecha' ";

        mysql_query($sql0);
        if ($fecha != '') {
            $fecha_dias = $this->calcularEdadDias($fecha);
            $sql = "insert into historial_antecedentes_sm(rut,id_profesional,indicador,valor,fecha_registro,edad_dias) 
                values('$this->rut','$this->myID','$column','$value','$fecha','$fecha_dias')";

            mysql_query($sql);

        }
    }

    function update_antecedentes_sm($column, $value, $fecha)
    {
        $sql1 = "select * from paciente_salud_mental 
                  where rut='$this->rut' limit 1";
        $row1 = mysql_fetch_array(mysql_query($sql1));
        if ($row1) {
            $sql2 = "update paciente_salud_mental 
                        set $column='$value',
                            ultimo_registro=now() 
                      where rut='$this->rut' limit 1";
        } else {
            $sql2 = "insert into paciente_salud_mental(rut,$column) values('$this->rut','$value')";
        }
        mysql_query($sql2);
        $this->hisotrial_SM_Antecedentes($column, $value, $fecha);
        $this->addHistorial('SE REGISTRO UN CAMBIO EN ' . $column . ' con un valor ' . $value . ' EN LA FECHA ' . $fecha,'PARAMETROS SALUD MENTAL', 'SALUD MENTAL');
    }

    function Alta_Antecedente($id, $fecha, $obs)
    {
        $sql = "update paciente_antecedentes_sm 
                set 
                    fecha_egreso='$fecha',
                    obs_egreso=upper('$obs')
                where id='$id'";

        mysql_query($sql);
        $this->addHistorial('SE DIO DE ALTA UN DIAGNOSTICO LA FECHA ' . $fecha,'ANTECEDENTES SALUD MENTAL', 'SALUD MENTAL');

    }

    function Alta_Diagnostico($id, $fecha, $obs)
    {
        $sql = "update paciente_diagnosticos_sm 
                set 
                    estado='ALTA',
                    fecha_egreso='$fecha',
                    obs_alta=upper('$obs')
                where id='$id'";
        mysql_query($sql);
        $this->addHistorial('SE DIO DE ALTA UN DIAGNOSTICO LA FECHA ' . $fecha,'DIAGNOSTICOS SALUD MENTAL', 'SALUD MENTAL');

    }

    function Alta_Farmaco($id, $fecha, $obs)
    {
        $sql = "update paciente_farmacos_sm 
                set 
                    estado_farmaco='ALTA',
                    fecha_egreso='$fecha',
                    obs_alta=upper('$obs')
                where id_registro='$id'";
        mysql_query($sql);
        $this->addHistorial('SE DIO DE ALTA UN FARMACO EN LA FECHA ' . $fecha,'FARMACOS SALUD MENTAL', 'SALUD MENTAL');
    }
    function buscarUltimoHisotiralPSCV($indicador){
        $sql = "select * from historial_pscv 
                        where trim(indicador)='$indicador' 
                        and rut='".$this->rut."'
                        order by  id_historial desc limit 1 ";
        $row = mysql_fetch_array(mysql_query($sql));
        if($row){
            return $row['fecha_registro'];
        }else{
            $sql = "select * from historial_parametros_pscv 
                            where trim(indicador)='$indicador' 
                            and rut='".$this->rut."'
                            order by  id_historial desc limit 1 ";
            $row = mysql_fetch_array(mysql_query($sql));
            if($row){
                return $row['fecha_registro'];
            }else{
                $sql = "select * from historial_diabetes_mellitus 
                            where trim(indicador)='$indicador' 
                            and rut='".$this->rut."'
                            order by  id_historial desc limit 1 ";
                $row = mysql_fetch_array(mysql_query($sql));
                if($row){
                    return $row['fecha_registro'];
                }else{
                    return '';
                }
            }
        }
    }

    function updateSM_Diagnostico($column,$valor,$fecha)
    {
        $column_fecha = $column."_fecha";
        $sql = "select * from sm_registros where rut='$this->rut' limit 1";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row) {
            $sql1 = "update sm_registros 
                        set $column='$valor', $column_fecha='$fecha',ultimo_control=now()
                        where rut='$this->rut' ";
        } else {
            //no tiene vacunas registradas
            $sql1 = "insert into sm_registros(rut,$column,$column_fecha,ultimo_control) 
                    values('$this->rut','$valor','$fecha',now()) ";

        }

        mysql_query($sql1) or die(false);
    }

    function addHistorial_SM_Diagnostico($texto){
        $sql1 = "insert into historial_sm_diagnostico(rut,texto,id_profesional) 
                    values('$this->rut',upper('$texto'),'$this->myID') ";

        mysql_query($sql1) or die(false);
    }


}