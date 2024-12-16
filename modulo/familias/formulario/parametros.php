<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';

$id_familia = $_POST['id_familia'];
$sql = "select * from parametros_familia where id_familia='$id_familia' limit 1";
$row = mysql_fetch_array(mysql_query($sql));

$vif =$row['vif'];
$nanea =$row['nanea'];
$dependencia =$row['dependencia'];
$paliativo =$row['paliativo'];
$oh_droga =$row['oh_droga'];
$eqz =$row['eqz'];

$sql1 = "select * from historial_parametros_familia
inner join personal_establecimiento pe on historial_parametros_familia.id_profesional = pe.id_profesional
inner join persona p on pe.rut = p.rut
where id_familia='$id_familia' and historial_parametros_familia.id_profesional!=0
order by id_registro desc";

$res1 = mysql_query($sql1);
$listado = '';

$parametros = [
        "vif","nanea","dependencia","paleativo","oh-droga","ezq"
]

?>
<script type="text/javascript">
    function boxNuevoRegistroTrazador(){
        $.post('formulario/ingreso_registro_trazador.php',{
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
</script>

<div class="container">
    <div class="row">
        <div class="col l2">
            <div class="card-panel center-align  blue lighten-4" onclick="boxNuevoRegistroTrazador()">
                <div class="row"><i class="mdi-hardware-keyboard-hide"></i></div>
                <div class="row">REGISTRAR NUEVO</div>
            </div>

        </div>
        <div class="col l10">
            <div class="card-panel" style="font-size: 0.8em;">
                <header>HISTORIAL DE CAMBIOS</header>
                <div class="row">
                    <div class="col l12">
                        <div class="card-panel lime lighten-4">
                            <div class="row">
                                <div class="col l1">FECHA</div>
                                <div class="col l2">PROFESIONAL</div>
                                <div class="col l4">TRAZADORES</div>
                                <div class="col l5">OBS</div>
                            </div>
                        </div>
                        <?php
                        $sql1 = "select * from registro_trazadores_familia 
                            inner join personal_establecimiento on registro_trazadores_familia.id_profesional=personal_establecimiento.id_profesional
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
                                    $listado_trazadores.='<i class="mdi-navigation-check" syle="font-size:1em;"></i>'.trim($row2['nombre_trazador'])." <br /> ";
                                }
                            }
                            ?>
                            <div class="card-panel <?php echo $colores[$color]; ?>">
                                <div class="row">
                                    <div class="col l1"><?php echo fechaNormal($row1['fecha_registro']); ?></div>
                                    <div class="col l2"><?php echo ($row1['nombre_completo']); ?></div>
                                    <div class="col l4"><?php echo ($listado_trazadores); ?></div>
                                    <div class="col l5"><?php echo ($row1['observaciones']); ?></div>
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
<!--    <div class="row">-->
<!--        <div class="col l4">-->
<!--            <div class="card-panel blue lighten-4">-->
<!--                <div class="row">-->
<!--                    <div class="col l12">-->
<!--                        <input type="checkbox" id="vif"-->
<!--                               onchange="updateParametroFamilia('vif')"-->
<!--                            --><?php //echo $vif=='SI'?'checked="checked"':'' ?>
<!--                               name="vif"  />-->
<!--                        <label class="black-text" for="vif">VIF</label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col l12">-->
<!--                        <input type="checkbox" id="nanea"-->
<!--                               onchange="updateParametroFamilia('nanea')"-->
<!--                            --><?php //echo $nanea=='SI'?'checked="checked"':'' ?>
<!--                               name="nanea"  />-->
<!--                        <label class="black-text" for="nanea">NANEA</label>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col l12">-->
<!--                        <input type="checkbox" id="dependencia"-->
<!--                               onchange="updateParametroFamilia('dependencia')"-->
<!--                            --><?php //echo $dependencia=='SI'?'checked="checked"':'' ?>
<!--                               name="dependencia"  />-->
<!--                        <label class="black-text" for="dependencia">DEPENDENCIA SEVERA</label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col l12">-->
<!--                        <input type="checkbox" id="paliativo"-->
<!--                               onchange="updateParametroFamilia('paliativo')"-->
<!--                            --><?php //echo $paliativo=='SI'?'checked="checked"':'' ?>
<!--                               name="paliativo"  />-->
<!--                        <label class="black-text" for="paliativo">PALIATIVO</label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col l12">-->
<!--                        <input type="checkbox" id="oh_droga"-->
<!--                               onchange="updateParametroFamilia('oh_droga')"-->
<!--                            --><?php //echo $oh_droga=='SI'?'checked="checked"':'' ?>
<!--                               name="oh_droga"  />-->
<!--                        <label class="black-text" for="oh_droga">OH Y DROGA PROBLEMATICO</label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col l12">-->
<!--                        <input type="checkbox" id="eqz"-->
<!--                               onchange="updateParametroFamilia('eqz')"-->
<!--                            --><?php //echo $eqz=='SI'?'checked="checked"':'' ?>
<!--                               name="eqz"  />-->
<!--                        <label class="black-text" for="eqz">EZQ</label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col l8">-->
<!--            <div class="card-panel purple lighten-4">-->
<!--                <header>HISTORIAL DE PARAMETEOS</header>-->
<!--                <div class="row" style="border: solid 1px black;">-->
<!--                    <div class="col l1">FECHA</div>-->
<!--                    <div class="col l4">PROFESIONAL</div>-->
<!--                    <div class="col l7">TEXTO</div>-->
<!--                </div>-->
<!--                --><?php
//                while ($row1 = mysql_fetch_array($res1)){
//                    $listado.= '<div class="row">
//                    <div class="col l1">'.fechaNormal($row1['fecha_registro']).'</div>
//                    <div class="col l4">'.$row1['nombre_completo'].'</div>
//                    <div class="col l7">'.$row1['texto'].'</div>
//                </div>';
//                }
//                echo $listado;
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
<script type="text/javascript">
    function updateParametroFamilia(input){
        var value ='';
        var fecha = $("#fecha_registro").val();
        if($('#'+input).prop('checked')){
            value = 'SI';
        }else{
            value = 'NO';
        }
        $.post('db/update/parametros.php',{
            column:input,
            value:value,
            id_familia:'<?php echo $id_familia; ?>',
            fecha_registro:fecha
        },function (data) {
            alertaLateral(data);
            loadMenu_M('menu_3','registro_familia','<?php echo $id_familia; ?>');
            document.getElementById("close_modal").click();
        });
    }
</script>
