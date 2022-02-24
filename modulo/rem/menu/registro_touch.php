<?php
include '../../../php/config.php';
session_start();
$rut = $_SESSION['rut'];

?>

<style type="text/css">

    .settings-section
    {

        height: 45px;
        width: 100%;

    }
    .settings-label
    {
        font-weight: bold;
        font-family: Sans-Serif;
        font-size: 14px;
        margin-left: 14px;
        margin-top: 15px;
        float: left;
    }

    .settings-setter
    {
        float: right;
        margin-right: 14px;
        margin-top: 8px;
    }
</style>
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
    function loadFormulario(seccion){
        var form = $("#formulario").val();
        $.post('formulario/'+form+'/'+seccion+'.php',{
        },function(data){
            $("#div_seccion").html(data);
        });
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
    .card_cuadrada{
        height: 50px;
        width: 100%;
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
                        <option value="A05">A05 - INGRESOS Y EGRESOS POR CONDICIÓN Y PROBLEMAS DE SALUD</option>
                        <option value="A06">A06 - PROGRAMA DE SALUD MENTAL ATENCIÓN PRIMARIA Y ESPECIALIDADES</option>
                        <option value="A08">A08 - ATENCIÓN DE URGENCIA</option>
                        <option value="A09">A09 - ATENCIÓN DE SALUD BUCAL EN LA RED ASISTENCIAL </option>
                        <option value="A11">A11 - TRANSMISIÓN VERTICAL MATERNO INFANTIL </option>
                        <option value="A23">A23 - IRA, ERA Y MIXTAS EN APS </option>
                        <option value="A27">A27 - EDUCACIÓN PARA LA SALUD </option>
                        <option value="A32">A32 - ACTIVIDADES DE SALUD PRIORIZADAS, CONTEXTO DE EMERGENCIA SANITARIA </option>
                    </select></label>
            </div>
            <div class="row">
                <label for="rut">RUT
                    <input type="text" name="rut" id="rut" />
                </label>
            </div>
            <div class="row">
                <label for="nombre">NOMBRE COMPLETO
                    <input type="text" name="nombre" id="nombre" />
                </label>
            </div>
            <div class="row">
                <div class="col l6 l6 l6 tooltipped" data-position="bottom" data-delay="50" data-tooltip="MASCULINO">
                    <div class="row center-align">
                        <label class="white-text" for="sexo_m"  >
                            <img src="../../images/rem/masculino.png" height="50px" />
                        </label><br />
                        <input type="radio"
                               style="position: relative;visibility: visible;left: 0px;"
                               id="sexo_m" name="sexo" value="M" checked="checked" >
                    </div>
                </div>
                <div class="col l6 l6 l6 tooltipped" data-position="bottom" data-delay="50" data-tooltip="FEMENINO">
                    <div class="row center-align">
                        <label class="white-text" for="sexo_f">
                            <img src="../../images/rem/femenino.png" height="50px" />
                        </label><br />
                        <input type="radio"
                               style="position: relative;visibility: visible;left: 0px;"
                               id="sexo_f" name="sexo" value="F" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12">
                    <label>BENEFICIARIO
                        <div class="settings-section">
                            <div class="settings-label"></div>
                            <div class="settings-setter">
                                <div id="beneficiario"></div>
                                <input type="hidden" name="input_beneficiario" id="input_beneficiario" value="NO" />
                            </div>
                        </div></label>
                    <script type="text/javascript">
                        $(function(){
                            $('#beneficiario').jqxSwitchButton({
                                height: 27, width: 81,
                                theme: 'eh-open',
                                onLabel:'SI',
                                offLabel:'NO',
                            });
                            $('#beneficiario').on('change',function(){
                                if($('#beneficiario').val()===true){
                                    $("#input_beneficiario").val('SI');
                                }else{
                                    $("#input_beneficiario").val('NO');
                                }
                            });

                        });
                    </script>
                </div>
            </div>
            <div class="row">
                <div class="col l12">
                    <label>PUEBLO ORIGINARIO
                        <div class="settings-section">
                            <div class="settings-label"></div>
                            <div class="settings-setter">
                                <div id="pueblo"></div>
                                <input type="hidden" name="input_pueblo" id="input_pueblo" value="NO" />
                            </div>
                        </div></label>
                    <script type="text/javascript">
                        $(function(){
                            $('#pueblo').jqxSwitchButton({
                                height: 27, width: 81,
                                theme: 'eh-open',
                                onLabel:'SI',
                                offLabel:'NO',
                            });
                            $('#pueblo').on('change',function(){
                                if($('#pueblo').val()===true){
                                    $("#input_pueblo").val('SI');
                                }else{
                                    $("#input_pueblo").val('NO');
                                }
                            });

                        });
                    </script>
                </div>
            </div>
            <div class="row">
                <div class="col l12">
                    <label>POBLACIÓN MIGRANTE
                        <div class="settings-section">
                            <div class="settings-label"></div>
                            <div class="settings-setter">
                                <div id="migrante"></div>
                                <input type="hidden" name="input_migrante" id="input_migrante" value="NO" />
                            </div>
                        </div></label>
                    <script type="text/javascript">
                        $(function(){
                            $('#migrante').jqxSwitchButton({
                                height: 27, width: 81,
                                theme: 'eh-open',
                                onLabel:'SI',
                                offLabel:'NO',
                            });
                            $('#migrante').on('change',function(){
                                if($('#migrante').val()===true){
                                    $("#input_migrante").val('SI');
                                }else{
                                    $("#input_migrante").val('NO');
                                }
                            });

                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="col l10"
             style="padding: 20px;">
            <div class="row" id="id_seccion"></div>
            <div class="row" id="div_seccion"></div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function(){
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
                on_success: function (){
                    var rut = $('#rut').val();
                    buscarDatosPersona(rut,'nombre_completo','nombre');
                    // buscarDatosPersona(rut,'sexo','sexo');
                }
            });
        });
    })
</script>