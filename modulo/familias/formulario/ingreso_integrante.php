<?php
include '../../../php/config.php';
$id_familia = $_POST['id_familia'];
?>
<style type="text/css">
    #form_paciente input {
        text-align: left;
    }
</style>
<form name="form_paciente"
      id="form_paciente" class="card-panel left-align">
    <input type="hidden" name="id_familia" value="<?php echo $id_familia; ?>"/>
    <script type="text/javascript">
        $(document).ready(function () {
            // Create jqxNavigationBar
            $("#jqxNavigationBar").jqxNavigationBar({width: '100%', theme: 'eh-open', height: 460});
        });
    </script>

    <div id='jqxNavigationBar'>
        <div>DATOS PERSONALES</div>
        <div style="padding: 20px;">

            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">RUT INTEGRANTE</div>
                    <div class="col l8">
                        <input type="text" name="rut"
                               id="rut"
                               placeholder="11222333-4"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">NOMBRE COMPLETO</div>
                    <div class="col l8">
                        <input type="text" name="nombre" id="nombre"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">FECHA DE NACIMIENTO</div>
                    <div class="col l8">
                        <input type="date" name="nacimiento" value="<?php echo date('Y-m-d'); ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">SEXO</div>
                    <div class="col l4">
                        <input type="radio" id="sexo_1" name="sexo" value="M" checked/>
                        <label for="sexo_1">MASCULINO</label>
                    </div>
                    <div class="col l4">
                        <input type="radio" id="sexo_2" name="sexo" value="F"/>
                        <label for="sexo_2">FEMENINO</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">PUEBLO ORIGINARIO</div>
                    <div class="col l4">
                        <input type="radio" id="pueblo_2" name="pueblo" value="SI"/>
                        <label for="pueblo_2">SI</label>
                    </div>
                    <div class="col l4">
                        <input type="radio" id="pueblo_1" name="pueblo" value="NO" checked/>
                        <label for="pueblo_1">NO</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">POBLACIÓN MIGRANTE</div>
                    <div class="col l4">
                        <input type="radio" id="migrante_1" name="migrante" value="SI"/>
                        <label for="migrante_1">SI</label>
                    </div>
                    <div class="col l4">
                        <input type="radio" id="migrante_2" name="migrante" value="NO" checked/>
                        <label for="migrante_2">NO</label>
                    </div>
                </div>
            </div>
        </div>
        <div>DATOS DE CONTACTO</div>
        <div style="padding: 20px;">
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">TELÉFONO</div>
                    <div class="col l8">
                        <input type="text" name="telefono"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">e-Mail</div>
                    <div class="col l8">
                        <input type="text" name="email"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <input type="button"
               value="INGRESAR NUEVO INTEGRANTE"
               style="text-align: center;"
               onclick="insertIntegrante()"
               class="btn waves-effect modal-trigger waves-light col s12 "/>

    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">


    $("#rut").on('change', function () {
        $('#rut').Rut({
            on_error: function () {
                $(this).focus();
                //alert('Rut incorrecto');
                alertaLateral('RUT INCORRECTO');
                $('#rut').val('');
                $('#rut').focus();
                $('#rut').css({
                    "border": "solid red 1px"
                });
            },
            on_success: function () {
                $('#rut').css({
                    "border": "solid green 1px"
                });
                buscarDatosPersona('' + $("#rut").val(), 'nombre_completo', 'nombre', 'text');
                buscarDatosPersona('' + $("#rut").val(), 'fecha_nacimiento', 'nacimiento', 'text');
                buscarDatosPersona('' + $("#rut").val(), 'telefono', 'telefono', 'text');
                buscarDatosPersona('' + $("#rut").val(), 'email', 'email', 'text');
                buscarDatosPersona('' + $("#rut").val(), 'sexo', 'sexo', 'radio');
                buscarDatosPersona('' + $("#rut").val(), 'pueblo', 'pueblo', 'radio');
                buscarDatosPersona('' + $("#rut").val(), 'migrante', 'migrante', 'radio');

            }
        });
    });


    var select = 0;
    $("#id_centro").on('change', function () {
        var centro = $("#id_centro").val();

        $.post('../../php/ajax/select/sectores_centro_option.php', {
            id_centro: centro
        }, function (data) {
            $("#div_sector_id").html('');
            $("#div_sector_id").html('<select id="id_sector_centro" name="id_sector_centro"></select>');
            $("#id_sector_centro").html(data);
            $("#id_sector_centro").jqxDropDownList({width: '100%', height: 30});
        });
    });

    function buscarDatosPersona(rut, column_sql, name_input, tipo) {
        $.post('db/buscar/datos_persona.php', {
            rut: rut,
            columna: column_sql
        }, function (data) {
            if (data !== 'NO EXISTE INFORMACION') {
                // alertaLateral('EL PACIENTE CUENTA CON REGISTROS INTERNOS');
                if (tipo === 'text') {
                    $('input[name="' + name_input + '"]').val(data);
                } else {
                    if (tipo === 'radio') {
                        $('input[name="' + name_input + '"][value="' + data + '"]').prop('checked', true);
                    }
                }
            } else {
                // alertaLateral('DEBE INGRESAR TODOS LOS DATOS DEL PACIENTE');
            }


        });
    }

    function insertIntegrante() {
        if (confirm('Esta seguro que desea registrar este paciente en nuestros registros')) {
            $.post('db/insert/integrante.php',
                $("#form_paciente").serialize(), function (data) {
                    if (data === 'ERROR 1') {
                        alertaLateral('Este integrante ya pertenece a otra familia, no puede ser ingresado');
                    } else {
                        if (data !== 'ERROR_SQL') {
                            alertaLateral('INTEGRANTE ASIGNADO AL GRUPO FAMILIAR');
                            load_integrantes('<?php echo $id_familia; ?>');
                            document.getElementById("close_modal").click();
                            loadMenu_M('menu_3','registro_familia','<?php echo $id_familia; ?>');
                        }
                    }


                });
        }
    }
</script>
