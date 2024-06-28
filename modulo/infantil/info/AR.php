<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';

$id_centro = $_POST['id'];
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
    #subFORM label{
        color: white;
        ;
    }
    #subFORM select{
        color: black;;
    }
    #subFORM .row .col{
        padding: 5px;
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
    function loadAR() {
        var id = $("#centro_interno").val();
        var div = 'tabla_ar';
        // loading_div(div);
        $.post('info/tabla_ar.php',{
            id:id
        },function(data){
            if(data !=='ERROR_SQL' ){
                $("#"+div).html(data);
            }else{
                $("#"+div).html('Se produjo un error en la conexion, favor intentelo nuevamente');
            }
        });
    }
    function load_AR_SECCION(letra){
        var id = $("#centro_interno").val();
        $("#div_seccion_"+letra).html('<div style="text-align: center;"><img src="../../images/calculadora.gif" width="16" /> PROCESANDO SECCION '+letra+'... </div>');
        $.post('info/AR_'+letra+'.php',{
            id:id,
            desde:$("#desde").val(),
            hasta:$("#hasta").val(),
        },function(data){
            if(data !=='ERROR_SQL' ){
                $("#div_seccion_"+letra).html(data);
            }else{

            }
        });
    }
</script>

<form action="https://carahue.eh-open.com/exportar/table.php"  method="post" target="_blank" id="formExport">
    <input type="hidden" id="data_to_send" name="data_to_send" />
    <input type="hidden" id="file" name="file" value="archivo" />
</form>
<div id="subFORM" class="card-panel" style="background-color: #00b0ff;">
    <div class="row">
        <div class="col l4">
            <label>DESDE <input type="date" name="desde" id="desde" max="<?php echo date('Y-m-d',strtotime('-1 day' , strtotime(date('Y-m-d')))); ?>"  value="<?php echo date('Y-m-d',strtotime('-1 year' , strtotime(date('Y-m-d')))); ?>" /></label>
        </div>
        <div class="col l4">
            <label>HASTA <input type="date" name="hasta" id="hasta" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d') ?>" /></label>
        </div>
        <div class="col l4">
            <label>CENTRO MEDICO
                <select class="browser-default"
                        name="centro_interno"
                        id="centro_interno"
                        onchange="loadAR()" >
                    <option value="" disabled="disabled" selected="selected">CENTRO MEDICO</option>
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
<div id="tabla_ar">

</div>

