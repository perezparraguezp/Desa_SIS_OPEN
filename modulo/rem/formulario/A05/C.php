
<script type="text/javascript">
    $(function(){

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
                    <div class="col l4">TIPO</div>
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
                                        $('.ingreso').hide();
                                    }else{
                                        $('.ingreso').show();
                                    }

                                })

                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">EDAD</div>
                    <div class="col l8">
                        <select name="edad" id="edad">
                            <option>MENOR 15 </option>
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
                            <option>70 Y MAS</option>
                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#edad').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                            });
                        </script>
                    </div>
                </div>
                <div class="row ingreso">
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
                <div class="row ingreso">
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">Ingreso por Cambio de Método Anticonceptivo</div>
                            <div class="settings-setter">
                                <div id="anticonceptivo"></div>
                                <input type="hidden" name="input_anticonceptivo" id="input_anticonceptivo" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#anticonceptivo').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#anticonceptivo').on('change',function(){
                                    if($('#anticonceptivo').val()===true){
                                        $("#input_anticonceptivo").val('SI');
                                    }else{
                                        $("#input_anticonceptivo").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col l4">TIPO HORMONA</div>
                    <div class="col l8">
                        <select name="tipo_hormona" id="tipo_hormona">
                            <option>D.I.U. T COBRE</option>
                            <option>D.I.U. LEVONORGESTREL</option>
                            <option>ORAL COMBINADO</option>
                            <option>ORAL PROGESTAGENO</option>
                            <option>INYECTABLE COMBINADO</option>
                            <option>INYECTABLE ETONOGESTREL</option>
                            <option>IMPLANTE LEVONORGESTREL</option>
                            <option>PRESERVATIVO MAC</option>
                            <option>ESTERILIZACION QUIRURGICA</option>
                            <option>REGULACION DE FERTILIDAD + PRESERVATIVO</option>
                            <option>GESTANTES QUE RECIBEN PRESERVATIVO</option>
                            <option>PRESERVATIVO</option>
                            <option>LUBRICANTE</option>
                            <option>CONDON FEMENINO</option>

                        </select>
                        <script type="text/javascript">
                            $(function(){
                                $('#tipo_hormona').jqxDropDownList({
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
