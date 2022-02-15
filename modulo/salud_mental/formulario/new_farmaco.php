<?php
include "../../../php/config.php";
include "../../../php/objetos/persona.php";

$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];
?>
<form id="form_farmaco" class="container" style="padding: 20px;">
    <input type="hidden" name="rut" value="<?php echo $rut; ?>" />
    <input type="hidden" name="fecha_registro" value="<?php echo $fecha_registro; ?>" />
    <div class="row">
        <div class="col l4 s4 m4">TIPO FARMACO</div>
        <div class="col l8 s8 m8">
            <select name="tipo" id="tipo">
                <option value="" disabled="disabled" selected="selected">SELECCIONE UN FARMACO</option>
                <option disabled="disabled">-------------------------------------</option>
                <option>FLUOXETINA 20MG</option>
                <option>SERTRALINA 50MG</option>
                <option>PAROXETINA 20MG</option>
                <option>VENLAFAXINA 75MG</option>
                <option>DIAZEPAM 10MG</option>
                <option>CLONAZEPAM 0.5MG</option>
                <option>CLONAZEPAM 2MG</option>
                <option>ALPLAZOLAM 0.5MG</option>
                <option>FENOBARBITAL 100MG</option>
                <option>FLUFENAZINA 25MG/ML</option>
                <option>ESCITALOPRAM 10MG</option>
                <option>ESCITALOPRAM 20MG</option>
                <option>ZOPICLONA 7.5MG</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col l4 s4 m4">FECHA INGRESO</div>
        <div class="col l8 s8 m8">
            <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo date('Y-m-d'); ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col l4 s4 m4">OBSERVACION</div>
        <div class="col l8 s8 m8">
            <textarea id="obs" name="obs"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="btn blue" style="width: 100%;" onclick="insertFarmaco()"> REGISTRAR FARMACO</div>
    </div>

</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">
    $(function(){
        $('#tipo').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });

    });
    function insertFarmaco(){
        var obs = $("#obs").val();
        var farmaco = $("#tipo").val();
        if(farmaco !== '' ){
            if(obs !== ''){
                if(confirm("¿Seguro que desea asignar este Diagnostico al Paciente?")){
                    $.post('db/insert/farmaco.php',
                        $("#form_farmaco").serialize()
                        ,function (data) {
                            load_sm_farmacos('<?php echo $rut; ?>');
                            document.getElementById("close_modal").click();
                        });
                }
            }else{
                alertaLateral('DEBE INGRESAR UNA OBSERVACION PARA EL FARMACO');
                $("#obs").css({
                    'background-color':'pink',
                    'border':'solid 1px red'
                });
                $("#obs").focus();
            }
        }else{
            alertaLateral('DEBE SELECCIONAR UN FARMACO');
            $("#tipo").css({
                'background-color':'pink',
                'border':'solid 1px red'
            });
            $("#tipo").focus();
        }

    }
</script>
