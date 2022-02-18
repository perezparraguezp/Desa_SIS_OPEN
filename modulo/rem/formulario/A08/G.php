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
                            <option>VIOLENCIA INTRAFAMILIAR</option>
                            <option>OTRAS VIOLENCIAS</option>
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
                            <option>0 A 9 </option>
                            <option>10 A 17 </option>
                            <option>15 A 19</option>
                            <option>18 A 24</option>
                            <option>25 A 34</option>
                            <option>35 A 44</option>
                            <option>45 A 54</option>
                            <option>55 y 64</option>
                            <option>65 y 74</option>
                            <option>75 y MAS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">EMBARAZADA</div>
                            <div class="settings-setter">
                                <div id="embarazada"></div>
                                <input type="hidden" name="input_embarazada" id="input_embarazada" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#embarazada').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#embarazada').on('change',function(){
                                    if($('#embarazada').val()===true){
                                        $("#input_embarazada").val('SI');
                                    }else{
                                        $("#input_embarazada").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">AGRESOR /A</div>
                    <div class="col l8">
                        <select name="tipo_agresor" id="tipo_agresor">
                            <option>Pareja/ Ex pareja</option>
                            <option>Familiar</option>
                            <option>Conocido/a</option>
                            <option>Desconocido/a</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_agresor').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">LESIONES DE LA VÍCTIMA</div>
                    <div class="col l8">
                        <select name="tipo_lesiones" id="tipo_lesiones">
                            <option>Traumatológicas</option>
                            <option>Odontológicas</option>
                            <option>Contusionales</option>
                            <option>Por Arma</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_lesiones').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Sin lesiones constatables</div>
                            <div class="settings-setter">
                                <div id="sinlesiones"></div>
                                <input type="hidden" name="input_sinlesiones" id="input_sinlesiones" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#sinlesiones').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#sinlesiones').on('change',function(){
                                    if($('#sinlesiones').val()===true){
                                        $("#input_sinlesiones").val('SI');
                                    }else{
                                        $("#input_sinlesiones").val('NO');
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



