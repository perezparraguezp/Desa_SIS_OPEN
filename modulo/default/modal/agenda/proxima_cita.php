<?php
include '../../../../php/config.php';
include '../../../../php/objetos/persona.php';
session_start();
$myId = $_SESSION['id_usuario'];
$id_establecimiento = $_SESSION['id_establecimiento'];
$rut = $_POST['rut'];
$p = new persona($rut);

$modulo = $_POST['modulo'];

$meses = Array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
?>
<form id="form_agendamiento" class="modal-content">
    <input type="hidden" name="rut" value="<?php echo $rut; ?>" />
    <div class="card-panel" style="padding: 10px;margin: 0px;">
        <div class="row col l12" style="margin-bottom: 0px;">
            <div class="col l8 light-blue-text">AGENDAR PROXIMA ATENCIÓN</div>
        </div>
        <div class="row col l12" style="font-size: 0.8em;margin-bottom: 0px;">
            Paciente: <?php echo $p->nombre; ?>
        </div>
        <hr class="row" />
        <div class="row center-align" style="font-size: 0.8em;margin-bottom: 0px;">
            <div class="col l12 card-panel">
                <div class="row orange center-align" style="padding: 5px;">
                    MODULO
                </div>
                <div class="row">
                    <select id="modulo" name="modulo">
                        <?php

                        $sql = "select * from modulos_ehopen 
                                                inner join modulos_establecimiento using(id_modulo)
                                                where id_establecimiento='$id_establecimiento' 
                                                and estado_modulo='ACTIVO' 
                                                order by id_modulo";
                        $res = mysql_query($sql);
                        $i = 0;
                        while($row = mysql_fetch_array($res)){
                            $select = '';
                            if($modulo == $row['nombre_modulo']){
                                $select = 'selected="selected"';
                            }else{
                                $select = '';
                            }
                            ?>
                            <option <?php echo $select; ?>><?php echo $row['nombre_modulo']; ?></option>
                            <?php
                            $i++;

                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col l4 card-panel">
                <div class="row orange center-align" style="padding: 5px;">
                    AÑO
                </div>
                <div class="row">
                    <select name="anio_cita" id="anio_cita">
                        <option><?php echo date('Y')-3; ?></option>
                        <option><?php echo date('Y')-2; ?></option>
                        <option><?php echo date('Y')-1; ?></option>
                        <option selected="selected"><?php echo date('Y'); ?></option>
                        <option><?php echo date('Y')+1; ?></option>
                        <option><?php echo date('Y')+2; ?></option>
                    </select>
                </div>
            </div>
            <div class="col l4 card-panel">
                <div class="row orange center-align" style="padding: 5px;">
                    MES
                </div>
                <div class="row">
                    <select name="mes_cita" id="mes_cita">
                        <?php
                        foreach ($meses as $i => $mes){
                            if($i>0){
                                if($i == date('m')){
                                    ?>
                                    <option selected="selected" value="<?php echo $i; ?>"><?php echo $mes; ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $mes; ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>

                </div>
            </div>
            <div class="col l4 card-panel">
                <div class="row orange center-align" style="padding: 5px;">
                    PROFESIONAL
                </div>
                <div class="row">
                    <select name="profesional_cita" id="profesional_cita">
                        <?php
                        $sql = "select * from personal_establecimiento
                                    where 
                                          UPPER(tipo_contrato)!='ADMINISTRADOR'
                                    AND UPPER(tipo_contrato)!='DIGITADOR'
                                    group by tipo_contrato ";
                        $res = mysql_query($sql);
                        while($row = mysql_fetch_array($res)) {

                            ?>
                            <option><?php echo $row['tipo_contrato']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <script type="text/javascript">

                    </script>
                </div>
            </div>


        </div>

        <hr class="row" />
        <div class="row">
            <div class="col l6">
                <input type="button"
                       style="width: 100%;"
                       value="--> NO AGENDAR <--"
                       onclick="noAgendar()"
                       class="btn-large red darken-2 white-text"/>
            </div>
            <div class="col l6">
                <input type="button"
                       style="width: 100%;"
                       value="--> AGENDAR <--"
                       onclick="insertAgendamiento()"
                       class="btn-large light-green darken-3"/>
            </div>
        </div>
    </div>
    <div class="card blue lighten-5 black-text" style="padding: 10px;">
        <div class="row">
            <div class="col l12 m12 s12">
                <header>CITAS PENDIENTES</header>
            </div>
        </div>
        <div class="row deep-purple lighten-4">
            <div class="col l3 m3 s3" style="text-align: right;padding-right: 20px;">FECHA</div>
            <div class="col l4 m4 s4">PROFESIONAL</div>
            <div class="col l3 m3 s3">MODULO</div>
            <div class="col l2 m4 s2">FINALIZAR</div>
        </div>
        <div style="height: 100px;overflow-y: scroll;">
            <?php
            $sql = "select * from agendamiento
          where rut='$rut' 
          and estado_control='PENDIENTE'  
          order by anio_proximo_control,mes_proximo_control ";

            $res = mysql_query($sql);
            while($row = mysql_fetch_array($res)) {
                ?>
                <div class="row">
                    <div class="col l1 m1 s1">
                        <?php
                        if($row['id_profesional']==$myId){
                            ?>
                            <i class="mdi-action-delete red-text"
                               onclick="deleteAgendamiento('<?php echo $row['id_agendamiento']; ?>')"
                               style="cursor: pointer;"></i>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col l2 m2 s2" style="text-align: center"><?php echo $meses[$row['mes_proximo_control']].'/'.$row['anio_proximo_control']; ?></div>
                    <div class="col l4 m4 s4"><?php echo $row['profesional']; ?></div>
                    <div class="col l3 m3 s3"><?php echo 'SIS '.$row['modulo']; ?></div>
                    <div class="col l2 m4 s2">
                        <input type="button" value="REALIZADA" onclick="finalizarCitaSalud('<?php echo $row['id_agendamiento']; ?>')" />
                    </div>
                </div>
                <?php
            }
            ?>
        </div>


    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">
    function insertAgendamiento() {
        $.post('../default/db/insert/agendamiento.php',
            $("#form_agendamiento").serialize(),function(data){
                alertaLateral(data);
                if(confirm('QUIERE AGREGAR OTRO AGENDAMIENTO')){
                    boxAgendamiento();
                }else{
                    // volverFichaSearch_1();
                    document.getElementById("close_modal").click();
                }


            });
    }

    function deleteAgendamiento(id){
        if(confirm('DESEA ELIMINAR ESTE REGISTRO')){
            $.post('../default/db/delete/agendamiento.php',{
                id:id
            },function (data) {
                if(data!=='ERROR_SQL'){
                    alertaLateral('REGISTRO ELIMINADO');
                    boxAgendamiento();
                }
            });
        }
    }
    function finalizarCitaSalud(id){
        $.post('../default/db/update/agendamiento.php',
            {
                id:id
            },function(data){
                // document.getElementById("close_modal").click();
                boxAgendamiento();
            });
    }
    function noAgendar(){
        // volverFichaSearch();
        $("#modal").css({'width':'950px'});
        document.getElementById("close_modal").click();
    }
</script>
