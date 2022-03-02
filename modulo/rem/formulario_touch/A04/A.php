<?php
?>
<script type="text/javascript">
    $(function(){
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
        <div class="col l12">
            <div class="container" id="info_evaluacion">
                <div class="row">
                    <div class="col l4">TIPO ATENCION</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>IRA ALTA</option>
                            <option>SÍNDROME BRONQUIAL OBSTRUCTIVO</option>
                            <option>NEUMONÍA</option>
                            <option>ASMA</option>
                            <option>ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA</option>
                            <option>OTRAS RESPIRATORIAS</option>
                            <option>OBSTÉTRICA</option>
                            <option>GINECOLÓGICA</option>
                            <option>GINECOLÓGICA  POR INFERTILIDAD</option>
                            <option>INFECCIÓN TRANSMISIÓN SEXUAL</option>
                            <option>VIH-SIDA</option>
                            <option>SALUD MENTAL</option>
                            <option>CARDIOVASCULAR</option>
                            <option>OTRAS MORBILIDADES</option>
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
                            <option>MENOR 1</option>
                            <option>1 A 4</option>
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
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">ESPACIO AMIGABLE</div>
                            <div class="settings-setter">
                                <div id="espacio"></div>
                                <input type="hidden" name="input_espacio" id="input_espacio" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#espacio').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#espacio').on('change',function(){
                                    if($('#espacio').val()===true){
                                        $("#input_espacio").val('SI');
                                    }else{
                                        $("#input_espacio").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">CAMPAÑA INVIERNO</div>
                            <div class="settings-setter">
                                <div id="invierno"></div>
                                <input type="hidden" name="input_invierno" id="input_invierno" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#invierno').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#invierno').on('change',function(){
                                    if($('#invierno').val()===true){
                                        $("#input_invierno").val('SI');
                                    }else{
                                        $("#input_invierno").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Niños, Niñas, Adolescentes y Jóvenes Población SENAME</div>
                            <div class="settings-setter">
                                <div id="sename"></div>
                            </div>
                            <input type="hidden" name="input_sename" id="input_sename" value="NO" />
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#sename').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#sename').on('change',function(){
                                    if($('#sename').val()===true){
                                        $("#input_sename").val('SI');
                                    }else{
                                        $("#input_sename").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Entrega de anticoncepción Emergencia</div>
                            <div class="settings-setter">
                                <div id="anticoncepción"></div>
                            </div>
                            <input type="hidden" name="input_anticoncepción" id="input_anticoncepción" value="NO" />
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
                            <div class="settings-label">Horario Continuado</div>
                            <div class="settings-setter">
                                <div id="horario"></div>
                            </div>
                            <input type="hidden" name="input_horario" id="input_horario" value="NO" />
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#horario').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#horario').on('change',function(){
                                    if($('#horario').val()===true){
                                        $("#input_horario").val('SI');
                                    }else{
                                        $("#input_horario").val('NO');
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
