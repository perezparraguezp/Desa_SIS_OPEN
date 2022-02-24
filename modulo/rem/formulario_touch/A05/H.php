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
                                $('#tipo_control').on('change',function (){
                                    if($('#tipo_control').val()==='EGRESO'){
                                        $('.ingreso').show();
                                    }else{
                                        $('.ingreso').hide();
                                    }

                                })

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">RANGO EDADES</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
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
                    <div class="col l4">CONCEPTO</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>HIPERTENSIÓN ARTERIAL</option>
                            <option>DIABETES MELLITUS</option>
                            <option>DISLIPIDEMIA</option>
                            <option>ANTECEDENTES ENF. CARDIOVASCULAR ATEROSCLERÓTICA</option>
                            <option>TABAQUISMO</option>
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
                <div class="row ingreso" style="display: none;">
                    <div class="col l4">CAUSAL DE EGRESO</div>
                    <div class="col l8">
                        <select name="tipo_egreso" id="tipo_egreso">
                            <option>Abandono</option>
                            <option>Traslado</option>
                            <option>Fallecimiento</option>
                            <option>No cumple criterio</option>
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
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">REALIZADO EN DOMICILIO</div>
                            <div class="settings-setter">
                                <div id="domicilio"></div>
                                <input type="hidden" name="input_domicilio" id="input_domicilio" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#domicilio').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#domicilio').on('change',function(){
                                    if($('#domicilio').val()===true){
                                        $("#input_domicilio").val('SI');
                                    }else{
                                        $("#input_domicilio").val('NO');
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

