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

        <div class="col l12">
            <div class="container" id="info_evaluacion">

                <div class="row">
                    <div class="col l4">EDAD</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>10 a 14</option>
                            <option>15 a 19</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#edad').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">ESTADO NUTRICIONAL</div>
                    <div class="col l8">
                        <select name="imc" id="imc">
                            <option>NO APLICA</option>
                            <option>NORMAL</option>
                            <option>BAJO PESO</option>
                            <option>SOBREPESO</option>
                            <option>OBESOS</option>
                            <option>OBESOS SEVEROS</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#imc').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
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
