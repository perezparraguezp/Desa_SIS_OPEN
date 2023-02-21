<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';


$id_centro = $_POST['id'];

if($id_centro!=''){
    $filtro_centro = " and id_centro_interno='$id_centro' ";
    $sql0 = "select * from centros_internos 
                              WHERE id_centro_interno='$id_centro' limit 1";
    $row0 = mysql_fetch_array(mysql_query($sql0));
    $nombre_centro = $row0['nombre_centro_interno'];
}else{
    $nombre_centro = 'TODOS LOS CENTROS';
}


?>
<style type="text/css">
    table, tr, td {
        padding: 10px;
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.8em;
        text-align: center;
    }
    section{
        padding-top: 10px;
        padding-left: 10px;
    }
    header{
        font-weight: bold;;
    }
</style>
<script type="text/javascript">
    function exportTable(table,file){
        let export_to_excel = document.getElementById(table);
        let data_to_send = document.getElementById('data_to_send');
        data_to_send.value = export_to_excel.outerHTML;
        $("#file").val(file);
        document.getElementById('formExport').submit();
    }
    function loadP3() {
        var id = $("#centro_interno").val();
        var desde = $("#fecha_desde").val();
        var hasta = $("#fecha_hasta").val();
        var div = 'tabla_a03';
        if(id!==''){
            loading_div(div);
            $.post('info/tabla_a03.php',{
                id:id,
                desde:desde,
                hasta:hasta
            },function(data){
                if(data !=='ERROR_SQL' ){
                    $("#"+div).html(data);
                }else{

                }
            });
        }
    }
</script>
<formaction="https://carahue.eh-open.com/exportar/table.php"  method="post" target="_blank" id="formExport">
    <input type="hidden" id="data_to_send" name="data_to_send" />
    <input type="hidden" id="file" name="file" value="archivo" />
</form>
<div class="container eh-open_fondo" style="padding: 10px;color: black; ">
    <div class="row">
        <label>GENERAR REM A03</label>
    </div>
    <div class="row">
        <div class="col l6 m6 s6">
            <?php
            $fecha_actual = date("Y-m-d");
            //resto 1 año
            $fecha_anterior =  date("Y-m-d",strtotime($fecha_actual."- 1 year"));
            ?>
            <div class="row">
                <div class="col l6 m6 s6">
                    <label>FECHA DESDE <input style="font-size: 1em;height:3em;width: 90%;margin: 5px;" onchange="loadP3()" type="date" name="fecha_desde" id="fecha_desde" value="<?php echo $fecha_anterior; ?>" /></label>
                </div>
                <div class="col l6 m6 s6">
                    <label>FECHA HASTA <input style="font-size: 1em;height:3em;width: 90%;margin: 5px;" onchange="loadP3()" type="date" name="fecha_hasta" id="fecha_hasta" value="<?php echo $fecha_actual; ?>" /></label>
                </div>
            </div>
        </div>
        <div class="col l6 m6 s6">
            <label>CENTRO MEDICO
                <select class="browser-default"
                        style="font-size: 1em;height:3em;width: 90%;margin: 5px;"
                        name="centro_interno"
                        id="centro_interno"
                        onchange="loadP3()" >
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
    </div>

</div>
<div id="tabla_a03"></div>