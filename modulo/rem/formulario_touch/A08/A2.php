<?php
?>
<script type="text/javascript">
    $(function(){
        $("#anticonceptivo_div").hide();
        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#edad').on('change',function(){
            var edad = $('#edad').val();
            // alert(edad);
            if(edad !=='0 A 4' &&
                edad !=='5 A 9' &&
                edad !=='55 A 59' &&
                edad !=='60 A 64' &&
                edad !=='65 A 69' &&
                edad !=='70 A 74' &&
                edad !=='75 A 79' &&
                edad !=='80 y MAS'){
                $("#anticonceptivo_div").show();

            }else{
                $("#anticonceptivo_div").hide();
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
                    <div class="col l4">ATENCIÓN URGENCIA</div>
                    <div class="col l8">
                        <select name="atencion_urgencia" id="atencion_urgencia">
                            <option>SAPU Y SAR</option>
                            <option>BAJA COMPLEJIDAD</option>
                            <option>APS NO SAPU</option>
                            <option>CONSULTAS SUR Y PSR</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#atencion_urgencia').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">CATEGORIZACIÓN</div>
                    <div class="col l8">
                        <select name="categorizacion" id="categorizacion">
                            <option>SIN CATEGORIZACION</option>
                            <option>C1</option>
                            <option>C2</option>
                            <option>C3</option>
                            <option>C4</option>
                            <option>C5</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#categorizacion').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">HERRAMIENTA DE CATEGORIZACION</div>
                    <div class="col l8">
                        <select name="herramienta_cate" id="herramienta_cate">
                            <option>NO APLICA</option>
                            <option>DISCRECIONAL</option>
                            <option>ESTRUCTURADO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#herramienta_cate').jqxDropDownList({
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
                            <option>25 A 29</option>
                            <option>30 A 34</option>
                            <option>35 A 39</option>
                            <option>40 A 44</option>
                            <option>45 A 49</option>
                            <option>50 A 54</option>
                            <option>55 y 59</option>
                            <option>60 y 64</option>
                            <option>65 y 69</option>
                            <option>70 y 74</option>
                            <option>75 y 79</option>
                            <option>80 y MAS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">MORDEDURA</div>
                    <div class="col l8">
                        <select name="mordedura" id="mordedura">
                            <option>SIN CATEGORIZACION</option>
                            <option>PERRO</option>
                            <option>GATO</option>
                            <option>ANIMAL SILVESTRE</option>
                            <option>EXPOSICION A MURCIELAGO</option>
                            <option>ROUEDOR O ANIMAL DE ABASTO</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#mordedura').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EN OBSERVACION</div>
                    <div class="col l8">
                        <select name="en_observacion" id="en_observacion">
                            <option>NO APLICA</option>
                            <option>MENOS A 2 HORAS</option>
                            <option>2 A 6 HORAS</option>
                            <option>MAYOR A 6 HORAS</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#en_observacion').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">FALLECIDO EN UEH</div>
                    <div class="col l8">
                        <select name="fallecido_en" id="fallecido_en">
                            <option>EN ESPERA DE ATENCIÓN MÉDICA</option>
                            <option>EN PROCESO DE ATENCIÓN</option>
                            <option>EN ESPERA DE CAMA HOSPITALARIA</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#fallecido_en').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">ASOCIADA A VIOLENCIA</div>
                    <div class="col l8">
                        <select name="violencia" id="violencia">
                            <option>NO APLICA</option>
                            <option>VIF</option>
                            <option>OTRA</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#violencia').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row" id="anticonceptivo_div">
                    <div class="col l4">ATENCION POR ANTICONCEPTIVO DE EMERGENCIA</div>
                    <div class="col l8">
                        <select name="anticonceptivo_emergencia" id="anticonceptivo_emergencia">
                            <option>NO APLICA</option>
                            <option>CON ENTREGA</option>
                            <option>SIN ENTREGA</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#anticonceptivo_emergencia').jqxDropDownList({
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
                            <div class="settings-label">DEMANDA DE URGENCIA</div>
                            <div class="settings-setter">
                                <div id="urgencia"></div>
                                <input type="hidden" name="input_urgencia" id="input_urgencia" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#urgencia').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#urgencia').on('change',function(){
                                    if($('#urgencia').val()===true){
                                        $("#input_urgencia").val('SI');
                                    }else{
                                        $("#input_urgencia").val('NO');
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
