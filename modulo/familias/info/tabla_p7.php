<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';


$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";


$id_establecimiento = $_SESSION['id_establecimiento'];

$id_centro = $_POST['id'];
if ($id_centro != '') {
    $filtro_centro = " and id_centro_interno='$id_centro' ";
    $sql0 = "select * from centros_internos 
                              WHERE id_centro_interno='$id_centro' limit 1";
    $row0 = mysql_fetch_array(mysql_query($sql0));
    $nombre_centro = $row0['nombre_centro_interno'];
} else {
    $nombre_centro = 'TODOS LOS CENTROS';
    $filtro_centro = '';
}

$label_rango_seccion_j = [
    '< 1 AÑO', //menor 1 mes
    '1 mes',//un mes
    '2 meses',//dos meses
    '3 meses',//dos meses
    '4 meses',//dos meses
    '5 meses',//dos meses
    '6 meses',//dos meses
    '7 a 11 meses',//7 a 11 meses
    '12 a 17 meses',//12 a 17 meses
    '18 a 23 meses',//18 a 23 meses
    '24 a 35 meses',//24 a 35 meses
    '36 a 41 meses',//36 a 41 meses
    '42 a 47 meses',//42 a 47 meses
    '48 a 59 meses',//48 a 59 meses
    '60 a 71 meses', //entre 60 meses a 71 meses
    '6 a 7 años',//desde los 6 a 7 años
    '8 a 9 años',//desde los 6 a 7 años
];

$sexo = [
    "persona.sexo='M' ",
    "persona.sexo='F' "
];






?>
<div class="card" id="todo_p2">
    <div class="row" style="padding:20px;">
        <div class="col l10">
            <label>CENTRO MEDICO
                <select class="browser-default"
                        name="centro_interno"
                        id="centro_interno"
                        onchange="loadP7_familia()" >
                    <option value="" disabled="disabled" selected="selected">SELECCIONAR CENTRO MEDICO</option>
                    <?php
                    $sql0 = "select * from centros_internos 
                              order by nombre_centro_interno ";
                    $res0 = mysql_query($sql0);
                    while($row0 = mysql_fetch_array($res0)){
                        if($id_centro==$row0['id_centro_interno']){
                            ?>
                            <option selected value="<?php echo $row0['id_centro_interno']; ?>"><?php echo $row0['nombre_centro_interno']; ?></option>
                            <?php
                        }else{
                            ?>
                            <option value="<?php echo $row0['id_centro_interno']; ?>"><?php echo $row0['nombre_centro_interno']; ?></option>
                            <?php
                        }

                    }
                    ?>
                    <option value="">TODOS</option>
                </select>
            </label>
        </div>
        <div class="col l2">
            <input type="button"
                   class="btn green lighten-2 white-text"
                   value="EXPORTAR A EXCEL" onclick="exportTable('todo_p2','P7')"/>
        </div>
    </div>
    <hr class="row" style="margin-bottom: 10px;"/>
    <div id="div_seccion_A">
    </div>
    <div id="div_seccion_A1">
    </div>
    <div id="div_seccion_B">
    </div>


</div>
<script type="text/javascript">
    $(function(){
        load_P7_SECCION('A');
        load_P7_SECCION('A1');
        load_P7_SECCION('B');

    })
</script>