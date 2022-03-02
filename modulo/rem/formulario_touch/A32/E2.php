<?php
?>
<script type="text/javascript">
    $(function () {
         
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
         <div class="col l12">
            <div class="container" id="info_evaluacion">
                <div class="row">
                    <div class="col l4">ACTIVIDAD</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>CONTROLES DE SALUD MENTAL POR LLAMADAS TELEFONICAS EN EL CONTEXTO DE PANDEMIA
                            </option>
                            <option>CONTROLES DE SALUD MENTAL POR VIDEO LLAMADAS EN EL CONTEXTO DE PANDEMIA</option>
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
                    <div class="col l4">PROFESIONAL</div>
                    <div class="col l8">
                        <select name="tipo_profesional" id="tipo_profesional">
                            <option>Médico</option>
                            <option>Psicólogo/a</option>
                            <option>Enfermera/o</option>
                            <option>Matrona/on</option>
                            <option>Asistente Social</option>
                            <option>Otros Profesionales</option>
                            <option>Terapeuta Ocupacional</option>
                            <option>Técnico Paramédico y en Salud Mental</option>
                            <option>Gestor Comunitario</option>
                            <option>Médico Psiquiatra</option>
                            <option>Médico Psiquiatra</option>
                        </select>
                        <script type="text/javascript">
                            $(function () {
                                $('#tipo_profesional').jqxDropDownList({
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
                            <option>0 A 4</option>
                            <option>5 A 9</option>
                            <option>10 A 14</option>
                            <option>15 A 19</option>
                            <option>20 A 24</option>
                            <option>25 A 20</option>
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
                            <option>80 Y MAS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Niños, Niñas, Adolescentes y Jóvenes Población SENAME</div>
                            <div class="settings-setter">
                                <div id="sename"></div>
                                <input type="hidden" name="input_sename" id="input_sename" value="NO"/>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#sename').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel: 'SI',
                                    offLabel: 'NO',
                                });
                                $('#sename').on('change', function () {
                                    if ($('#sename').val() === true) {
                                        $("#input_sename").val('SI');
                                    } else {
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
                            <div class="settings-label">DEMENCIA</div>
                            <div class="settings-setter">
                                <div id="demencia"></div>
                                <input type="hidden" name="input_demencia" id="input_demencia" value="NO"/>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#demencia').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel: 'SI',
                                    offLabel: 'NO',
                                });
                                $('#demencia').on('change', function () {
                                    if ($('#demencia').val() === true) {
                                        $("#input_demencia").val('SI');
                                    } else {
                                        $("#input_demencia").val('NO');
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






