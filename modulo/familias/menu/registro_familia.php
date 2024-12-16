<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';
include '../../../php/objetos/familia.php';
include '../../../php/objetos/profesional.php';

$id_familia = $_POST['rut'];
$rut = $_POST['rut'];
$profesional = new profesional($_SESSION['id_usuario']);
$familia = new familia($id_familia);
$fecha_registro = date('Y-m-d');
$integrantes = $familia->integrantes;
?>

<script type="text/javascript">
    $(document).ready(function () {
        // Create jqxTabs.
        $('#tabs_registro').jqxTabs({
            width: '100%',
            theme: 'eh-open',
            height: alto-450,
            position: 'top',
            scrollPosition: 'both'
        });

        loadRegistroFamilia('<?php echo $id_familia; ?>');


    });

    function loadInfoPaciente(rut) {
        $.post('info/banner_paciente.php', {
            rut: rut,
            fecha_registro: '<?php echo $fecha_registro; ?>'

        }, function (data) {
            $("#info_paciente").html(data);
        });
    }

    function loadRegistroFamilia(id) {
        var div = 'form_registro_familia';
        loading_div(div);
        $.post('formulario/registro.php', {
            id_familia: id,
            fecha_registro: '<?php echo $fecha_registro; ?>'
        }, function (data) {
            $("#" + div).html(data);
        });
    }
    function loadRegistroFamilia1(id){
        var div = 'form_registro_familia1';
        loading_div(div);
        $.post('formulario/registro_actual.php', {
            id_familia: id,
            fecha_registro: '<?php echo $fecha_registro; ?>'
        }, function (data) {
            $("#" + div).html(data);
        });
    }

    function load_integrantes(id) {
        var div = 'form_integrantes';
        loading_div(div);
        $.post('grid/integrantes.php', {
            rut: id,
        }, function (data) {
            $("#" + div).html(data);
        });
    }
    function loadParametrosFamilia(id){
        var div = 'form_parametros';
        loading_div(div);
        $.post('formulario/parametros.php', {
            id_familia: id,
        }, function (data) {
            $("#" + div).html(data);
        });
    }
    function boxEditarUbicacionFamilia(){
        $.post('formulario/ubicacion_familia.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxEditarFamilia(id){
        $.post('formulario/editar_familia.php', {
            id_familia: id,
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxAgendamiento(modulo){
        $.post('../default/modal/agenda/derivacion_familia.php',{
            rut:'<?php echo $rut; ?>',
            modulo:modulo
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function load_observaciones(id){
        var div = 'form_obs';
        loading_div(div);
        $.post('formulario/observaciones_familia.php', {
            id_familia: id,
        }, function (data) {
            $("#" + div).html(data);
        });
    }



</script>
<script>
    // Coordenadas de ejemplo: reemplaza con las coordenadas que desees
    const latitud = <?php echo $familia->getSQL('ubicacion_x'); ?>;
    const longitud = <?php echo $familia->getSQL('ubicacion_y'); ?>;


    function abrirMapa() {
        const url = `https://www.google.com/maps?q=${latitud},${longitud}`;
        window.open(url, '_blank'); // Abre el enlace en una nueva pestaña
    }
</script>

<div class="col l12" style="padding-top: 10px;">
    <div class="row">
        <div class="col l12">
            <?php echo $familia->info() ?>
        </div>
    </div>
    <div class="row" style="font-size: 0.9em;">
        <div class="col l10">-</div>
        <div class="col l2 left-align" style="padding-right: 10px;text-align: left;">
            <label>FECHA REGISTRO</label>
            <input type="date" value="<?php echo $fecha_registro; ?>" name="fecha_registro" id="fecha_registro" />

        </div>
    </div>
    <div id="tabs_registro" style="font-size: 0.8em;">
        <ul>
            <li style="margin-left: 30px;text-align: center" onclick="loadRegistroFamilia('<?php echo $rut; ?>')">REGISTRO ACTUAL</li>
            <li style="margin-left: 30px;text-align: center" onclick="loadParametrosFamilia('<?php echo $rut; ?>')">TRAZADORES</li>
            <li style="margin-left: 30px;text-align: center" onclick="load_integrantes('<?php echo $rut; ?>')">INTEGRANTES (<?php echo $integrantes; ?>)</li>
            <li style="margin-left: 30px;text-align: center" onclick="load_observaciones('<?php echo $rut; ?>')">OBSERVACIONES GENERALES</li>
            <li style="background-color: #0a73a7;cursor: pointer;color: white" onclick="boxAgendamiento('FAMILIA')">
                DERIVAR CASO
            </li>
        </ul>
        <div>
            <!-- REGISTRO ACTUAL A -->
            <form name="form_registro_familia" id="form_registro_familia" class="col l12"></form>
        </div>
        <div>
            <!-- PARAMETROS -->
            <form name="form_parametros" id="form_parametros" class="col l12"></form>
        </div>
        <div>
            <!-- INTEGRANTES -->
            <form name="form_integrantes" id="form_integrantes" class="col l12"></form>
        </div>
        <div>
            <!-- OBS GENERALES -->
            <form name="form_obs" id="form_obs" class="col l12"></form>
        </div>
        <div>
            <!-- FINALIZAR -->
            <form name="form_sexualidad" id="form_sexualidad" class="col l12"></form>
        </div>


    </div>
    <div class="row">
        <div class="col l12">
            <input type="button"
                   style="width: 100%;"
                   onclick="loadMenu_M('menu_3','familias','<?php echo $rut; ?>')"
                   class="btn-large red lighten-2 white-text"
                   value=" <-- VOLVER"/>
        </div>
<!--        <div class="col l9">-->
<!--            <input type="button" style="width: 100%;"-->
<!--                   onclick="boxAgendamiento('FAMILIA')"-->
<!--                   class="btn-large eh-open_principal" VALUE="FINALIZAR ATENCIÓN"/>-->
<!--        </div>-->
    </div>

</div>