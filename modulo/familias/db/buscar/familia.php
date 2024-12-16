<?php
include '../../../../php/config.php';

$rut = str_replace(".","",$_POST['rut_buscar']);


$sql = "select * from integrante_familia
inner join familia f on integrante_familia.id_familia = f.id_familia 
where integrante_familia.rut='$rut' limit 1";
$row = mysql_fetch_array(mysql_query($sql));

if($row){
    ?>
    <div class="row orange lighten-1">
        <div class="col l2">OPCION</div>
        <div class="col l5">NOMBRE DE FAMILIA</div>
        <div class="col l5">DIRECCION</div>
    </div>
    <div class="row">
        <div class="col l2">
            <strong style="cursor: pointer;color: blue;"
                    onclick="cargarAccesoFamilia();" href="">ACCEDER A FICHA</strong>
        </div>
        <div class="col l5"><?php echo $row['nombre_familia']; ?></div>
        <div class="col l5"><?php echo $row['direccion_familia']; ?></div>
    </div>
    <script type="text/javascript">
        function cargarAccesoFamilia(){
            loadMenu_M('menu_3','registro_familia','<?php echo $row['id_familia']; ?>')
            document.getElementById("close_modal").click();
        }
    </script>
<?php
}else{
    echo 'RUT NO REGISTRADO EN NINGUNA FAMILIA';
}