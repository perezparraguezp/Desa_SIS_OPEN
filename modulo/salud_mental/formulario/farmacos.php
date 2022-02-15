<?php

include "../../../php/config.php";
include "../../../php/objetos/persona.php";
include "../../../php/objetos/profesional.php";

$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);

?>
<style type="text/css">
    a{
        color: white;;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col l10 m10 s10">
            <!--  PAP -->
            <div class="card-panel eh-open_fondo">
                <div class="row">
                    <div class="col l8 m8 s8">
                        <strong style="line-height: 2em;font-size: 1.5em;">HISTORIAL DE FARMACOS <strong class="tooltipped"
                                                                                                             style="cursor: help" data-position="bottom" data-delay="50" data-tooltip="EL REGISTRO SERÁ GUARDADO AUTOMATICAMENTE">(?)</strong></strong>
                    </div>
                    <div class="col l4 m4 s4">
                        <div class="btn blue" onclick="boxNewFarmaco()"> + AGREGAR </div>
                    </div>
                </div>
                <hr class="row" />
                <div class="row">
                    <div class="col l2 s2 m2">FECHA INGRESO</div>
                    <div class="col l8 s8 m8">TIPO FARMACO</div>
                    <div class="col l2 s2 m2">FECHA EGRESO</div>
                </div>
                <hr class="row" />
                <?php
                $sql1 = "SELECT * FROM paciente_farmacos_sm 
                            where rut='$rut'  
                            order by id_registro desc";
                $res1 = mysql_query($sql1);
                while($row1 = mysql_fetch_array($res1)){
                    ?>
                    <div class="row rowInfoSis" >
                        <div class="col l2 s4 m2"><?PHP echo fechaNormal($row1['fecha_inicio']).' 
                                <strong class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="OBS INGRESO: '.$row1['obs'].'">(?)</strong>'; ?></div>
                        <div class="col l5 s5 m5"><?PHP echo $row1['nombre_farmaco']; ?></div>
                        <div class="col l2 s2 m2">
                            <?PHP

                            if($row1['fecha_inicio']==$fecha_registro){
                                ?>
                                <a href="#" onclick="delete_farmaco('<?php echo $row1['id_registro']; ?>')">ELIMINAR</a>
                                <?php
                            }else{
                                if($row1['fecha_egreso']==''){
                                    ?>
                                    <a href="#" onclick="AltaFarmaco('<?php echo $row1['id_registro']; ?>')">DAR ALTA</a>
                                    <?php
                                }else{
                                    echo fechaNormal($row1['fecha_egreso']).' <strong class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="OBS EGRESO: '.$row1['obs_alta'].'">(?)</strong>';
                                }

                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.tooltipped').tooltip({delay: 50});
    });
    function AltaFarmaco(id){
        $.post('formulario/alta_farmaco.php',{
            rut:'<?php echo $rut ?>',
            id:id
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function delete_farmaco(id){
        if(confirm("Desea Eliminar este Farmaco")){
            $.post('db/delete/farmaco.php',{
                id:id,
                rut:'<?php echo $rut ?>'
            },function(data){
                if(data !== 'ERROR_SQL'){
                    load_sm_diagnosticos('<?php echo $rut; ?>');
                }
            });
        }
    }
    function boxNewFarmaco(){
        $.post('formulario/new_farmaco.php',{
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
    function boxNewVph(){
        $.post('formulario/new_vph.php',{
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
    function boxNewEcoMamaria(){
        $.post('formulario/new_ecomamaria.php',{
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
    function boxNewMamografia(){
        $.post('formulario/new_mamografia.php',{
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
    function boxNewEXAMENFISICOMAMAS(){
        $.post('formulario/new_examen_mamas.php',{
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

</script>
