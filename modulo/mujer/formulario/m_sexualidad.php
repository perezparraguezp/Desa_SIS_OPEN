<?php

include "../../../php/config.php";
include "../../../php/objetos/persona.php";

$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);



$lubricante  = $paciente->getParametroTabla_M('practica_sexual_mujer','lubricante');
$regulacion_mas_preservativo  = $paciente->getParametroTabla_M('practica_sexual_mujer','regulacion_mas_preservativo');
$condon_femenino  = $paciente->getParametroTabla_M('practica_sexual_mujer','condon_femenino');
$preservativo_masculino  = $paciente->getParametroTabla_M('practica_sexual_mujer','preservativo_masculino');




?>
<style type="text/css">
    a{
        color: white;;
    }
</style>
<form class="content card-panel">
    <input type="hidden" name="fecha_antecedentes" id="fecha_antecedentes" value="<?php echo $fecha_registro; ?>" />
    <div class="row">
        <div class="col l6 m12 s12">
            <!-- HORMONAL -->
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="card-panel eh-open_fondo">
                        <div class="row">
                            <div class="col l8 m8 s8">
                                <strong style="line-height: 2em;font-size: 1.5em;">REGULACION DE FERTILIDAD <strong class="tooltipped" style="cursor: help" data-position="bottom" data-delay="50" data-tooltip="EL REGISTRO SERÁ GUARDADO AUTOMATICAMENTE">(?)</strong></strong>
                                <br /><strong style="background-color: #758fff;padding: 3px;cursor: help;" onclick="$('.H_SUSPENDIDA').show();$('.H_VENCIDA').show()">VER HISTORIAL</strong>
                            </div>
                            <div class="col l4 m4 s4">
                                <div class="btn blue" onclick="boxNewHormonal()"> + AGREGAR </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l2 s2 m2">DESDE</div>
                            <div class="col l6 s6 m6">TIPO</div>
                            <div class="col l2 s2 m2">VENCIMIENTO</div>
                            <div class="col l2 s2 m2"></div>
                        </div>
                        <hr class="row" />
                        <?php
                        $sql1 = "select * from mujer_historial_hormonal 
                                    where rut='$rut' 
                                    order by id_historial desc";

                        $res1 = mysql_query($sql1);
                        while($row1 = mysql_fetch_array($res1)){
                            ?>
                            <div class="row tooltipped rowInfoSis <?php echo 'H_'.$row1['estado_hormona']; ?>"
                                 data-position="bottom" data-delay="50"
                                 data-html="true"
                                 data-tooltip='Estado: <?php echo $row1['estado_hormona']; ?> | Obs: <?php echo $row1['observacion'].' - '.($row1['obs_retiro_hormonal']!=''?"RETIRADA POR: ".$row1['obs_retiro_hormonal']:''); ?>' >
                                <div class="col l2 s2 m2"><?PHP echo fechaNormal($row1['fecha_registro']); ?></div>
                                <div class="col l6 s6 m6"><?PHP echo $row1['tipo']; ?></div>
                                <div class="col l2 s2 m2"><?PHP echo fechaNormal($row1['vencimiento']); ?></div>
                                <div class="col l2 s2 m2">
                                    <?PHP
                                    if($row1['fecha_registro']==date('Y-m-d')){
                                        ?>
                                        <a href="#" style="color: rgba(255,95,105,0.86);font-weight: bold;" onclick="deleteHormonaSQL('<?php echo $row1['id_historial']; ?> ')">ELIMINAR</a>
                                    <?php
                                    }else{
                                        $estado_hormona = $row1['estado_hormona'];
                                        if($estado_hormona=='ACTIVA'){
                                            if($row1['vencimiento'] > date('Y-m-d')){
                                                //activa sin vencer
                                                ?>
                                                <a href="#" style="color: rgba(255,95,105,0.86);font-weight: bold;" onclick="boxRetiroHormonalAnticipado('<?php echo $row1['id_historial']; ?> ')">RETIRO ANTICIPADO</a>
                                                <?php
                                            }else{
                                                //activa vencida
                                                ?>
                                                <a href="#" style="color: rgba(255,95,105,0.86);font-weight: bold;background-color: #fffa20;" onclick="boxRetiroHormonalAnticipado('<?php echo $row1['id_historial']; ?> ')" >VENCIDA SIN OBS</a>
                                                <?php
                                            }
                                        }else{
                                            $suspendida = 'SUSPENDIDA <br />['.fechaNormal($row1['fecha_retiro_hormonal']).']';
                                            ?>
                                            <a href="#" style="color: rgba(255,95,105,0.86);font-weight: bold;color: white;" ><?PHP echo $suspendida; ?></a>
                                            <?php
                                        }


                                    }

                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <hr class="row" />
                        <div class="row H_VENCIDA right-align">
                            <strong style="background-color: #758fff;padding: 3px;cursor: help;" onclick="$('.H_SUSPENDIDA').hide();$('.H_VENCIDA').hide()">OCULTAR HISTORIAL</strong>
                        </div>
                        <style type="text/css">
                            .H_ACTIVA{
                                display: block;
                                cursor: pointer;
                            }
                            .H_SUSPENDIDA{
                                display: none;
                                background-color: #ff5f69;
                                cursor: pointer;
                            }
                            .H_VENCIDA{
                                display: none;
                                background-color: yellow;
                                cursor: pointer;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l6 m12 s12">
            <!-- PRACTICA SEXUAL SEGURA  -->
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="card-panel eh-open_fondo">
                        <div class="row">
                            <div class="col l12 m12 s12">
                                <strong style="line-height: 2em;font-size: 1.5em;">PRÁCTICA SEXUAL SEGURA <strong class="tooltipped" style="cursor: help" data-position="bottom" data-delay="50" data-tooltip="EL REGISTRO SERÁ GUARDADO AUTOMATICAMENTE">(?)</strong></strong>
                            </div>
                            <div class="col l12 m12 s12">
                                <div class="row">
                                    <div class="col l12 m12 s12">
                                        <input type="checkbox" id="regulacion_mas_preservativo"
                                               onchange="updateIndicadorM_sexual('regulacion_mas_preservativo')"
                                            <?php echo $regulacion_mas_preservativo=='SI'?'checked="checked"':'' ?>
                                               name="regulacion_mas_preservativo"  />
                                        <label class="black-text" for="regulacion_mas_preservativo">REGULACIÓN FERTILIDAD MAS PRESERVATIVO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col l12 m12 s12">
                                <div class="row">
                                    <div class="col l12 m12 s12">
                                        <input type="checkbox" id="lubricante"
                                               onchange="updateIndicadorM_sexual('lubricante')"
                                            <?php echo $lubricante=='SI'?'checked="checked"':'' ?>
                                               name="lubricante"  />
                                        <label class="black-text" for="lubricante">LUBRICANTE</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col l12 m12 s12">
                                <div class="row">
                                    <div class="col l12 m12 s12">
                                        <input type="checkbox" id="condon_femenino"
                                               onchange="updateIndicadorM_sexual('condon_femenino')"
                                            <?php echo $condon_femenino=='SI'?'checked="checked"':'' ?>
                                               name="condon_femenino"  />
                                        <label class="black-text" for="condon_femenino">CONDÓN FEMENINO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col l12 m12 s12">
                                <div class="row">
                                    <div class="col l12 m12 s12">
                                        <input type="checkbox" id="preservativo_masculino"
                                               onchange="updateIndicadorM_sexual('preservativo_masculino')"
                                            <?php echo $preservativo_masculino=='SI'?'checked="checked"':'' ?>
                                               name="preservativo_masculino"  />
                                        <label class="black-text" for="preservativo_masculino">PRESERVATIVO MASCULINO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<style type="text/css">
    .hoverClass:hover{
        background-color: #f1ffc5;
    }
    .rowInfoSis:hover{
        background-color: #f1ffc5;
        cursor: help;
    }
    .tooltip-inner {
        white-space: pre-wrap;
    }
</style>


<script type="text/javascript">
    $(function () {
        $('.tooltipped').tooltip({delay: 50});

    });
    function deleteHormonaSQL(historial){
        if(confirm("Desea Eliminar este registro de Hoy")){
            $.post('db/delete/hormona.php',{
                id_historial:historial,
                rut:'<?php echo $rut ?>'
            },function(data){
                if(data !== 'ERROR_SQL'){
                    load_m_sexualidad('<?php echo $rut; ?>');
                }
            });
        }
    }
    function boxNewHormonal(){
        $.post('formulario/new_hormonal.php',{
            rut:'<?php echo $rut ?>',
            fecha_registro:'<?php echo $fecha_registro ?>',
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }

    function boxRetiroHormonalAnticipado(id_historial){
        $.post('formulario/retiro_hormonal_anticipado.php',{
            rut:'<?php echo $rut ?>',
            id_historial:id_historial
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }

    function updateIndicadorM_sexual(indicador){
        var value = '';
        if($('#'+indicador).prop('checked')){
            value = 'SI';
        }else{
            value = 'NO';
        }
        var fecha = $("#fecha_antecedentes").val();
        $.post('db/update/m_indicador_sexualidad.php',{
            column:indicador,
            value:value,
            fecha_registro:fecha,
            rut:'<?php echo $rut ?>'
        },function (data) {
            alertaLateral(data);
        });
    }
    function updateIndicadorM(indicador) {
        var value = $('#'+indicador).val();
        var fecha = $("#fecha_antecedentes").val();
        $.post('db/update/m_indicador.php',{
            column:indicador,
            value:value,
            fecha_registro:fecha,
            rut:'<?php echo $rut ?>'
        },function (data) {
            alertaLateral(data);
        });
    }

    function updateParametroM_IMC(value) {
        var fecha = $("#fecha_imc").val();
        $.post('db/update/m_parametros.php',{
            column:'imc',
            value:value,
            fecha_registro:fecha,
            rut:'<?php echo $rut ?>'
        },function (data) {
            alertaLateral(data);
        });
    }
    function loadHistorialParametro_M(rut,indicador) {
        $.post('grid/historial_parametros_m.php',{
            rut:rut,
            indicador:indicador
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
</script>
