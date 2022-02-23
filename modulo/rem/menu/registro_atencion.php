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
        $('#formulario').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('.tooltipped').tooltip({delay: 50});
        $("#formulario").on('change',function(){
            var opcion = $("#formulario").val();
            $.post('formulario/'+opcion+'/select.php',{
            },function(data){
                $("#id_seccion").html(data);

            });
        });
    });
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
<form class="container" id="form_base">
    <div class="row">
        <div class="col l4">FECHA DE REGISTRO</div>
        <div class="col l7">
            <input type="date" name="fecha_registo" id="fecha_registro" value="<?php echo date('Y-m-d'); ?>" />
        </div>
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
            </select>
        </div>
        <div class="col l1">
            <strong class="tooltipped" style="cursor: help" data-position="bottom" data-delay="50" data-tooltip="ESTA ES UNA BASE DE LUGARES GUARDADOS PARA CADA UNO DE LOS PROFESIONALES">(?)</strong>
        </div>
    </div>
    <div class="row">
        <div class="col l4">FORMULARIO</div>
        <div class="col l8">
            <select name="formulario" id="formulario">
                <option selected="selected" disabled="disabled">SELECCIONE TIPO DE PRESTACION</option>
                <option value="A01">A01 - CONTROLES DE SALUD</option>
                <option value="A02">A02 - EMP</option>
                <option value="A03">A03 - APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN</option>
                <option value="A04">A04 - APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN</option>
                <option value="A05">A05 - INGRESOS Y EGRESOS POR CONDICIÓN Y PROBLEMAS DE SALUD</option>
                <option value="A06">A06 - PROGRAMA DE SALUD MENTAL ATENCIÓN PRIMARIA Y ESPECIALIDADES</option>
                <option value="A08">A08 - ATENCIÓN DE URGENCIA</option>
                <option value="A09">A09 - ATENCIÓN DE SALUD BUCAL EN LA RED ASISTENCIAL </option>
                <option value="A11">A11 - TRANSMISIÓN VERTICAL MATERNO INFANTIL </option>
                <option value="A23">A23 - IRA, ERA Y MIXTAS EN APS </option>
                <option value="A27">A27 - EDUCACIÓN PARA LA SALUD </option>
                <option value="A32">A32 - ACTIVIDADES DE SALUD PRIORIZADAS, CONTEXTO DE EMERGENCIA SANITARIA </option>
            </select>
        </div>
    </div>
    <div class="row" id="id_seccion">

    </div>
    <div class="row" id="div_seccion">

    </div>
</form>