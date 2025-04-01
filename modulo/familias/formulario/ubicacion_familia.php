<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';

$id_familia = $_POST['id_familia'];
$id_registro = $_POST['id_registro'];
session_start();
$sql = "select * from familia where id_familia='$id_familia' limit 1";
$row = mysql_fetch_array(mysql_query($sql));
$lat = $row['ubicacion_x'];
$long = $row['ubicacion_y'];
$direccion = $row['direccion_familia'];

?>
<script type="text/javascript">
    window.open('https://imperial.sis-open.com/modulo/familias/menu/mapa.php?id_familia=<?php echo $id_familia; ?>&lat=<?php echo $lat; ?>&long=<?php echo $long; ?>&direccion=<?php echo $direccion; ?>', '_blank', 'width=800,height=700,scrollbars=yes,resizable=yes');
    document.getElementById("close_modal").click();
</script>
<!--<iframe src="menu/mapa.php?id_familia=--><?php //echo $id_familia; ?><!--&lat=--><?php //echo $lat; ?><!--&long=--><?php //echo $long; ?><!--&direccion=--><?php //echo $direccion; ?><!--" style="width: 100%;height: 600px;">-->
<!---->
<!--</iframe>-->

<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>