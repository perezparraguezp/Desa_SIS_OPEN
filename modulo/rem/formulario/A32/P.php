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
                    <div class="col l4">HABILIDADES PARENTALES</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>Nadie es Perfecto Remoto A</option>
                            <option>Nadie es Perfecto Remoto B</option>
                            <option>Nadie es Perfecto Seminario</option>
                            <option>Nadie es perfecto PASMI</option>
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
                            <option>Video llamada grupal</option>
                            <option>Seminario-Radio</option>
                            <option>Plataforma Digital</option>
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
                        <option>MENOR DE 12 MESES</option>
                        <option>2 A 5 AÑOS</option>
                        <option>5 A 9 AÑOS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">GESTANTE</div>
                            <div class="settings-setter">
                                <div id="gestante"></div>
                                <input type="hidden" name="input_gestante" id="input_gestante" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#gestante').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#gestante').on('change',function(){
                                    if($('#gestante').val()===true){
                                        $("#input_gestante").val('SI');
                                    }else{
                                        $("#input_gestante").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Acompañante de gestante</div>
                            <div class="settings-setter">
                                <div id="acompañante"></div>
                                <input type="hidden" name="input_acompañante" id="input_acompañante" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#acompañante').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#acompañante').on('change',function(){
                                    if($('#acompañante').val()===true){
                                        $("#input_acompañante").val('SI');
                                    }else{
                                        $("#input_acompañante").val('NO');
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









