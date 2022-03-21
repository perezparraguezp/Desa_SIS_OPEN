<?php
include '../../../php/config.php';
session_start();
$rut = $_SESSION['rut'];

?>
<script type="text/javascript">
    $(function(){

        $('#lugar').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#formulario_informe').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('.tooltipped').tooltip({delay: 50});
        $("#formulario_informe").on('change',function(){
            var opcion = $("#formulario_informe").val();
            $.post('formulario_touch/'+opcion+'_xls/select_informes.php',{
            },function(data){
                $("#id_seccion").html(data);

            });
        });
    });
    function exportTable(table,file){
        let export_to_excel = document.getElementById(table);
        let data_to_send = document.getElementById('data_to_send');
        data_to_send.value = export_to_excel.outerHTML;
        $("#file").val(file);
        document.getElementById('formExport').submit();
    }
    function buscarDatosPersona(rut,column_sql,name_input){
        $.post('db/buscar/datos_persona.php',{
            rut:rut,
            columna:column_sql
        },function(data){
            $('input[name="'+name_input+'"]').val(data);

        });
    }
    function insertRegistro(){
        $.post('db/insert/registro.php',
            $("#form_base").serialize()
            ,function(data){
                if (data !=='ERROR_SQL'){
                    if(confirm("Desea ingresar un nuevo registro")){
                        loadMenu_REM('menu_2','registro_atencion','');
                    }
                }else{
                    alert('Se ha producido un error, vuelva a intentarlo');
                }

            });
    }
</script>
<style type="text/css">
    #form_base .row{
        margin-top: 10px;
    }
</style>
<form class="container eh-open_fondo card" id="form_base">
    <div class="row">
        <div class="col l6">FECHA DE INICIO</div>
        <div class="col l6">FECHA DE TERMINO</div>
    </div>
    <div class="row">
        <div class="col l6"><input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d',strtotime('-30 days')); ?>" /></div>
        <div class="col l6"><input type="date" id="fecha_terminio" name="fecha_terminio" value="<?php echo date('Y-m-d'); ?>" /></div>
    </div>
    <div class="row">
        <div class="col l4">LUGAR DE ATENCIÓN</div>
        <div class="col l7">
            <select name="lugar" id="lugar">
                <?php
                $sql = "select * from rem_lugares where rut_profesional='$rut' order by nombre_lugar";
                $res = mysql_query($sql);
                while($row = mysql_fetch_array($res)){
                    ?>
                    <option><?php echo $row['nombre_lugar']; ?></option>
                    <?php
                }
                ?>
                <option>TODOS</option>
            </select>
        </div>
        <div class="col l1">
            <strong class="tooltipped" style="cursor: help" data-position="bottom" data-delay="50" data-tooltip="ESTA ES UNA BASE DE LUGARES GUARDADOS PARA CADA UNO DE LOS PROFESIONALES">(?)</strong>
        </div>
    </div>
    <div class="row">
        <div class="col l4">FORMULARIO</div>
        <div class="col l8">
            <select name="formulario" id="formulario_informe">
                <option selected="selected" disabled="disabled">SELECCIONE TIPO DE PRESTACION</option>
                <option value="A01">A01 - CONTROLES DE SALUD</option>
                <option value="A02">A02 - EMP</option>
                <option value="A03">A03 - APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN</option>
                <option value="A04">A04 - CONSULTAS Y OTRAS ATENCIONES EN LA RED</option>
                <option value="A05">A05 - INGRESOS Y EGRESOS POR CONDICIÓN Y PROBLEMAS DE SALUD</option>
                <option value="A06">A06 - PROGRAMA DE SALUD MENTAL ATENCIÓN PRIMARIA Y ESPECIALIDADES</option>
                <option value="A08">A08 - ATENCIÓN DE URGENCIA</option>
                <option value="A09">A09 - ATENCIÓN DE SALUD BUCAL EN LA RED ASISTENCIAL</option>
                <option value="A11">A11 - TRANSMISIÓN VERTICAL MATERNO INFANTIL</option>
                <option value="A19a">A19a - ACTIVIDADES DE PROMOCIÓN Y PREVENCIÓN DE LA SALUD</option>
                <option value="A19b">A19b - ACTIVIDADES DE PARTICIPACIÓN SOCIAL</option>
                <option value="A23">A23 - SALAS: IRA, ERA Y MIXTAS EN APS</option>
                <option value="A26">A26 - ACTIVIDADES EN DOMICILIO Y OTROS ESPACIOS</option>
                <option value="A27">A27 - EDUCACIÓN PARA LA SALUD</option>
                <option value="A28">A28 - PROGRAMA DE REHABILITACIÓN INTEGRAL</option>
                <option value="A32">A32 - ACTIVIDADES DE SALUD PRIORIZADAS, CONTEXTO DE EMERGENCIA SANITARIA</option>
            </select>
        </div>
    </div>
    <div class="row" id="id_seccion">

    </div>
</form>
<form action="../../exportar/table.php" method="post" target="_blank" id="formExport">
    <input type="hidden" id="data_to_send" name="data_to_send" />
    <input type="hidden" id="file" name="file" value="archivo" />
</form>
<div class="row" style="padding:20px;">
    <div class="col l12">
        <input type="button"
               class="btn green lighten-2 white-text"
               value="EXPORTAR A EXCEL" onclick="exportTable('div_seccion','A01-REM')" />
    </div>
</div>
<div class="card" id="div_seccion">

</div>