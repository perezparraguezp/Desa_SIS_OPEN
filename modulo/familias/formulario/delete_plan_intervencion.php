<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';
$id_familia = $_POST['id_familia'];
$id_registro = $_POST['id_registro'];
session_start();
$profesional = new profesional($_SESSION['id_usuario']);
$sql = "select * from historial_plan_intervencion_familia where id_registro='$id_registro' limit 1";
$row = mysql_fetch_array(mysql_query($sql));
$profesional_registro = new profesional($row['id_profesional']);
?>
<style type="text/css">
    #form_paciente input{
        text-align: left;
    }
</style>
<form name="form_vdi"
      id="form_vdi" class="card-panel left-align">
    <input type="hidden" name="id_familia" value="<?php echo $id_familia; ?>" />
    <input type="hidden" name="id_profesional" value="<?php echo $profesional->id_profesional; ?>" />
    <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>" />
    <input type="hidden" name="json" value="<?php echo base64_encode(json_encode($row)); ?>" />
    <script type="text/javascript">
        $(document).ready(function () {
            // Create jqxNavigationBar
            $("#jqxNavigationBar").jqxNavigationBar({ width: '100%',theme: 'eh-open', height: 460});
        });
    </script>

    <div id='jqxNavigationBar'>
        <div>PROFESIONAL QUE REGISTRA: <?php echo $profesional->nombre; ?></div>
        <div style="padding: 20px;">

            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">FECHA REGISTRO</div>
                    <div class="col l8">
                        <input type="date" disabled="disabled" name="fecha_registro" id="fecha_registro"
                               value="<?php echo $row['fecha_registro']; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">COMENTARIOS</div>
                    <div class="col l8">
                        <textarea disabled="disabled" id="comentario" name="comentario"><?php echo $row['comentario']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">PROFESIONAL</div>
                    <div class="col l8">
                        <strong><?php echo $profesional_registro->nombre; ?></strong>
                    </div>
                </div>
            </div>

            <div class="card-panel green lighten-5" id="div_egreso">
                <header>INDICAR SI LA FAMILIA EGRESARA DEL PLAN DE INTERVENCION</header>
                <div class="row">
                    <div class="col l12 m12 s12">
                        <div class="col l4">TIPO DE EGRESO DEL PLAN</div>
                        <div class="col l8">
                            <select name="tipo_egreso" id="tipo_egreso">
                                <option>CUMPLIMIENTO DEL PLAN</option>
                                <option>TRASLADO DE ESTABLECIMIENTO</option>
                                <option>DERIVACION POR COMPLEJIDAD</option>
                                <option>ABANDONO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col l12 m12 s12">
                        <div class="col l4">EGRESO DEL PLAN</div>
                        <div class="col l8">
                            <textarea name="egreso" id="egreso" placeholder="EN CASO QUE LA FAMILIA CUMPLA EL PLAN DE INTERVENSION, EL PROFESIONAL DEBERA INDICARLO MEDIANTE ESTE FORMULARIO"><?php echo $row['motivo_egreso']; ?></textarea>
                        </div>
                    </div>
                    <div class="col l12 m12 s12">
                        <div class="col l4">FECHA EGRESO</div>
                        <div class="col l8">
                            <input type="date" name="fecha_egreso" id="fecha_egreso" value="<?php echo $row['fecha_egreso']==''?date('Y-m-d'):$row['fecha_egreso']; ?>" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col l6">
            <input type="button"
                   value="ELIMINAR PLAN DE INTERVENCION"
                   style="text-align: center;"

                   <?php echo $row['estado']=='EGRESADO'?'onclick="alertaLateral(\'NO PUEDE ELIMINAR UN PLAN YA EGRESADO\')"':'onclick="deletePlanIntervencion2()" '; ?>

                   class="btn waves-effect modal-trigger red darken-1 col s12 " />
        </div>
        <div class="col l6">
            <input type="button"
                   value="EGRESAR DEL PLAN DE INTERVENCION"
                   style="text-align: center;"
                   onclick="egresarPlanIntervencion()"
                   class="btn waves-effect modal-trigger green lighten-1  col s12 " />
        </div>

    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">

    function deletePlanIntervencion2(){
        $.post('db/delete/plan_intervencion.php',
            $("#form_vdi").serialize(),function (data){
                if(data!=='ERROR_SQL'){
                    alertaLateral('ELIMINACION EXITOSA!');
                    loadRegistroFamilia('<?php echo $id_familia; ?>');
                    document.getElementById("close_modal").click();

                }

            });
    }
    function egresarPlanIntervencion(){
        var egreso = $("#egreso").val();
        if(egreso!==''){
            $.post('db/update/plan_intervencion.php',
                $("#form_vdi").serialize(),function (data){
                    if(data!=='ERROR_SQL'){
                        alertaLateral('ELIMINACION EXITOSA!');
                        //loadRegistroFamilia('<?php //echo $id_familia; ?>//');
                        loadMenu_M('menu_3','registro_familia','<?php echo $id_familia; ?>');
                        document.getElementById("close_modal").click();

                    }

                });
        }else{
            $("#egreso").css({
                "border":"solid 2px red",
                "background-color":"#ffeced"
            });
            $("#div_egreso").css({
                "border":"solid 2px red"
            });
            $("#egreso").focus();
            alertaLateral('DEBE INGRESAR EL MOTIVO DEL EGRESO');
        }
    }
</script>
