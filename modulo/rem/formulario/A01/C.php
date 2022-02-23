<?php
?>
<script type="text/javascript">
    $(function () {

        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#tipo_control').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#cronico').jqxDropDownList({
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
                    <div class="col l4">TIPO CONTROL</div>
                    <div class="col l8">
                        <select name="tipo_control" id="tipo_control">
                            <option>DE SALUD CARDIOVASCULAR</option>
                            <option>DE TUBERCULOSIS</option>
                            <option>SEGUIMIENTO AUTOVALENTE CON RIESGO</option>
                            <option>SEGUIMIENTO RIESGO DEPENDENCIA</option>
                            <option>DE INFECCIÓN DE TRANSMICIÓN SEXUAL</option>
                            <option>OTROS PROBLEMAS DE SALUD</option>
                            <option>NIÑOS CON NECESIDADES ESPECIALES</option>
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
                    <div class="col l4">EDAD</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>0 A 4 AÑOS</option>
                            <option>5 A 9 AÑOS</option>
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
