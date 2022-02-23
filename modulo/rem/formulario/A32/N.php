<?php
?>
<script type="text/javascript">
    $(function () {
        $.post('formulario/base.php', {}, function (data) {
            $("#info_paciente").html(data);
        });
        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>

<style type="text/css">
    #formulario_final .container {
        border: solid 1px rgba(204, 204, 221, 0.86);
        padding: 10px;
        font-size: 0.7em;
    }
</style>
<style type="text/css">

    .settings-section {

        height: 45px;
        width: 100%;

    }

    .settings-label {
        font-weight: bold;
        font-family: Sans-Serif;
        font-size: 14px;
        margin-left: 14px;
        margin-top: 15px;
        float: left;
    }

    .settings-setter {
        float: right;
        margin-right: 14px;
        margin-top: 8px;
    }
</style>
<div class="container" id="formulario_final">
    <div class="row">
        <div class="col l5">
            <div class="container eh-open_fondo" id="info_paciente">
                <strong>DATOS PACIENTE</strong>
            </div>
        </div>
        <div class="col l7">
            <div class="container" id="info_evaluacion">
                <div class="row">
                    <div class="col l4">PROFESIONALES</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>Matrona/on</option>
                            <option>Enfermera/o</option>
                            <option>Trabajador/a Social</option>
                            <option>Psicologo/a</option>
                            <option>Educadora de Parvulos</option>
                            <option>Nutricionista</option>
                            <option>Otros/a</option>

                        </select>
                        <script type="text/javascript">
                            $(function () {
                                $('#tipo_atencion').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">ACCIONES</div>
                    <div class="col l8">
                        <select name="tipo_acciones" id="tipo_acciones">
                            <option>Llamadas Telefónicas</option>
                            <option>Video Llamadas</option>
                            <option>Mensajería de Texto</option>
                        </select>
                        <script type="text/javascript">
                            $(function () {
                                $('#tipo_acciones').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">RANGO EDADES</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>GESTANTE/option>
                            <option>MENOR DE 7 MESES</option>
                            <option>7 A 11 MESES</option>
                            <option>12 A 17 MESES</option>
                            <option>18 A 23 MESES</option>
                            <option>24 A 35 MESES</option>
                            <option>36 A 41 MESES</option>
                            <option>42 A 47 MESES</option>
                            <option>48 A 59 MESES</option>
                            <option>60 A 71 MESES</option>
                            <option>6 A 9 AÑOS Y 11 MESES</option>


                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">NANEAS</div>
                            <div class="settings-setter">
                                <div id="naneas"></div>
                                <input type="hidden" name="input_naneas" id="input_naneas" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#naneas').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#naneas').on('change',function(){
                                    if($('#naneas').val()===true){
                                        $("#input_naneas").val('SI');
                                    }else{
                                        $("#input_naneas").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col l6">
                        <input type="button"
                               style="width: 100%;"
                               onclick="loadMenu_REM('menu_2','registro_atencion','')"
                               class="btn-large red lighten-2 white-text"
                               value="CANCELAR"/>
                    </div>
                    <div class="col l6">
                        <input type="button"
                               style="width: 100%;"
                               onclick="insertRegistro()"
                               class="btn-large eh-open_principal"
                               value="GUARDAR"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>








