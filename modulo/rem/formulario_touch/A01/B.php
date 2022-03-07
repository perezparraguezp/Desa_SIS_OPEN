<?php
?>
<script type="text/javascript">
    $(function(){

        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#tipo_lugar').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#cronico').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });

        $('#edad').on('change',function(){
            var tipo = $('#edad').val();

            if(tipo === '10 A 14 AÑOS' ||
                tipo ==='15 A 19 AÑOS')
            {
                $("#div_lugar").show();

            }else{
                $("#div_lugar").hide();
            }
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
<div class="container" id="formulario_final" >
    <div class="row">
        <div class="col l12">
            <div class="container" id="info_evaluacion">
                <div class="row">
                    <input type="hidden" name="tipo_control" id="tipo_control" value="DE SALUD" />

                </div>
                <div class="row">
                    <div class="col l4">EDAD</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>MENOR 1 MES</option>
                            <option>1 MES</option>
                            <option>2 MESES</option>
                            <option>3 MESES</option>
                            <option>4 MESES</option>
                            <option>5 MESES</option>
                            <option>6 MESES</option>
                            <option>7 A 11 MESES</option>
                            <option>12 A 17 MESES</option>
                            <option>18 A 23 MESES</option>
                            <option>24 A 47 MESES</option>
                            <option>48 A 59 MESES</option>
                            <option>60 A 71 MESES</option>
                            <option>6 A 9 AÑOS</option>
                            <option>10 A 14 AÑOS</option>
                            <option>15 A 19 AÑOS</option>
                            <option>20 A 24 AÑOS</option>
                            <option>25 A 29 AÑOS</option>
                            <option>30 A 34 AÑOS</option>
                            <option>35 A 39 AÑOS</option>
                            <option>40 A 44 AÑOS</option>
                            <option>45 A 49 AÑOS</option>
                            <option>50 A 54 AÑOS</option>
                            <option>55 A 59 AÑOS</option>
                            <option>60 A 64 AÑOS</option>
                            <option>65 A 69 AÑOS</option>
                            <option>70 A 74 AÑOS</option>
                            <option>75 A 79 AÑOS</option>
                            <option>80 y Más</option>
                        </select>
                    </div>
                </div>
                <div class="row" id="div_lugar" style="display: none;">
                    <div class="col l4">TIPO DE LUGAR DE CONTROL</div>
                    <div class="col l8">
                        <select name="tipo_lugar" id="tipo_lugar">
                            <option>NO APLICA</option>
                            <option>ESPACIO AMIGABLE</option>
                            <option>OTROS ESPACIOS DEL ESTABLECIMIENTO DE SALUD</option>
                            <option>EN ESTABLECIMIENTO EDUCACIONAL</option>
                            <option>EN OTROS ESPACIOS FUERA DEL ESTABLECIMIENTO DE SALUD</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">PACIENTE CRÓNICO</div>
                    <div class="col l8">
                        <select name="cronico" id="cronico">
                            <option>NO</option>
                            <option>CONTROL CON RIESGO LEVE (G1)</option>
                            <option>CONTROL CON RIESGO MODERADO (G2)</option>
                            <option>CONTROL CON RIESGO ALTO (G3)</option>
                            <option>SEGUIMIENTO CON RIESGO LEVE (G1)</option>
                            <option>SEGUIMIENTO CON RIESGO MODERADO (G2)</option>
                            <option>SEGUIMIENTO CON RIESGO ALTO (G3)</option>

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">CONTROL CON PRESENCIA DEL PADRE</div>
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

                            });
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">POBLACION SENAME</div>
                            <div class="settings-setter">
                                <div id="sename"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#sename').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
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
