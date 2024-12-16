<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';
$id_familia = $_POST['id_familia'];
session_start();
$profesional = new profesional($_SESSION['id_usuario']);
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
                        <input type="date" name="fecha_registro" id="fecha_registro"
                               value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">FECHA TERMINO</div>
                    <div class="col l8">
                        <input type="date" name="fecha_termino" id="fecha_termino"
                               value="" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">OBSERVACIONES</div>
                    <div class="col l8">
                        <textarea id="comentario" name="comentario"></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr />
    <div class="row">
        <input type="button"
               value="INGRESAR PLAN DE INTERNVENCIÓN"
               style="text-align: center;"
               onclick="insertPlanIntervencion()"
               class="btn waves-effect modal-trigger waves-light col s12 " />

    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">

    function insertPlanIntervencion(){
        if(confirm('Esta seguro que desea agregar este Registro')){
            $.post('db/insert/plan_intervencion.php',
                $("#form_vdi").serialize(),function (data){
                    if(data!=='ERROR_SQL'){
                        alertaLateral('ACTUALIZACION EXITOSA!');
                        loadRegistroFamilia('<?php echo $id_familia; ?>');
                        document.getElementById("close_modal").click();

                    }

                });
        }
    }
</script>
