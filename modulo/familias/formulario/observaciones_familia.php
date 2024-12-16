<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';
include '../../../php/objetos/familia.php';
session_start();
$profesional = new profesional($_SESSION['id_usuario']);

$id_establecimiento =1;
$id_familia = $_POST['id_familia'];

?>
<style type="text/css">
    #form_paciente input{
        text-align: left;
    }
</style>
<form name="form_obs_general"
      id="form_obs_general" class="card-panel left-align modal-content">
    <input type="hidden" name="id_familia" value="<?php echo $id_familia; ?>" />
    <input type="hidden" name="id_profesional" value="<?php echo $profesional->id_profesional; ?>" />
    <div class="row">
        <div class="col l4">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="obs_general" name="obs_general" type="text" />
                        <label for="obs_general" class="">INGRESAR OBSERVACIONES</label>
                    </div>
                </div>
                <div class="row">
                    <input type="button"
                           value="REGISTRAR OBSERVACION"
                           style="text-align: center;"
                           onclick="insertObsGeneral()"
                           class="btn waves-effect modal-trigger waves-light col s12 " />
                </div>
            </div>
        </div>
        <div class="col l8">
            <div class="card-panel indigo lighten-5" id="div_obs_familia">

            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function(){
        loadObsFamilia('<?php echo $id_familia; ?>');
        $("#rut_buscar").on('change',function(){
            $('#rut_buscar').Rut({
                on_error: function() {
                    $(this).focus();
                    //alert('Rut incorrecto');
                    alertaLateral('RUT INCORRECTO');
                    $('#rut_buscar').val('');
                    $('#rut_buscar').focus();
                    $('#rut_buscar').css({
                        "border": "solid red 1px"
                    });
                },
                on_succes: function(){
                    alertaLateral('RUT VALIDO');
                }//FIN ON_SUCCES
            });
        });
    });
    function loadObsFamilia(id){
        $.post('db/buscar/obs_familia.php',
            {id_familia:id},function (data){
                if(data!=='ERROR_SQL'){
                    $("#div_obs_familia").html(data);

                }

            });
    }

    function insertObsGeneral(){


        $.post('db/insert/obs_familia.php',
            $("#form_obs_general").serialize(),function (data){
                if(data!=='ERROR_SQL'){
                    load_observaciones('<?php echo $id_familia; ?>');


                }

            });


    }
</script>
