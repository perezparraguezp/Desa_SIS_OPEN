<?php
include '../../../../php/config.php';
include '../../../../php/objetos/familia.php';
session_start();
$myId = $_SESSION['id_usuario'];
$id_establecimiento = $_SESSION['id_establecimiento'];
$rut = $_POST['rut'];
$p = new familia($rut);

$modulo = $_POST['modulo'];

$meses = Array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
?>
<form id="form_agendamiento" class="modal-content">
    <input type="hidden" name="rut" value="<?php echo $rut; ?>" />
    <div class="card-panel" style="padding: 10px;margin: 0px;">
        <div class="row col l12" style="margin-bottom: 0px;">
            <div class="col l8 light-blue-text">DERIVAR EL CASO</div>
        </div>
        <div class="row col l12" style="font-size: 0.8em;margin-bottom: 0px;">
            FAMILIA: <?php echo $p->nombre; ?>
        </div>
        <hr class="row" />
        <div class="row center-align" style="font-size: 0.8em;margin-bottom: 0px;">
            <div class="col l12 card-panel">
                <div class="row orange center-align" style="padding: 5px;">
                    PROFESIONAL
                </div>
                <div class="row">
                    <select name="profesional_cita" id="profesional_cita">
                        <?php
                        $sql = "select * from personal_establecimiento
                                    inner join persona p on personal_establecimiento.rut = p.rut
                                    where 
                                          UPPER(tipo_contrato)!='ADMINISTRADOR'
                                    AND UPPER(tipo_contrato)!='DIGITADOR'
                                    order by nombre_completo";
                        $res = mysql_query($sql);
                        while($row = mysql_fetch_array($res)) {

                            ?>
                            <option value="<?php echo $row['rut']; ?>"><?php echo $row['nombre_completo']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row center-align" style="font-size: 0.8em;margin-bottom: 0px;">
            <div class="col l12 card-panel">
                <div class="row orange center-align" style="padding: 5px;">
                    MENSAJE
                </div>
                <div class="row">
                    <textarea name="mensaje"></textarea>
                </div>
            </div>
        </div>

        <hr class="row" />
        <div class="row">
            <div class="col l6">
                <input type="button"
                       style="width: 100%;"
                       value="--> NO DERIVAR <--"
                       onclick="noAgendar()"
                       class="btn-large red darken-2 white-text"/>
            </div>
            <div class="col l6">
                <input type="button"
                       style="width: 100%;"
                       value="--> ENVIAR CORREO <--"
                       onclick="insertDerivarCaso()"
                       class="btn-large light-green darken-3"/>
            </div>
        </div>
    </div>

</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">
    function insertDerivarCaso() {
        $.post('db/insert/derivar_caso.php',
            $("#form_agendamiento").serialize(),function(data){
                alertaLateral(data);
                document.getElementById("close_modal").click();


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
