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
                            <option>Enfermera/o</option>
                            <option>Médico/a</option>
                            <option>Nutricionista</option>
                            <option>Otro/a</option>

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
                            <option>LLAMADAS TELEFÓNICAS</option>
                            <option>VIDEO</option>
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
                            <option>1 MES</option>
                            <option>2 MES</option>
                            <option>3 MES</option>
                            <option>4 MES</option>
                            <option>5 MES</option>
                            <option>6 MES</option>
                            <option>7 A 11 MESES</option>
                            <option>12 A 17 MESES</option>
                            <option>18 A 23 MESES</option>
                            <option>24 A 36 MESES</option>
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
                            <div class="settings-label">Acompañamiento del Padre</div>
                            <div class="settings-setter">
                                <div id="acompañado"></div>
                                <input type="hidden" name="input_acompañado" id="input_acompañado" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#acompañado').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#acompañado').on('change',function(){
                                    if($('#acompañado').val()===true){
                                        $("#input_acompañado").val('SI');
                                    }else{
                                        $("#input_acompañado").val('NO');
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







