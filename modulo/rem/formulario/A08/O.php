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
                    <div class="col l4">CONCEPTO</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>VIOLENCIA SEXUAL</option>
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
                    <div class="col l4">HORAS</div>
                    <div class="col l8">
                        <select name="tipo_hora" id="tipo_hora">
                            <option>72 horas o menos</option>
                            <option>después de 72 horas</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_hora').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">VICTIMARIO/A</div>
                    <div class="col l8">
                        <select name="tipo_victimario" id="tipo_victimario">
                            <option>Pareja/ Ex pareja</option>
                            <option>Familiar</option>
                            <option>Conocido/a</option>
                            <option>Desconocido/a</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_victimario').jqxDropDownList({
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
                            <option>0 A 4 </option>
                            <option>5 A 9 </option>
                            <option>10 A 14 </option>
                            <option>15 A 17</option>
                            <option>18 A 24</option>
                            <option>25 A 44</option>
                            <option>45 A 64</option>
                            <option> 65 y MAS</option>
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
                            <div class="settings-label">Con entrega de anticoncepción de emergencia</div>
                            <div class="settings-setter">
                                <div id="anticoncepción"></div>
                                <input type="hidden" name="input_anticoncepción" id="input_anticoncepción" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#anticoncepción').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#anticoncepción').on('change',function(){
                                    if($('#anticoncepción').val()===true){
                                        $("#input_anticoncepción").val('SI');
                                    }else{
                                        $("#input_anticoncepción").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Con profilaxis VIH </div>
                            <div class="settings-setter">
                                <div id="vih"></div>
                                <input type="hidden" name="input_vih" id="input_vih" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vih').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#vih').on('change',function(){
                                    if($('#vih').val()===true){
                                        $("#input_vih").val('SI');
                                    }else{
                                        $("#input_vih").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Con profilaxis ITS</div>
                            <div class="settings-setter">
                                <div id="its"></div>
                                <input type="hidden" name="input_its" id="input_its" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#its').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#its').on('change',function(){
                                    if($('#anticoncepción').val()===true){
                                        $("#input_its").val('SI');
                                    }else{
                                        $("#input_its").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Con profilaxis Hepatitis B</div>
                            <div class="settings-setter">
                                <div id="hepatitisb"></div>
                                <input type="hidden" name="input_hepatitisb" id="input_hepatitisb" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#hepatitisb').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#hepatitisb').on('change',function(){
                                    if($('#hepatitisb').val()===true){
                                        $("#input_hepatitisb").val('SI');
                                    }else{
                                        $("#input_hepatitisb").val('NO');
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

