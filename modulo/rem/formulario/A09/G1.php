<?php
?>
<script type="text/javascript">
    $(function(){
        $.post('formulario/base.php',{
        },function(data){
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
                <strong>DATOS PACIENTE</strong>
            </div>
        </div>
        <div class="col l7">
            <div class="container" id="info_evaluacion">
                <div class="row">
                    <div class="col l4">ACTIVIDAD</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>EXAMEN DE SALUD</option>
                            <option>Nº DE NIÑOS CON ÍNDICE ceod=0 AL INGRESO</option>
                            <option>SET DE HIGIENE ORAL ENTREGADOS</option>
                            <option>Nº DE APLICACIONES FLÚOR BARNIZ</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
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
                    <div class="col l4">RANGO EDADES</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>2 </option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Con Discapacidad</div>
                            <div class="settings-setter">
                                <div id="discapacidad"></div>
                                <input type="hidden" name="input_discapacidad" id="input_discapacidad" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#discapacidad').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#discapacidad').on('change',function(){
                                    if($('#discapacidad').val()===true){
                                        $("#input_discapacidad").val('SI');
                                    }else{
                                        $("#input_discapacidad").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">JUNJI</div>
                            <div class="settings-setter">
                                <div id="junji"></div>
                                <input type="hidden" name="input_junji" id="input_junji" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#junji').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#junji').on('change',function(){
                                    if($('#junji').val()===true){
                                        $("#input_junji").val('SI');
                                    }else{
                                        $("#input_junji").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">INTEGRA</div>
                            <div class="settings-setter">
                                <div id="integra"></div>
                                <input type="hidden" name="input_integra" id="input_integra" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#integra').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#integra').on('change',function(){
                                    if($('#integra').val()===true){
                                        $("#input_integra").val('SI');
                                    }else{
                                        $("#input_integra").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">MINEDUC</div>
                            <div class="settings-setter">
                                <div id="mineduc"></div>
                                <input type="hidden" name="input_mineduc" id="input_mineduc" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#mineduc').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#mineduc').on('change',function(){
                                    if($('#mineduc').val()===true){
                                        $("#input_mineduc").val('SI');
                                    }else{
                                        $("#input_mineduc").val('NO');
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



