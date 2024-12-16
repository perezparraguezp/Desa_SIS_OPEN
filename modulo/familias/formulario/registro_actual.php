<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';
include '../../../php/objetos/familia.php';
$rut = str_replace('.', '', $_POST['rut']);

$fecha_registro = $_POST['fecha_registro'];
$id_familia = $_POST['id_familia'];

$familia = new familia($id_familia);



?>
<script type="text/javascript">


</script>
<input type="hidden" name="rut" value="<?php echo $rut; ?>"/>
<input type="hidden" name="fecha_registro" id="fecha_registro" value="<?php echo $fecha_registro; ?>"/>
<div class="container">
    <div class="row">
        <div class="col l2">
            <div class="card-panel center-align  blue lighten-4" onclick="boxRegistroActual()">
                <div class="row"><i class="mdi-maps-location-history"></i></div>
                <div class="row">REGISTRAR ATENCIÓN PROFESIONAL</div>
            </div>

        </div>
        <div class="col l10">
            <div class="card-panel" style="font-size: 0.8em;">
                <header>REGISTROS HISTORICOS</header>
                <div class="row">
                    <div class="col l12">
                        <div class="card-panel lime lighten-4">
                            <div class="row">
                                <div class="col l1">FECHA</div>
                                <div class="col l2">PROFESIONAL</div>
                                <div class="col l2">VDI</div>
                                <div class="col l2">PLAN INTERVENCIÓN</div>
                                <div class="col l2">PAUTA DE RIESGO</div>
                                <div class="col l3">OBS</div>
                            </div>
                        </div>
                        <?php
                        $sql1 = "select * from registro_familia_historico 
                            inner join personal_establecimiento on registro_familia_historico.id_profesional=personal_establecimiento.id_profesional
                            inner join persona on personal_establecimiento.rut=persona.rut
                            where id_familia='$id_familia' order by fecha_registro desc";
                        $res1 = mysql_query($sql1);
                        $colores = ['light-green lighten-5','lime lighten-5'];
                        $i = 0;
                        while ($row1 = mysql_fetch_array($res1)){
                            $color = $i%2;
                            $trazadores = explode(";",$row1['trazadores']);
                            $listado_trazadores = '';
                            foreach ($trazadores as $j => $id_trazador){
                                if($id_trazador!=''){
                                    $sql2 = "select * from trazadores_familia where id_trazador='$id_trazador' limit 1";

                                    $row2 = mysql_fetch_array(mysql_query($sql2));
                                    $listado_trazadores.=trim($row2['nombre_trazador'])." ; ";
                                }
                            }
                            ?>
                            <div class="card-panel <?php echo $colores[$color]; ?>">
                                <div class="row">
                                    <div class="col l1"><?php echo fechaNormal($row1['fecha_registro']) ?></div>
                                    <div class="col l2"><?php echo ($row1['nombre_completo']); ?></div>
                                    <div class="col l2"><?php echo ($row1['vdi']); ?></div>
                                    <div class="col l2"><?php echo ($row1['pauta']); ?></div>
                                    <div class="col l2"><?php echo ($row1['riesgo']); ?></div>
                                    <div class="col l3"><?php echo ($row1['obs']); ?></div>

                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .btn:hover {
        background-color: #3fff7f;
    }
</style>
<script type="text/javascript">
    function boxRegistroActual(){
        $.post('formulario/nuevo_registro_actual.php',{
            id_familia:'<?php echo $id_familia; ?>',
            fecha:$("#fecha_registro").val()
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxNuevoVDI(){
        $.post('formulario/nuevo_vdi.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function deleteVDI(id){
        $.post('formulario/delete_vdi.php', {
            id_familia: '<?php echo $id_familia ?>',
            id_registro: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }

    function boxNuevoPautaRiesgo(){
        $.post('formulario/nuevo_pauta_riesgo.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function deletePautaRiesgo(id){
        $.post('formulario/delete_pauta_riesgo.php', {
            id_familia: '<?php echo $id_familia ?>',
            id_registro: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxNuevoPlanIntervencion(){
        $.post('formulario/nuevo_plan_intervencion.php', {
            id_familia: '<?php echo $id_familia ?>',
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function deletePlanIntervencion(id){
        $.post('formulario/delete_plan_intervencion.php', {
            id_familia: '<?php echo $id_familia ?>',
            id_registro: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
</script>
