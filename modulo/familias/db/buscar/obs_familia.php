
<div class="row blue lighten-3">
    <div class="col l1">FECHA</div>
    <div class="col l3">PROFESIONAL</div>
    <div class="col l8">OBSERVACION</div>
</div>

<?php
include '../../../../php/config.php';
include '../../../../php/objetos/profesional.php';

$id_familia = $_POST['id_familia'];


$sql = "select * from obs_familia
inner join familia f on obs_familia.id_familia = f.id_familia 
where obs_familia.id_familia='$id_familia' 
order by fecha_registro desc";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
    $p = new profesional($row['id_profesional']);
    ?>

    <div class="row">
        <div class="col l1"><?php echo fechaNormal($row['fecha_registro']); ?></div>
        <div class="col l3"><?php echo $p->nombre; ?></div>
        <div class="col l8"><?php echo $row['texto']; ?></div>
    </div>

    <?php
}

