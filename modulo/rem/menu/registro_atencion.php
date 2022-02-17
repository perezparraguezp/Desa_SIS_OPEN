<?php
include '../../../php/config.php';
session_start();
$rut = $_SESSION['rut'];

?>
<script type="text/javascript">
    $(function(){

        $('.tooltipped').tooltip({delay: 50});
        $("#formulario").on('change',function(){
            var opcion = $("#formulario").val();
            $.post('formulario/'+opcion+'/select_button.php',{
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
        <div class="col l2 eh-open_fondo" style="padding: 10px;">
            <div class="row">
                <label>FECHA REGISTRO <input type="date" name="fecha_registo" id="fecha_registro" value="<?php echo date('Y-m-d'); ?>" /></label>
            </div>
            <div class="row">
                <label>LUGAR DE ATENCIÓN <select name="lugar" id="lugar">
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
                </label>
            </div>
            <div class="row">
                <label>FORMULARIO <select name="formulario" id="formulario">
                        <option selected="selected" disabled="disabled">SELECCIONE TIPO DE PRESTACION</option>
                        <option value="A01">A01 - CONTROLES DE SALUD</option>
                        <option value="A02">A02 - EMP</option>
                        <option value="A03">A03 - APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN</option>
                        <option value="A04">A04 - APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN</option>
                    </select></label>
            </div>
        </div>
        <div class="col l10"
             style="padding: 20px;">
            <div class="row" id="id_seccion"></div>
            <div class="row" id="div_seccion"></div>
        </div>
    </div>

</form>