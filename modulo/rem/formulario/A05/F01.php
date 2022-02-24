
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
                    <div class="col l4">CONDICIÓN</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>NORMAL CON REZAGO</option>
                            <option>RIESGO</option>
                            <option>RETRASO</option>
                            <option>OTRA VULNERABILIDAD</option>
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
                    <div class="col l4">CAUSAL DE EGRESO</div>
                    <div class="col l8">
                        <select name="tipo_egreso" id="tipo_egreso">
                            <option>Cumplimiento de tratamiento</option>
                            <option>Otros</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_egreso').jqxDropDownList({
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
                            <option>MENOR 7 MESES </option>
                            <option>7 A 11 MESES</option>
                            <option>12 A 17</option>
                            <option>18 A 23</option>
                            <option>24 A 47</option>
                            <option>48 A 59</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Inasistente</div>
                            <div class="settings-setter">
                                <div id="inasistente"></div>
                                <input type="hidden" name="input_inasistente" id="input_inasistente" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#inasistente').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#inasistente').on('change',function(){
                                    if($('#inasistente').val()===true){
                                        $("#input_inasistente").val('SI');
                                    }else{
                                        $("#input_inasistente").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Recuperado</div>
                            <div class="settings-setter">
                                <div id="recuperado"></div>
                                <input type="hidden" name="input_recuperado" id="input_recuperado" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#recuperado').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#recuperado').on('change',function(){
                                    if($('#recuperado').val()===true){
                                        $("#input_recuperado").val('SI');
                                    }else{
                                        $("#input_recuperado").val('NO');
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

