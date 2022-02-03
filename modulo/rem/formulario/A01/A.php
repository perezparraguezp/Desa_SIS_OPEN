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
        $('#lactancia').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#tipo_control').jqxDropDownList({
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
                    <div class="col l4">TIPO CONTROL</div>
                    <div class="col l8">
                        <select name="tipo_control" id="tipo_control">
                            <option>PRE-CONCEPCIONAL</option>
                            <option>PRE-NATAL</option>
                            <option>POST PARTO</option>
                            <option>POST ABORTO</option>
                            <option>PÚERPERA CON RECIEN NACIDO HASTA 10 DÍAS DE VIDA</option>
                            <option>PÚERPERA CON RECIEN NACIDO ENTRE 11 Y 28 DÍAS</option>
                            <option>RECIEN NACIDO HASTA 10 DÍAS</option>
                            <option>RECIEN NACIDO ENTRE 11 Y 28 DÍAS</option>
                            <option>GINECOLÓGICO</option>
                            <option>CLIMATERIO</option>
                            <option>REGULACION DE FECUNDIDAD</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDAD</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>MENOR 1 MES</option>
                            <option>5 A 9</option>
                            <option>10 A 14</option>
                            <option>15 A 19</option>
                            <option>20 A 24</option>
                            <option>25 A 29</option>
                            <option>30 A 34</option>
                            <option>35 A 39</option>
                            <option>40 A 44</option>
                            <option>45 A 49</option>
                            <option>50 A 54</option>
                            <option>55 A 59</option>
                            <option>60 A 64</option>
                            <option>65 A 69</option>
                            <option>70 A 74</option>
                            <option>75 A 79</option>
                            <option>80 y Más</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">TIPO LACTANCIA</div>
                    <div class="col l8">
                        <select name="lactancia" id="lactancia">
                            <option>NO CALIFICA</option>
                            <option>LME</option>
                            <option value="MIXTA">LME/FORMULA</option>
                            <option>FORMULA</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">BENEFICIARIO</div>
                            <div class="settings-setter">
                                <div id="beneficiario"></div>
                                <input type="hidden" name="input_beneficiario" id="input_beneficiario" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#beneficiario').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#beneficiario').on('change',function(){
                                    if($('#beneficiario').val()===true){
                                        $("#input_beneficiario").val('SI');
                                    }else{
                                        $("#input_beneficiario").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">CONTROL CON PAREJA, FAMILIAR U OTRO</div>
                            <div class="settings-setter">
                                <div id="control_con_familiar"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#control_con_familiar').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#control_con_familiar').on('change',function(){
                                    if($('#control_con_familiar').val()===true){
                                        $("#input_control_con_familiar").val('SI');
                                    }else{
                                        $("#input_control_con_familiar").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">CONTROL DE DIADA CON PRESENCIA DEL PADRE</div>
                            <div class="settings-setter">
                                <div id="control_con_padre"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#control_con_padre').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#control_con_padre').on('change',function(){
                                    if($('#control_con_padre').val()===true){
                                        $("#input_control_con_padre").val('SI');
                                    }else{
                                        $("#input_control_con_padre").val('NO');
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
