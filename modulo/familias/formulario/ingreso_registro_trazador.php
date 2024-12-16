<?php
include '../../../php/config.php';
$id_familia = $_POST['id_familia'];
$fecha_registro = $_POST['fecha'];
?>
<style type="text/css">
    #form_paciente input{
        text-align: left;
    }
</style>
<form name="form_paciente"
      id="form_paciente" class="card-panel left-align">
    <input type="hidden" name="id_familia" value="<?php echo $id_familia; ?>" />
    <input type="hidden" name="fecha_registro" value="<?php echo $fecha_registro; ?>" />
    <script type="text/javascript">
        $(document).ready(function () {
            // Create jqxNavigationBar
            $("#jqxNavigationBar").jqxNavigationBar({ width: '100%',theme: 'eh-open', height: alto-450});
        });
    </script>

    <div id='jqxNavigationBar'>
        <div>TRAZADORES DETECTADOS</div>
        <div style="padding: 20px;">
            <?php
            $sql1 = "select * from trazadores_familia order by id_trazador";
            $res1 = mysql_query($sql1);
            while ($row1 = mysql_fetch_array($res1)){
                $sql2 = "select * from registro_trazadores_familia
                            where id_familia='$id_familia' 
                            order by fecha_registro desc limit 1";
                $row2 = mysql_fetch_array(mysql_query($sql2));
                $trazadores = explode(";",$row2['trazadores']);
                if(in_array($row1['id_trazador'],$trazadores)){
                    $check='SI';
                }else{
                    $check='NO';
                }
                ?>
                <p>
                    <input type="checkbox" id="trazador-<?php echo $row1['id_trazador']; ?>"
                        <?php echo $check=='SI'?'checked="checked"':'' ?> value="<?php echo $row1['simbolo_trazador']; ?>"
                           name="trazador[<?php echo $row1['id_trazador']; ?>]"  />
                    <label class="black-text" for="trazador-<?php echo $row1['id_trazador']; ?>"><?php echo $row1['nombre_trazador']; ?></label>
                </p>
            <?php
            }
            ?>



        </div>
        <div>OBSERVACIONES (opcional)</div>
        <div style="padding: 20px;">
            <div class="row">
                <div class="col l12 m12 s12">
                    <textarea name="obs" id="obs" placeholder="SI EL PROFESIONAL ESTIMA CONVENIENTE DEJAR ALGUN COMENTARIO U OBSERVACION AL MOMENTO DE REALIZAR EL REGISTRO"></textarea>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <input type="button"
               value="CONFIRMAR REGISTRO DE TRAZADORES"
               style="text-align: center;"
               onclick="inserTrazador()"
               class="btn waves-effect modal-trigger waves-light col s12 " />

    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">


    $("#rut").on('change',function(){
        $('#rut').Rut({
            on_error: function() {
                $(this).focus();
                //alert('Rut incorrecto');
                alertaLateral('RUT INCORRECTO');
                $('#rut').val('');
                $('#rut').focus();
                $('#rut').css({
                    "border": "solid red 1px"
                });
            },
            on_success:function(){
                $('#rut').css({
                    "border": "solid green 1px"
                });
                buscarDatosPersona(''+$("#rut").val(),'nombre_completo','nombre','text');
                buscarDatosPersona(''+$("#rut").val(),'fecha_nacimiento','nacimiento','text');
                buscarDatosPersona(''+$("#rut").val(),'telefono','telefono','text');
                buscarDatosPersona(''+$("#rut").val(),'email','email','text');
                buscarDatosPersona(''+$("#rut").val(),'sexo','sexo','radio');
                buscarDatosPersona(''+$("#rut").val(),'pueblo','pueblo','radio');
                buscarDatosPersona(''+$("#rut").val(),'migrante','migrante','radio');

            }
        });
    });




    var select = 0;
    $("#id_centro").on('change',function(){
        var centro = $("#id_centro").val();

        $.post('../../php/ajax/select/sectores_centro_option.php',{
            id_centro:centro
        },function(data){
            $("#div_sector_id").html('');
            $("#div_sector_id").html('<select id="id_sector_centro" name="id_sector_centro"></select>');
            $("#id_sector_centro").html(data);
            $("#id_sector_centro").jqxDropDownList({width: '100%', height: 30});
        });
    });

    function buscarDatosPersona(rut,column_sql,name_input,tipo){
        $.post('db/buscar/datos_persona.php',{
            rut:rut,
            columna:column_sql
        },function(data){
            if(data!=='NO EXISTE INFORMACION'){
                // alertaLateral('EL PACIENTE CUENTA CON REGISTROS INTERNOS');
                if(tipo==='text'){
                    $('input[name="'+name_input+'"]').val(data);
                }else{
                    if(tipo==='radio'){
                        $('input[name="'+name_input+'"][value="'+data+'"]').prop('checked', true);
                    }
                }
            }else{
                // alertaLateral('DEBE INGRESAR TODOS LOS DATOS DEL PACIENTE');
            }




        });
    }

    function inserTrazador(){
        if(confirm('Esta seguro de registrar esta informacion')){
            $.post('db/insert/registro_trazador.php',
                $("#form_paciente").serialize(),function (data){
                    if(data!=='ERROR_SQL'){
                        alertaLateral('PACIENTE REGISTRADO!');
                        loadParametrosFamilia('<?php echo $id_familia; ?>');
                        document.getElementById("close_modal").click();
                    }

                });
        }
    }
</script>
