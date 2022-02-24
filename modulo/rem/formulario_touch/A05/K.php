
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
                    <div class="col l4">TIPO CONTROL</div>
                    <div class="col l8">
                        <select name="tipo_control" id="tipo_control">
                            <option>INGRESO</option>
                            <option>EGRESO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_control').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDAD</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>65 A 69</option>
                            <option>70 A 74</option>
                            <option>75 A 79</option>
                            <option>80 y Más</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#edad').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });
                            })
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col l4">EFAM</div>
                    <div class="col l8">
                        <select name="efam" id="efam">
                            <option>AUTOVALENTE SIN RIESGO</option>
                            <option>AUTOVALENTE CON RIESGO</option>
                            <option>RIESGO DE DEPENDENCIA</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#efam').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">BARTHEL</div>
                    <div class="col l8">
                        <select name="barthel" id="barthel">
                            <option>DEPENDIENTE LEVE</option>
                            <option>DEPENDIENTE MODERADO</option>
                            <option>DEPENDIENTE GRAVE</option>
                            <option>DEPENDIENTE TOTAL</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#barthel').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
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
