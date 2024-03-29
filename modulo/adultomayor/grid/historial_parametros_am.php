<hr class="row" />
<div class="row">
    <div class="col l2">
        <i class="mdi-action-info ultra-small" title="INFO"></i>
    </div>
    <div class="col l6">EVALUACION</div>
    <div class="col l4">EDAD</div>
</div>

<hr class="row" />
<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';

$rut = str_replace('.','',$_POST['rut']);
$indicador = $_POST['indicador'];
$funcion_javascript = $_POST['funcion'];
$sql1 = "select * from historial_parametros_am 
        where rut='$rut' and valor!='' 
        and indicador='$indicador'
        group by fecha_registro,indicador 
        order by fecha_registro desc";

$res1 = mysql_query($sql1);
$colores = Array('aqua','yellow');
$i=0;
while($row1 = mysql_fetch_array($res1)){
    $persona = new persona($row1['rut']);

    $fecha = $row1['fecha_registro'];

    $persona->calcularEdadFecha($fecha);

    $indidcador = $row1['indicador'];
    $value = $row1['valor'];
    if($indicador=='ekg'){
        list($value,$hora) = explode(" ",$value);
        $value = fechaNormal($value);
    }else{
        $value = $row1['valor'];
    }


    if($value!=''){
        $color = $colores[$i%2];
        ?>
        <div class="row">
            <div class="col l2">
                <?php echo fechaNormal($row1['fecha_registro']); ?>
            </div>
            <div class="col l6 "><?php echo $value; ?></div>
            <div class="col l3"><?php echo $persona->edad; ?></div>
            <div class="col l1">
                <?php
                if($persona->myID==$row1['id_profesional']){
                    ?>
                    <i class="mdi-action-delete red-text"
                       onclick="deleteHistorial('historial_parametros_am','<?php echo $row1['id_historial']; ?>')"
                       style="cursor: pointer;"></i>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    $i++;
}

?>
<script type="text/javascript">
    $(function(){
        $('.tooltipped').tooltip({delay: 50});
    });
    function deleteHistorial(table,id) {
        if(confirm('DESEA ELIMINAR ESTE REGISTRO')){
            $.post('db/delete/historial.php',{
                table:table,
                rut:'<?php echo $rut; ?>',
                id:id
            },function (data) {
                if(data!=='ERROR_SQL'){
                    alertaLateral('REGISTRO ELIMINADO');
                    <?php echo $funcion_javascript; ?>;
                    loadHistorialParametroAM_funcionalidad('<?php echo $rut; ?>','<?php echo $indicador; ?>');
                }
            });
        }
    }
</script>
