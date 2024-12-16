<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';
include '../../../php/objetos/familia.php';

$id_establecimiento =1;

?>
<style type="text/css">
    #form_paciente input{
        text-align: left;
    }
</style>
<form name="form_buscador"
      id="form_buscador" class="card-panel left-align modal-content">
    <div class="row">
        <div class="col l4">
            <div class="card-panel">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="rut_buscar" name="rut_buscar" type="text" />
                        <label for="rut_buscar" class="">INGRESE RUT A BUSCAR</label>
                    </div>
                </div>
                <div class="row">
                    <input type="button"
                           value="BUSCAR A FAMILIA"
                           style="text-align: center;"
                           onclick="buscarFamilia()"
                           class="btn waves-effect modal-trigger waves-light col s12 " />
                </div>
            </div>
        </div>
        <div class="col l8">
            <div class="card-panel orange lighten-5" id="divDatosFamilia">
                <p>Para poder encontrar a la familia, es necesario buscar con el rut del integrante.</p>
            </div>
        </div>
    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">
    $(function(){
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

    function buscarFamilia(){
        var rut = $("#rut_buscar").val();

        $.post('db/buscar/familia.php',
            $("#form_buscador").serialize(),function (data){
                if(data!=='ERROR_SQL'){
                    $("#divDatosFamilia").html(data);


                }

            });


    }
</script>
