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
                    <div class="col l4">RANGO EDADES</div>
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
                            <option>60 y 64</option>
                            <option>65 y 69</option>
                            <option>70 y 74</option>
                            <option>75 y 79</option>
                            <option>80 y MAS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col l4">CONDICIÓN</div>
                    <div class="col l8">
                        <select name="tipo_atencion" id="tipo_atencion">
                            <option>INGRESO AL PROGRAMA</option>
                            <option>INASISTENTE</option>
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
                    <div class="col l12">
                        <div class="settings-section">
                            <div class="settings-label">TRANS</div>
                            <div class="settings-setter">
                                <div id="trans"></div>
                                <input type="hidden" name="input_trans" id="input_trans" value="NO" />
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#trans').jqxSwitchButton({
                                    height: 27, width: 81,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#trans').on('change',function(){
                                    if($('#trans').val()===true){
                                        $("#input_trans").val('SI');
                                    }else{
                                        $("#input_trans").val('NO');
                                    }
                                });

                            });
                        </script>
                    </div>
                </div>

        </div>
    </div>
</div>

