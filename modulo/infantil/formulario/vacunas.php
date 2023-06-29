<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';

$rut = str_replace('.','',$_POST['rut']);
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);
$paciente->calcularEdadFecha($fecha_registro);

//echo $paciente->total_meses;
?>
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
<div class="col l12">
    <strong style="color: red;">(*)</strong> Los cambios son guardados automaticamente
</div>
<div class="col l4">
    <div class="col l12 s12 m12">
        <div class="card-panel eh-open_fondo">
            <div class="row">
                <div class="col l12">
                    INDIQUE LAS VACUNAS QUE VA A SUMINISTRAR DE ACUERDO A LA EDAD DEL PACIENTE.
                </div>
                <div class="col l12">
                    <?php
                    $vacunas = array(2,4,6,12,18,(5*12));

                    //vacuna 2 meses
//                    echo $paciente->total_meses;
                    if($paciente->total_meses>=2){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 2 MESES</div>
                            <div class="settings-setter">
                                <div id="vacuna2m"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vacuna2m').jqxSwitchButton({
                                    height: 27, width: 81,
                                    checked: <?php echo $paciente->vacuna2M()=='SI'?'true':'false'; ?>,
                                    theme: 'eh-open',
                                    onLabel:'SI',
                                    offLabel:'NO',
                                });
                                $('#vacuna2m').on('change',function(){
                                    $.post('db/update/vacuna_2m.php',{
                                        vacuna:$('#vacuna2m').val(),
                                        rut:'<?php echo $paciente->rut; ?>'
                                    },function(data){
                                        loadHistorialVacunas();
                                    });
                                })
                            });
                        </script>
                        <?php
                    }

                    //vacuna 4 meses
                    if($paciente->total_meses>=4){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 4 MESES</div>
                            <div class="settings-setter">
                                <div id="vacuna4m"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vacuna4m').jqxSwitchButton({
                                    height: 27, width: 81,
                                    checked: <?php echo $paciente->vacuna4M()=='SI'?'true':'false'; ?>,
                                    onLabel:'SI',
                                    theme: 'eh-open',
                                    offLabel:'NO',
                                });
                                $('#vacuna4m').on('change',function(){
                                    $.post('db/update/vacuna_4m.php',{
                                        vacuna:$('#vacuna4m').val(),
                                        rut:'<?php echo $rut; ?>'
                                    },function(data){
                                        loadHistorialVacunas();
                                    });
                                });
                            });
                        </script>
                        <?php
                    }

                    //vacuna 6 meses
                    if($paciente->total_meses>=6){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 6 MESES</div>
                            <div class="settings-setter">
                                <div id="vacuna6m"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vacuna6m').jqxSwitchButton({
                                    height: 27, width: 81,
                                    checked: <?php echo $paciente->vacuna6M()=='SI'?'true':'false'; ?>,
                                    onLabel:'SI',
                                    theme: 'eh-open',
                                    offLabel:'NO',
                                });
                                $('#vacuna6m').on('change',function(){
                                    $.post('db/update/vacuna_6m.php',{
                                        vacuna:$('#vacuna6m').val(),
                                        rut:'<?php echo $rut; ?>'
                                    },function(data){
                                        loadHistorialVacunas();
                                    });
                                });
                            });
                        </script>
                        <?php
                    }

                    //vacuna 12 meses
                    if($paciente->total_meses>=12){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 12 MESES</div>
                            <div class="settings-setter">
                                <div id="vacuna12m"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vacuna12m').jqxSwitchButton({
                                    height: 27, width: 81,
                                    checked: <?php echo $paciente->vacuna12M()=='SI'?'true':'false'; ?>,
                                    onLabel:'SI',
                                    theme: 'eh-open',
                                    offLabel:'NO',
                                });
                                $('#vacuna12m').on('change',function(){
                                    $.post('db/update/vacuna_12m.php',{
                                        vacuna:$('#vacuna12m').val(),
                                        rut:'<?php echo $rut; ?>'
                                    },function(data){
                                        loadHistorialVacunas();
                                    });
                                });
                            });
                        </script>
                        <?php
                    }

                    //vacuna 18 meses
                    if($paciente->total_meses>=18){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 18 MESES</div>
                            <div class="settings-setter">
                                <div id="vacuna18m"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $(function(){
                                    $('#vacuna18m').jqxSwitchButton({
                                        height: 27, width: 81,
                                        checked: <?php echo $paciente->vacuna18M()=='SI'?'true':'false'; ?>,
                                        onLabel:'SI',
                                        theme: 'eh-open',
                                        offLabel:'NO',
                                    });
                                    $('#vacuna18m').on('change',function(){
                                        $.post('db/update/vacuna_18m.php',{
                                            vacuna:$('#vacuna18m').val(),
                                            rut:'<?php echo $rut; ?>'
                                        },function(data){
                                            loadHistorialVacunas();
                                        });
                                    });

                                });
                            });
                        </script>
                        <?php
                    }
                    //3 años
                    if($paciente->total_meses>=(12*3)){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 3 AÑOS</div>
                            <div class="settings-setter">
                                <div id="vacuna3anios"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vacuna3anios').jqxSwitchButton({
                                    height: 27, width: 81,
                                    checked: <?php echo $paciente->vacuna3Anios()=='SI'?'true':'false'; ?>,
                                    onLabel:'SI',
                                    theme: 'eh-open',
                                    offLabel:'NO',
                                });
                                $('#vacuna3anios').on('change',function(){
                                    $.post('db/update/vacuna_5anios.php',{
                                        vacuna:$('#vacuna3anios').val(),
                                        rut:'<?php echo $rut; ?>'
                                    },function(data){
                                        loadHistorialVacunas();
                                    });
                                });
                            });
                        </script>
                        <?php
                    }


                    //5 años
                    if($paciente->total_meses>=(12*6)){
                        ?>
                        <div class="settings-section">
                            <div class="settings-label">VACUNA 1 BASICO</div>
                            <div class="settings-setter">
                                <div id="vacuna5anios"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function(){
                                $('#vacuna5anios').jqxSwitchButton({
                                    height: 27, width: 81,
                                    checked: <?php echo $paciente->vacuna5Anios()=='SI'?'true':'false'; ?>,
                                    onLabel:'SI',
                                    theme: 'eh-open',
                                    offLabel:'NO',
                                });
                                $('#vacuna5anios').on('change',function(){
                                    $.post('db/update/vacuna_5anios.php',{
                                        vacuna:$('#vacuna5anios').val(),
                                        rut:'<?php echo $rut; ?>'
                                    },function(data){
                                        loadHistorialVacunas();
                                    });
                                });
                            });
                        </script>
                        <?php
                    }


                ?>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col l4">.</div>
<div class="col l4">
    <div class="card-panel cyan lighten-2">
        <div class="row">
            <header ONCLICK="loadHistorialVacunas()">HISTORIAL DE VACUNAS - INFANTIL</header>
            <div class="col l12" id="div_historialVacunas">

            </div>

        </div>
    </div>
</div>
