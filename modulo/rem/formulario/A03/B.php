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
                    <div class="col l4">ESTADO NUTRICIONAL</div>
                    <div class="col l8">
                        <select name="imc" id="imc">
                            <option>NO APLICA</option>
                            <option>OBESA</option>
                            <option>SOBREPESO</option>
                            <option>NORMAL</option>
                            <option>BAJO PESO</option>
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
                    <div class="col l4">TIPO RIESGO PSICOSOCIAL - INGRESO</div>
                    <div class="col l8">
                        <select name="tipo_riesgo_social_ingreso" id="tipo_riesgo_social_ingreso">
                            <option>NO APLICA</option>
                            <option>RIESGO</option>
                            <option>DERIVADAS A EQUIPO DE CABECERA</option>
                            <option>VIOLENCIA INTRAFAMILIAR</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#tipo_riesgo_social_ingreso').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">TIPO RIESGO PSICOSOCIAL - 3ER TRIMESTRE</div>
                    <div class="col l8">
                        <select name="tipo_riesgo_social_trimestre" id="tipo_riesgo_social_trimestre">
                            <option>NO APLICA</option>
                            <option>RIESGO</option>
                            <option>DERIVADAS A EQUIPO DE CABECERA</option>
                            <option>VIOLENCIA INTRAFAMILIAR</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#tipo_riesgo_social_trimestre').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDIMBURGO A GESTANTES - PRIMERA EVALUACION</div>
                    <div class="col l8">
                        <select name="edimburgo_gestante_primera" id="edimburgo_gestante_primera">
                            <option>NO APLICA</option>
                            <option>13 O MAS PTOS O RESULTADO DISTINTO DE 0 EN PREG 10. (GESTANTES)</option>
                            <option>ALTERADO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#edimburgo_gestante_primera').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDIMBURGO A GESTANTES - REEVALUACION</div>
                    <div class="col l8">
                        <select name="edimburgo_gestante_reevaluacion" id="edimburgo_gestante_reevaluacion">
                            <option>NO APLICA</option>
                            <option>13 O MAS PTOS O RESULTADO DISTINTO DE 0 EN PREG 10. (GESTANTES)</option>
                            <option>ALTERADO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#edimburgo_gestante_reevaluacion').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDIMBURGO A MUJERS POST PARTO O SINTOMAS DE DEPRESION - 2 MESES</div>
                    <div class="col l8">
                        <select name="edimburgo_mujer_2" id="edimburgo_mujer_2">
                            <option>NO APLICA</option>
                            <option>13 O MAS PTOS O RESULTADO DISTINTO DE 0 EN PREG 10. (PUERPERA)</option>
                            <option>ALTERADO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#edimburgo_mujer_2').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDIMBURGO A MUJERS POST PARTO O SINTOMAS DE DEPRESION - 2 MESES</div>
                    <div class="col l8">
                        <select name="edimburgo_mujer_6" id="edimburgo_mujer_6">
                            <option>NO APLICA</option>
                            <option>13 O MAS PTOS O RESULTADO DISTINTO DE 0 EN PREG 10. (PUERPERA)</option>
                            <option>ALTERADO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){

                                $('#edimburgo_mujer_6').jqxDropDownList({
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
