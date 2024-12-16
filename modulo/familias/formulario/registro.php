<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';
include '../../../php/objetos/familia.php';
$rut = str_replace('.', '', $_POST['rut']);

$fecha_registro = $_POST['fecha_registro'];
$id_familia = $_POST['id_familia'];

$familia = new familia($id_familia);



?>
<script type="text/javascript">


</script>
<input type="hidden" name="rut" value="<?php echo $rut; ?>"/>
<input type="hidden" name="fecha_registro" id="fecha_registro" value="<?php echo $fecha_registro; ?>"/>
<div class="row">
    <div class="col l4">
        <div class="card-panel  indigo lighten-5" style="padding-top: 10px;padding-bottom: 10px;">
            <div class="row">
                <div class="col l10">
                    <header>VDI (Visita Domiciliaria Integral)</header>
                </div>
                <div class="col l2" style="cursor: pointer;">
                    <div onclick="boxNuevoVDI()" class="blue lighten-4 center-align"><i class="mdi-content-add-box"></i> INGRESAR VDI</div>
                </div>
            </div>
            <?php
                echo $familia->historialVDI();
            ?>
        </div>
    </div>
    <div class="col l4">
        <div class="card-panel  indigo lighten-5" style="padding-top: 10px;padding-bottom: 10px;">
            <div class="row">
                <div class="col l10">
                    <header>PAUTAS DE RIESGO</header>
                </div>
                <div class="col l2">
                    <div onclick="boxNuevoPautaRiesgo()" class="blue lighten-4 center-align"><i class="mdi-content-add-box"></i> INGRESAR PAUTA</div>
                </div>
            </div>
            <?php
                echo $familia->historialPautaRiesgo();
            ?>
        </div>
    </div>
    <div class="col l4">
        <div class="card-panel  indigo lighten-5" style="padding-top: 10px;padding-bottom: 10px;">
            <div class="row">
                <div class="col l10">
                    <header>PLAN DE INTERVENCIÓN</header>
                </div>
                <div class="col l2">
                    <div onclick="boxNuevoPlanIntervencion()" class="blue lighten-4 center-align"><i class="mdi-content-add-box"></i> INGRESAR PLAN</div>
                </div>
            </div>
            <?php
            echo $familia->historialPlanIntervencion();
            ?>
        </div>
    </div>
</div>
<style type="text/css">
    .btn:hover {
        background-color: #3fff7f;
    }
</style>
<script type="text/javascript">
    function boxNuevoVDI(){
        $.post('formulario/nuevo_vdi.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function deleteVDI(id){
        $.post('formulario/delete_vdi.php', {
            id_familia: '<?php echo $id_familia ?>',
            id_registro: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }

    function boxNuevoPautaRiesgo(){
        $.post('formulario/nuevo_pauta_riesgo.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function deletePautaRiesgo(id){
        $.post('formulario/delete_pauta_riesgo.php', {
            id_familia: '<?php echo $id_familia ?>',
            id_registro: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxNuevoPlanIntervencion(){
        $.post('formulario/nuevo_plan_intervencion.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function deletePlanIntervencion(id){
        $.post('formulario/delete_plan_intervencion.php', {
            id_familia: '<?php echo $id_familia ?>',
            id_registro: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
</script>
