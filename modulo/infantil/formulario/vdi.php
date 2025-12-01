<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';

$rut = str_replace('.','',$_POST['rut']);
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);

$paciente->definirEdadFecha($fecha_registro);
$sql = "select * from historial_paciente
            inner join personal_establecimiento pe on historial_paciente.id_profesional = pe.id_profesional
            inner join persona on pe.rut=persona.rut
            where historial_paciente.rut='$paciente->rut' and tipo_historial='VID'
            order by historial_paciente.fecha_registro desc";

$res = mysql_query($sql);
$data = '';
$colores = Array('amber lighten-5','amber lighten-4');
$fila = 0;
while($row = mysql_fetch_array($res)){
    $color = $colores[$fila%2];
    $profesional = $row['nombre_completo'];
    list($fecha,$hora) = explode(" ",$row['fecha_registro']);

    $data .= '<div class="row container '.$color.'">
                    <div class="col l2">'.fechaNormal($fecha).'</div>
                    <div class="col l6">'.$row['texto'].'</div>
                    <div class="col l4">'.$profesional.'</div>
                </div>';
    $fila++;
}

?>
<script type="text/javascript">
    function insertVDI_paciente(){
        $.post('db/update/paciente_vdi.php', {
            rut: '<?php echo $rut; ?>',
            obs: $("#obs_vdi").val(),
            fecha_registro: $("#fecha_vdi").val()

        }, function (data) {
            alertaLateral(data);
            $('.tooltipped').tooltip({delay: 50});
            loadVDI_formulario('<?php echo $rut; ?>');
        });
    }
</script>
<div class="row">
    <div class="col l6">
        <div class="col l12 s12 m12">
            <div class="card-panel eh-open_fondo">
                <div class="row">
                    <div class="col l12"><label>INDICAR LA FECHA EN QUE REGISTRO LA VISITA DOMICILIARIA</label></div>
                </div>
                <div class="row">
                    <div class="col l4"><label>FECHA REGISTRO</label></div>
                    <div class="col l8"><input type="date" value="<?php echo $fecha_registro; ?>" name="fecha_vdi" id="fecha_vdi" /></div>
                </div>
                <div class="row">
                    <div class="col l4"><label>OBSERVACIONES</label></div>
                    <div class="col l8"><textarea id="obs_vdi" name="obs_vdi" placeholder="DEBERA INDICAR ALGUNA OBSERVACION DURANTE LA VISITA"></textarea></div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <input type="button" onclick="insertVDI_paciente()" value="REGISTRAR VDI" class="btn-large green" style="width: 100%;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col l6">
        <div class="card-panel">
            <div class="container">
                <div class="row amber container">
                    <div class="col l2">FECHA</div>
                    <div class="col l6">EVALUACION</div>
                    <div class="col l4">PROFESIONAL</div>
                </div>
                <?php echo $data; ?>
            </div>
        </div>
    </div>
</div>
