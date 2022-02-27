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
                    <div class="col l4">TIPO DE ACTIVIDAD</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>EDUCACIÓN INDIVIDUAL CON INSTRUCCIÓN DE TÉCNICA DE CEPILLADO</option>
                            <option>CONSEJERÍA BREVE EN TABACO</option>
                            <option>EXAMEN DE SALUD ORAL</option>
                            <option>APLICACIÓN DE SELLANTES</option>
                            <option>FLUORURACIÓN TÓPICA BARNIZ</option>
                            <option>ACTIVIDAD INTERCEPTIVA DE ANOMALÍAS DENTO MAXILARES (OPI) (ACTIVIDAD OPI)</option>
                            <option>DESTARTRAJE SUPRAGINGIVAL Y PULIDO CORONARIO</option>
                            <option>EXODONCIA</option>
                            <option>PROCEDIMIENTO PULPAR</option>
                            <option>ACCESO CAVITARIO</option>
                            <option>RESTAURACIÓN ESTÉTICA</option>
                            <option>RESTAURACIÓN DE AMALGAMAS</option>
                            <option>OBTURACIÓN DE VIDRIO IONÓMERO </option>
                            <option>DESTARTRAJE SUBGINGIVAL Y PULIDO RADICULAR POR SEXTANTE</option>
                            <option>TRATAMIENTO RESTAURADOR ATRAUMÁTICO (ART)</option>
                            <option>TPROCEDIMIENTOS MÉDICO-QUIRÚRGICOS</option>
                            <option>RADIOGRAFÍA INTRAORAL (RETROALVEOLARES, BITE WING Y OCLUSALES)</option>
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
                            <option>MENOR 1 AÑO </option>
                            <option>1 </option>
                            <option>2 </option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8 A 9</option>
                            <option>10 A 14 </option>
                            <option>15 A 19</option>
                            <option>20 A 24</option>
                            <option>25 A 34</option>
                            <option>35 A 44</option>
                            <option>45 A 59</option>
                            <option>60 y 64</option>
                            <option>65 y 74</option>
                            <option>75 y MAS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">JORNADA</div>
                    <div class="col l8">
                        <select name="tipo_jornada" id="tipo_jornada">
                            <option>VESPERTINA (LUNES-VIERNES)</option>
                            <option>SÁBADO, DOMINGO o FESTIVO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_jornada').jqxDropDownList({
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
                            <div class="settings-label">Compra de Servicio</div>
                            <div class="settings-setter">
                                <div id="compra"></div>
                                <input type="hidden" name="input_compra" id="input_compra" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#compra').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#compra').on('change',function(){
                                    if($('#discapacidad').val()===true){
                                        $("#input_compra").val('SI');
                                    }else{
                                        $("#input_compra").val('NO');
                                    }
                                });

                            });
                        </script>
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
                            <div class="settings-label">Niños, Niñas, Adolescentes y Jóvenes Población  SENAME</div>
                            <div class="settings-setter">
                                <div id="sename"></div>
                                <input type="hidden" name="input_sename" id="input_sename" value="NO" />
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


