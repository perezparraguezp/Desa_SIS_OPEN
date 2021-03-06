<?php

include "../../../php/config.php";
include "../../../php/objetos/persona.php";

$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];
$paciente = new persona($rut);

$educacion =  $paciente->getParametro_AD('educacion');


?>

<form class="content card-panel">
    <input type="hidden" name="fecha_funcionalidad" id="fecha_funcionalidad" value="<?php echo $fecha_registro; ?>" />
    <div class="row">
        <div class="col l4 m12 s12">
            <!-- IMC  -->
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="card-panel eh-open_fondo" style="font-size: 1em;">
                        <div class="row">
                            <div class="col l12 m12 s12">
                                <div class="row hover-eh-open">
                                    <div class="col l10 m10 s10">ESTUDIANTE</div>
                                    <div class="col l2 m2 s2">
                                        <input type="radio"
                                               style="position: relative;visibility: visible;left: 0px;"
                                               onclick="updateIndicadorEducacionAD('educacion','ESTUDIANTE'),loadHistorialParametroAD('<?php echo $rut; ?>','educacion');"
                                               id="ed_ESTUDIANTE" name="educacion" value="ESTUDIANTE" />
                                    </div>
                                </div>
                                <div class="row hover-eh-open">
                                    <div class="col l10 m10 s10">DESERCIÓN ESCOLAR</div>
                                    <div class="col l2 m2 s2">
                                        <input type="radio"
                                               style="position: relative;visibility: visible;left: 0px;"
                                               onclick="updateIndicadorEducacionAD('educacion','DESERCION'),loadHistorialParametroAD('<?php echo $rut; ?>','educacion');"
                                               id="ed_DESERCION" name="educacion" value="DESERCION" />
                                    </div>
                                </div>
                                <div class="row hover-eh-open">
                                    <div class="col l10 m10 s10">PEORES FORMA DE TRABAJO INFANTIL</div>
                                    <div class="col l2 m2 s2">
                                        <input type="radio"
                                               style="position: relative;visibility: visible;left: 0px;"
                                               onclick="updateIndicadorEducacionAD('educacion','PEOR'),loadHistorialParametroAD('<?php echo $rut; ?>','educacion');"
                                               id="ed_PEOR" name="educacion" value="PEOR" />
                                    </div>
                                </div>
                                <?php
                                if($paciente->edad_anios < 15 ){
                                    ?>
                                    <div class="row hover-eh-open">
                                        <div class="col l10 m10 s10">TRABAJO INFANTIL</div>
                                        <div class="col l2 m2 s2">
                                            <input type="radio"
                                                   style="position: relative;visibility: visible;left: 0px;"
                                                   onclick="updateIndicadorEducacionAD('educacion','TRABAJO_INFANTIL'),loadHistorialParametroAD('<?php echo $rut; ?>','educacion');"
                                                   id="ed_TRABAJO" name="educacion" value="TRABAJO_INFANTIL" />
                                        </div>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="row hover-eh-open">
                                        <div class="col l10 m10 s10">TRABAJO JUVENIL</div>
                                        <div class="col l2 m2 s2">
                                            <input type="radio"
                                                   style="position: relative;visibility: visible;left: 0px;"
                                                   onclick="updateIndicadorEducacionAD('educacion','TRABAJO_JUVENIL'),loadHistorialParametroAD('<?php echo $rut; ?>','educacion');"
                                                   id="ed_TRABAJO" name="educacion" value="TRABAJO_JUVENIL" />
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>


                                <div class="row hover-eh-open">
                                    <div class="col l10 m10 s10">SERVICIO DOMESTICO NO REMUNERADO PELIGROSO</div>
                                    <div class="col l2 m2 s2">
                                        <input type="radio"
                                               style="position: relative;visibility: visible;left: 0px;"
                                               onclick="updateIndicadorEducacionAD('educacion','SERVICIO'),loadHistorialParametroAD('<?php echo $rut; ?>','educacion');"
                                               id="ed_SERVICIO" name="educacion" value="SERVICIO" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l2 m12 s12" style="padding: 30px;">
            -
        </div>
        <div class="col l6 m12 s12" style="background-color: #f1ffc5;padding: 10px;">
            <header style="padding-left: 10px;">HISTORIAL</header>
            <div class="container" id="infoHistotialFuncionalidad"></div>
        </div>

    </div>
</form>
<script type="text/javascript">
    $(function () {
        $("#ed_<?php echo $educacion; ?>").attr('checked','cheched');
        //DM
        loadHistorialParametroAD('<?php echo $rut; ?>','educacion');
        $('.tooltipped').tooltip({delay: 50});
    });
    function loadHistorialParametroAD(rut,indicador) {
        $.post('grid/historial_parametros_ad.php',{
            rut:rut,
            indicador:indicador
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#infoHistotialFuncionalidad").html(data);
                $("input:radio[value='<?php echo $paciente->getParametro_AM('funcionalidad'); ?>']").prop('checked',true);
            }
        });
    }

</script>
