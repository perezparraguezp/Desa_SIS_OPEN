<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';
include '../../../../php/objetos/profesional.php';
session_start();
$rut = $_SESSION['rut'];
$id_usuario = $_SESSION['id_usuario'];
$profesional = new profesional($id_usuario);
$tipo_profesional = $profesional->tipo_profesional;

?>
<script type="text/javascript">
    $(function(){
        $.post('formulario/base.php',{
        },function(data){
            $("#info_paciente").html(data);
        });
        $('#sub_seccion').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $("#sub_seccion").on('change',function(){
            var seccion = $("#sub_seccion").val();
            $.post('formulario/A03/'+seccion+'.php',{
            },function(data){
                $("#div_sub_seccion").html(data);
            });
        })

    })
</script>
<style type="text/css">
    #formulario_final .container{
        border: solid 1px rgba(204,204,221,0.86);
        padding: 10px;
        font-size: 0.7em;
    }
</style>
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
</style>
<div class="container" id="formulario_final" >
    <div class="row">
        <div class="col l5">
            <div class="container eh-open_fondo" id="info_paciente">
                <strong>ATENCIÓN POR PROFESIONAL</strong>
                <p>asasasa sa sa sakaksjkj kskjsa.</p>
            </div>
        </div>
        <div class="col l7">
            <div class="container" id="info_evaluacion">

                <div class="row">
                    <div class="col l4">SUB-SECCIÓN</div>
                    <div class="col l8">
                        <select name="sub_seccion" id="sub_seccion">
                            <option value="" selected="selected" disabled="disabled">INDICAR OPCIÓN</option>
                            <option value="D1">APLICACIÓN DE TAMIZAJE PARA EVALUAR EL NIVEL DE RIESGO DE CONSUMO DE  ALCOHOL, TABACO Y OTRAS DROGAS</option>
                            <option value="D2">RESULTADOS DE LA APLICACIÓN DE INSTRUMENTO DE VALORACIÓN DE DESEMPEÑO EN COMUNIDAD (IVADEC-CIF)</option>

                        </select>
                    </div>
                </div>
                <div id="div_sub_seccion">

                </div>
                <div class="row">
                    <div class="col l6">
                        <input type="button"
                               style="width: 100%;"
                               onclick="loadMenu_REM('menu_2','registro_atencion','')"
                               class="btn-large red lighten-2 white-text"
                               value="CANCELAR" />
                    </div>
                    <div class="col l6">
                        <input type="button"
                               style="width: 100%;"
                               onclick="insertRegistro()"
                               class="btn-large eh-open_principal"
                               value="GUARDAR" />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
