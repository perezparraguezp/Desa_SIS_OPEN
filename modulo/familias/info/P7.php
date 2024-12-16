<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';


$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";



$id_establecimiento = $_SESSION['id_establecimiento'];

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


//rango de meses en dias
$rango_seccion_c42 = [
    'persona.edad_total_dias>=0 and persona.edad_total_dias<365', //menor 1 año
    'persona.edad_total>=(1) and persona.edad_total<=(12)',//1 año
    'persona.edad_total>=(12 + 1) and persona.edad_total<=(12*2)',//2 año
    'persona.edad_total>=((12*2)+1) and persona.edad_total<=(12*3)',//3 año
    'persona.edad_total>=((12*3)+1) and persona.edad_total<=(12*4)',//4 año
    'persona.edad_total>=((12*4)+1) and persona.edad_total<=(12*5)',//5 año
    'persona.edad_total>=((12*5)+1) and persona.edad_total<=(12*6)',//6 año
    'persona.edad_total>=((12*6)+1) and persona.edad_total<=(12*7)',//7 año
    'persona.edad_total>=((12*7)+1) and persona.edad_total<=(12*9)',//8 a 9 año
    'persona.edad_total>=((12*10)) and persona.edad_total<=(12*14)',//10 a 14 años
    'persona.edad_total>=((12*14)+1) and persona.edad_total<=(12*19)',//15 a 19 años
];
$rango_seccion_d7_text = [
    '< 1 AÑO', //menor 1 año
    '1 AÑO',//1 año
    '2 AÑOS',//2 año
    '3 AÑOS',//3 año
    '4 AÑOS',//4 año
    '5 AÑOS',//5 año
    '6 AÑOS',//6 año
    '7 AÑOS',//7 año
    '8 a 9 AÑOS',//8 a 9 año
    '10 A 14 AÑOS',//10 a 14 años
    '15 A 19 AÑOS',//15 a 19 años
];

$sexo = [
    "persona.sexo='M' ",
    "persona.sexo='F' "
];


//INDICE
$indice_ceod_sql = [
    '0%', //0
    '1%', //0
    '3%', //0
    '5%', //0
    '7%', //0
    '9%', // 9
];
$indice_ceod_label = [
    '0', //0
    '1 a 2', //0
    '3 a 4', //0
    '5 a 6', //0
    '7 a 8', //0
    '9 o Más', // 9
];
//dientes
$indice_dientes_sql = [
    '0%', //0
    '1 a%', //0
    '10 a%', //0
    '20 a%', //0
    '28 y%', //0
];
$indice_dientes_label = [
    '0', //0
    '1 a 9', //0
    '10 a 19', //0
    '20 a 27', //0
    '28 y Más', //0
];

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
    function loadP7_familia() {
        var id = $("#centro_interno").val();
        var div = 'tabla_P7';
        loading_div(div);
        $.post('info/tabla_p7.php',{
            id:id
        },function(data){
            if(data !=='ERROR_SQL' ){
                $("#"+div).html(data);
            }else{

            }
        });
    }
    function load_P7_SECCION(letra){
        var id = $("#centro_interno").val();
        $("#div_seccion_"+letra).html('<div style="text-align: center;"><img src="../../images/calculadora.gif" width="16" /> PROCESANDO SECCION '+letra+'... </div>');
        $.post('info/p7_'+letra+'.php',{
            id:id
        },function(data){
            if(data !=='ERROR_SQL' ){
                $("#div_seccion_"+letra).html(data);
            }else{

            }
        });
    }

</script>
<form action="../../exportar/table.php" method="post" target="_blank" id="formExport">
    <input type="hidden" id="data_to_send" name="data_to_send" />
    <input type="hidden" id="file" name="file" value="archivo" />
</form>
<div id="tabla_P7">
    <div class="card" id="todo_p2">
        <div class="row" style="padding:20px;">
            <div class="col l10">
                <header><?php echo $nombre_centro; ?></header>
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
</div>
<script type="text/javascript">

</script>