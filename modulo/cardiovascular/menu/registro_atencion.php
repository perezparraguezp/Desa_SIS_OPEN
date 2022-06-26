<?php
$rut = $_POST['rut'];
?>
<div style="padding-left: 10px;">
    <!-- REGISTRO POR RUT -->
    <div id="form_busqueda">

        <div class="row center center-align" style="width: 95%;">
            <div class="row">
                <div class="col l12 m12 s12">
                    <p>Ingrese el RUT del paciente para comenzar con el registro.</p>
                </div>
            </div>
            <div class="row" style="width: 40%;">
                <div class="col l12 m12 s12">
                    <label for="rut_paciente">PACIENTE</label>
                    <input id="rut_paciente"
                           name="rut_paciente"
                           value="<?php echo $rut; ?>"
                           type="text" required placeholder="Ej. 11222333-4" />
                </div>
            </div>
            <div class="row" style="width: 40%;">
                <div class="col l12 m12 s12">
                    <label for="fecha_registro">FECHA REGISTRO</label>
                    <input type="date"
                           style="font-size: 0.9em"
                           value="<?php echo date('Y-m-d'); ?>"
                           id="fecha_registro" name="fecha_registro"  />
                </div>
            </div>
            <div class="row" style="width: 40%;">
                <div class="col l12 m12 s12">
                    <button class="btn" onclick="loadFormRegistro_AtencionPCVP()">
                        <i class="mdi-av-my-library-books right"></i>
                        COMENZAR REGISTRO
                    </button>

                </div>
            </div>
        </div>
        <div class="row">
            <div id="div_listado_pacientes_dsm"></div>
        </div>
    </div>


    <div id="form_ficha">
        <div class="row">
            <div class="col l12" id="registroFichaLocal">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function validar_Rut(){
        $('#rut_paciente').Rut({
            on_error: function() {
                $(this).focus();
                //alert('Rut incorrecto');
                alertaLateral('RUT INCORRECTO');
                $('#rut_paciente').val('');
                $(this).css({
                    "border": "solid red 1px"
                });
            }
        });
        $("#rut_paciente").jqxInput({
            placeHolder: "11222333-4", height: 30 });
        $("#fecha_registro").jqxInput({
            placeHolder: "dd/mm/YYYY", height: 30 });
        // $("#button_buscar").jqxButton({ height: 30 });
    }
    $(function(){
        // $('#tabs_formulario_registro').jqxTabs({
        //     width: '100%',
        //     theme: 'eh-open',
        //     height: alto-150,
        //     position: 'top',
        //     scrollPosition: 'both'
        // });

        $("#rut_paciente").jqxInput(
            {
                width:'100%',
                height:25,
                theme: 'eh-open',
                placeHolder: "BUSCAR PACIENTE",
                source: function (query, response) {
                    var dataAdapter = new $.jqx.dataAdapter
                    (
                        {
                            datatype: "json",
                            datafields: [
                                { name: 'rut', type: 'string'},
                                { name: 'nombre', type: 'string'}
                            ],
                            url: 'json/autocomplete_pacientes.php'
                        },
                        {
                            autoBind: true,
                            formatData: function (data) {
                                data.query = query;
                                return data;
                            },
                            loadComplete: function (data) {
                                if (data.length > 0) {
                                    response($.map(data, function (item) {
                                        return item.rut+ ' | '+item.nombre;
                                    }));
                                }
                            }
                        }
                    );
                }
            }
        );

    });
    function loadFormRegistro_AtencionPCVP() {

        var rut = $("#rut_paciente").val();
        if(rut !== ''){
            $.post('formulario/atencion_paciente.php',{
                rut: rut,
                fecha_registro:$("#fecha_registro").val()
            },function(data){
                if(data!='ERROR_RUT'){
                    $("#form_busqueda").hide();
                    $("#registroFichaLocal").html(data);
                    $("#form_ficha").show();
                }else{
                    alertaLateral('EL RUT INGRESADO NO ES VALIDO');
                }

            });
        }else{
            alertaLateral('DEBE INGRESAR UN RUT PARA REALIZAR LA BUSQUEDA');
        }
    }
    function volverFichaSearch_1(){
        $("#form_ficha").hide();
        $("#form_busqueda").show();
    }
    function loadForm_offline(){
        $.post('php/formulario/registro_ficha/registro_offline.php',{
        },function(data){
            $("#div_registro_importacion").html(data);
        });
    }

    function loadForm_gridPacientes_pcvc(){
        $.post('grid/pacientes.php',
            {},function (data){
                $("#div_listado_pacientes_dsm").html(data);
            });
    }
</script>