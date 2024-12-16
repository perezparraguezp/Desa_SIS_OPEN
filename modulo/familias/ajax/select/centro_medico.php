<option value="-1">SELECCIONE CENTRO MEDICO</option>
<?php
include "../../../../php/config.php";

$id = $_POST['id'];

$sql1 = "select * from centros_internos 
                          where id_sector_comunal='$id'
                            and id_establecimiento='1'
                          order by nombre_centro_interno";
$res1 = mysql_query($sql1);
while ($row1 = mysql_fetch_array($res1)) {
    ?>
    <option value="<?php echo strtoupper($row1['id_centro_interno']); ?>"><?php echo strtoupper($row1['nombre_centro_interno']); ?></option>
    <?php
}


?>
