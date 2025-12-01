<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';

$rut = str_replace('.','',$_POST['rut']);
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);

$paciente->definirEdadFecha($fecha_registro);
//echo $paciente->total_meses;
?>
<style type="text/css">

    .settings-section
    {

        height: 45px;
        width: 100%;

    }

    .settings-label
    {
        font-weight: bold;
        font-family: Sans-Serif;
        font-size: 14px;
        margin-left: 14px;
        margin-top: 15px;
        float: left;
    }

    .settings-setter
    {
        float: right;
        margin-right: 14px;
        margin-top: 8px;
    }
    textarea::placeholder{
        background-color: white;
        color: grey;;
    }
</style>

<div class="col l12">
    <strong style="color: red;">(*)</strong> Los cambios son guardados unicamente al momento de presionar el botón "REGISTRAR VDI"
</div>

<div class="col l4">
    <div class="col l12 s12 m12">
        <div class="card-panel" style="background-color: #2b85a2;color: white">
            <div class="row">
                <div class="col l12"><label style="color: white;">REGISTRO DE RESCATE - PACIENTE NANEA</label></div>
            </div>
            <div class="row">
                <div class="col l4"><label style="color: white;">FECHA REGISTRO</label></div>
                <div class="col l8"><input type="date" value="<?php echo $fecha_registro; ?>" name="fecha_rescate" id="fecha_rescate" /></div>
            </div>
            <div class="row">
                <div class="col l4"><label style="color: white;">OBSERVACIONES</label></div>
                <div class="col l8"><textarea id="obs_rescate" name="obs_rescate" placeholder="INDIQUE CAUSAL DE INASISTENCIA CONTROL ANTERIOR"></textarea></div>
            </div>
            <div class="row">
                <div class="col l12">
                    <input type="button" onclick="insertRescate_paciente()" value="REGISTRAR RESCATE" class="btn-large green" style="width: 100%;" />
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function insertRescate_paciente(){
        $.post('db/update/paciente_rescate.php', {
            rut: '<?php echo $rut; ?>',
            obs: $("#obs_rescate").val(),
            fecha_registro: $("#fecha_rescate").val()

        }, function (data) {
            alertaLateral(data);
            $('.tooltipped').tooltip({delay: 50});
        });
    }
</script>

