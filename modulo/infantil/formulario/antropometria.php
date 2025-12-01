<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';
$rut = str_replace('.', '', $_POST['rut']);

$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);
$paciente->definirEdadFecha($fecha_registro);
$paciente->loadAntropometria();


?>
<script type="text/javascript">
    var pe, te, pt, imc;
    pe = 0;
    te = 0;
    pt = 0;
    imc = 0;

    function verHistorialInfantil(rut, indicador) {
        $.post('grid/historial_antropometria.php', {
            rut: rut,
            indicador: indicador
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '800px'});
                document.getElementById("btn-modal").click();
            }
        });
    }

    function updateRegistroEspecial() {
        var pe, te, pt, imc, dni;
        pe = 0;
        te = 0;
        pt = 0;
        imc = 0;
        dni = 0;

        var ira = 0;

        if ($("#pe").val() === '') {
            $("#pe").css({'border': 'solid 2px red'});
            pe = 1;
        } else {
            if ($("#pe").val() == null) {
                pe = 0;
            } else {
                $("#pe").css({'border': 'solid 2px green'});
            }
        }
        if ($("#te").val() === '') {
            $("#te").css({'border': 'solid 2px red'});
            te = 1;
        } else {
            if ($("#te").val() == null) {
                te = 0;
            } else {
                $("#te").css({'border': 'solid 2px green'});
            }
        }
        if ($("#pt").val() === '') {
            $("#pt").css({'border': 'solid 2px red'});
            pt = 1;
        } else {
            if ($("#pt").val() == null) {
                pt = 0;
            } else {
                $("#pt").css({'border': 'solid 2px green'});
            }
        }
        if ($("#imce").val() === '') {
            $("#imce").css({'border': 'solid 2px red'});
            imc = 1;
        } else {
            if ($("#imce").val() == null) {
                imc = 0;
            } else {
                $("#imce").css({'border': 'solid 2px green'});
            }
        }
        if ($("#dni").val() === '') {
            $("#dni").css({'border': 'solid 2px red'});
            dni = 1;
        } else {
            if ($("#dni").val() == null) {
                dni = 0;
            } else {
                $("#dni").css({'border': 'solid 2px green'});
            }
        }

        <?php
        if ($paciente->validaIRA()){
        ?>

        if ($("#ira_score").val() === '') {
            $("#ira_score").css({'border': 'solid 2px red'});
            ira = 1;
        } else {
            if ($("#ira_score").val() == null) {
                ira = 0;
            } else {
                $("#ira_score").css({'border': 'solid 2px green'});
            }
        }
        <?php
        }
        ?>


        if ((pe + pt + te + imc + dni + ira) === 0) {
            var val_pe = $("#pe").val();
            $.post('db/update/paciente_antropometria.php', {
                rut: '<?php echo $rut; ?>',
                val: val_pe,
                column: 'PE',
                fecha_registro: '<?php echo $fecha_registro; ?>'

            }, function (data) {


            });
            var val_te = $("#te").val();
            $.post('db/update/paciente_antropometria.php', {
                rut: '<?php echo $rut; ?>',
                val: val_te,
                column: 'TE',
                fecha_registro: '<?php echo $fecha_registro; ?>'

            }, function (data) {

            });
            var val_pt = $("#pt").val();
            $.post('db/update/paciente_antropometria.php', {
                rut: '<?php echo $rut; ?>',
                val: val_pt,
                column: 'PT',
                fecha_registro: '<?php echo $fecha_registro; ?>'

            }, function (data) {

            });
            var val_imc = $("#imce").val();
            $.post('db/update/paciente_antropometria.php', {
                rut: '<?php echo $rut; ?>',
                val: val_imc,
                column: 'IMCE',
                fecha_registro: '<?php echo $fecha_registro; ?>'

            }, function (data) {

            });
            var val_dni = $("#dni").val();
            $.post('db/update/paciente_antropometria.php', {
                rut: '<?php echo $rut; ?>',
                val: val_dni,
                column: 'DNI',
                fecha_registro: '<?php echo $fecha_registro; ?>'

            }, function (data) {

            });

            alert('AHORA QUE LOS REGISTROS FUERON ACTUALIZADOS, DEBERA INDICAR CUAL ES LA FECHA PARA EL PROXIMO CONTROL');
            boxAgendamiento('INFANTIL');
        } else {
            alertaLateral('DEBE REGISTRAR TODOS LOS CAMPOS');
            $('.tooltipped').tooltip({delay: 50});
        }
    }

</script>
<input type="hidden" name="rut" value="<?php echo $rut; ?>"/>
<input type="hidden" name="fecha_registro" id="fecha_registro" value="<?php echo $fecha_registro; ?>"/>
<?php
if ($paciente->validaNutricionista() == true) {
    ?>
    <div class="row">
        <div class="col l12 card-panel light-green lighten-4" style="padding-top: 10px;padding-bottom: 10px;">
            <div class="col l4">EVALUACIÓN NUTRICIONISTA</div>
            <div class="col l8" s>
                <select name="eval_nutricionista" id="eval_nutricionista">
                    <option>NORMAL</option>
                    <option>5 MESES</option>
                    <option value="3 ANIOS 6 MESES">3 AÑOS 6 MESES</option>
                </select>
                <script type="text/javascript">
                    $(function () {
                        $('#eval_nutricionista').jqxDropDownList({
                            width: '100%',
                            theme: 'eh-open',
                            height: '25px'
                        });

                        $("#eval_nutricionista").on('change', function () {
                            var val = $("#eval_nutricionista").val();
                            $.post('db/update/paciente_antropometria.php', {
                                rut: '<?php echo $rut; ?>',
                                val: val,
                                column: 'EVAL_NUTRICIONISTA',
                                fecha_registro: '<?php echo $fecha_registro; ?>'

                            }, function (data) {
                                alertaLateral(data);
                                $('.tooltipped').tooltip({delay: 50});
                            });

                        });
                        $('.tooltipped').tooltip({delay: 50});
                    });
                </script>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row">
    <div class="col l12 m12 s12">
        <?php
        if ($paciente->validaPE()) {
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">PE <strong class="tooltipped" style="cursor: help"
                                                                data-position="bottom" data-delay="50"
                                                                data-tooltip="PESO EDAD">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="pe" id="pe">
                                <option></option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <option value="N">N</option>
                                <option value="-1">-1</option>
                                <option value="-2">-2</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#pe').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#pe").on('change', function () {
                                        updateRegistroEspecial();


                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                });
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','PE')"></i>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->validaTE()) {
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">TE <strong class="tooltipped" style="cursor: help"
                                                                data-position="bottom" data-delay="50"
                                                                data-tooltip="TALLA EDAD">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="te" id="te">
                                <option></option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <option value="N">N</option>
                                <option value="-1">-1</option>
                                <option value="-2">-2</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#te').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#te").on('change', function () {
                                        updateRegistroEspecial();

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','TE')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->total_meses<=12*10) {
            //menores de 1 año
            $editar = true;
            if($paciente->total_meses<2){
                //menores de 1 mes solo se puede editar
                $editar = false;
            }
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">INCREMENTO DE PESO <strong class="tooltipped" style="cursor: help"
                                                                data-position="bottom" data-delay="50"
                                                                data-tooltip="SOLO PUEDE EDITAR EN NIÑOS MENORES DE 1 MES">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="incremento_peso" id="incremento_peso">
                                <option></option>
                                <option>BAJO</option>
                                <option>ADECUADO</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#incremento_peso').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px',
                                        disabled:<?php echo $editar; ?>
                                    });

                                    $("#incremento_peso").on('change', function () {
                                        var val = $("#lme").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'INCREMENTO_PESO',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','INCREMENTO_PESO')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($paciente->validaPT()) {
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">PT <strong class="tooltipped" style="cursor: help"
                                                                data-position="bottom" data-delay="50"
                                                                data-tooltip="PESO TALLA">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="pt" id="pt">
                                <option></option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <option value="N">N</option>
                                <option value="-1">-1</option>
                                <option value="-2">-2</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#pt').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#pt").on('change', function () {
                                        updateRegistroEspecial();

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','PT')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->validaIMCE()) {
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l4">
                            <span class="black-text">IMC/E <strong class="tooltipped" style="cursor: help"
                                                                   data-position="bottom" data-delay="50"
                                                                   data-tooltip="INDICE DE MASA CORPORAL / EDAD">(?)</strong></span>
                        </div>
                        <div class="col l7">
                            <select name="imce" id="imce">
                                <option></option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <option value="N">N</option>
                                <option value="-1">-1</option>
                                <option value="-2">-2</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#imce').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#imce").on('change', function () {
                                        updateRegistroEspecial();

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','IMCE')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        if ($paciente->validaDNI()) {
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">DNI <strong class="tooltipped" style="cursor: help"
                                                                 data-position="bottom" data-delay="50" data-tooltip="">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="dni" id="dni">
                                <option></option>
                                <option>NORMAL</option>
                                <option>SOBREPESO</option>
                                <option>OBESIDAD</option>
                                <option>OB SEVERA</option>
                                <option>Ri DESNUTRICION</option>
                                <option>DESNUTRICION</option>
                                <option>DESNUTRICION SECUNDARIA</option>
                                <option>CONDICION ESPECIAL DE SALUD</option>
                                <option disabled="disabled">--------------</option>
                                <option>NO SE LOGRA EVALUAR</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#dni').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#dni").on('change', function () {
                                        updateRegistroEspecial();


                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','DNI')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col l12 m12 s12">
        <?php
        if ($paciente->validaLME()) {
            ?>
            <div class="col l4 s12 m6">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">TIPO LACTANCIA <strong class="tooltipped" style="cursor: help"
                                                                            data-position="bottom" data-delay="50"
                                                                            data-tooltip="LME">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="lme" id="lme">
                                <option></option>
                                <option value="LME">LME</option>
                                <option>LM/FL</option>
                                <option>FL</option>
                                <option>LM/AC</option>
                                <option>LM/FL/AC</option>
                                <option>FL/AC</option>
                                <option>SIN LME</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#lme').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });
                                    $("#lme").on('change', function () {
                                        var val = $("#lme").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'LME',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','LME')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->validaPCINT()) {
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l4">
                            <span class="black-text">PCint/ed <strong class="tooltipped" style="cursor: help"
                                                                      data-position="bottom" data-delay="50"
                                                                      data-tooltip="PERIMETRO CINTURA">(?)</strong></span>
                        </div>
                        <div class="col l7">
                            <select name="pcint" id="pcint">
                                <option></option>
                                <option value="NORMAL">NORMAL</option>
                                <option value="RIESGO OBESIDAD">RIESGO OBESIDAD</option>
                                <option value="OBESIDAD ABDOMINAL">OBESIDAD ABDOMINAL</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#pcint').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#pcint").on('change', function () {
                                        var val = $("#pcint").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'PCINT',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','PCINT')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->total_meses < (4 * 12)) {
            //menores de 4 años
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l4">
                            <span class="black-text">Asiste con Padre <strong class="tooltipped" style="cursor: help"
                                                                      data-position="bottom" data-delay="50"
                                                                      data-tooltip="El niño viene acompañado de sus padres">(?)</strong></span>
                        </div>
                        <div class="col l7">
                            <select name="con_padres" id="con_padres">
                                <option></option>
                                <option>SI</option>
                                <option>NO</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#con_padres').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#con_padres").on('change', function () {
                                        var val = $("#con_padres").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'con_padres',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','PCINT')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->validaRIMALNEXCESO()) {
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l5">
                            <span class="black-text">Ri MALN EXCESO <strong class="tooltipped" style="cursor: help"
                                                                            data-position="bottom" data-delay="50"
                                                                            data-tooltip="(?)">(?)</strong></span>
                        </div>
                        <div class="col l6">
                            <select name="rimaln" id="rimaln">
                                <option></option>
                                <option>SIN RIESGO</option>
                                <option>CON RIESGO</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#rimaln').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });
                                    $("#rimaln").on('change', function () {
                                        var val = $("#rimaln").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'RIMALN',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','RIMALN')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->validaPRESIONARTERIAL()) {
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l4">
                            <span class="black-text" style="font-size: 0.8em;">PRESION ARTERIAL <strong
                                        class="tooltipped" style="cursor: help" data-position="bottom" data-delay="50"
                                        data-tooltip="PRESION ARTERIAL">(?)</strong></span>
                        </div>
                        <div class="col l7">
                            <select name="presion_arterial" id="presion_arterial">
                                <option></option>
                                <option>NORMAL</option>
                                <option>PRE-HIPERTENSION</option>
                                <option>ETAPA 1</option>
                                <option>ETAPA 2</option>
                                <option disabled="disabled">--------------</option>
                                <option>NO SE LOGRA EVALUAR</option>
                            </select>
                            <script type="text/javascript">

                                $(function () {
                                    $('#presion_arterial').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#presion_arterial").on('change', function () {
                                        var val = $("#presion_arterial").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'presion_arterial',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });
                                        if (val !== '') {
                                            $("#div_atencion_secundaria").show();
                                        } else {
                                            $("#div_atencion_secundaria").hide();
                                        }
                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','presion_arterial')"></i>
                        </div>
                    </div>
                    <div class="row" id="div_atencion_secundaria" style="display: none;">
                        <div class="col l6">
                            <span class="black-text" style="font-size: 0.8em;">ATENCIÓN SECUNDARIA <strong
                                        class="tooltipped" style="cursor: help" data-position="bottom" data-delay="50"
                                        data-tooltip="PACIENTE CON DERIVACION PARA ATENCION SECUNDARIA">(?)</strong></span>
                        </div>
                        <div class="col l6">
                            <select name="atencion_secundaria" id="atencion_secundaria">
                                <option>NO</option>
                                <option>SI</option>
                            </select>
                            <script type="text/javascript">

                                $(function () {
                                    $('#atencion_secundaria').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });

                                    $("#atencion_secundaria").on('change', function () {
                                        var val = $("#atencion_secundaria").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'atencion_secundaria',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }

        ?>
    </div>
</div>
<div class="row">
    <div class="col l12 m12 s12">
        <?php
        if ($paciente->validaPerimetroCraneal()) {
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">PERIMETRO CRANEAL <strong class="tooltipped" style="cursor: help"
                                                                               data-position="bottom" data-delay="50"
                                                                               data-tooltip="RIESGO IRA PARA MENORES DE 3 AÑOS">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="perimetro_craneal" id="perimetro_craneal">
                                <option></option>
                                <option>2</option>
                                <option>1</option>
                                <option>N</option>
                                <option>-1</option>
                                <option>-2</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#perimetro_craneal').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });


                                    $("#perimetro_craneal").on('change', function () {
                                        var val = $("#perimetro_craneal").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'perimetro_craneal',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','perimetro_craneal')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php

        if ($paciente->valida_AgudezaVisual()) {
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">AGUDEZA VIDUAL <strong class="tooltipped" style="cursor: help"
                                                                            data-position="bottom" data-delay="50"
                                                                            data-tooltip="RIESGO IRA PARA MENORES DE 3 AÑOS">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="agudeza_visual" id="agudeza_visual">
                                <option></option>
                                <option disabled>---------</option>
                                <option>NORMAL</option>
                                <option>ALTERADA</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#agudeza_visual').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });


                                    $("#agudeza_visual").on('change', function () {
                                        var val = $("#agudeza_visual").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'agudeza_visual',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','agudeza_visual')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($paciente->valida_AgudezaVisual()) {
            ?>
            <div class="col l4 m6 s12">
                <div class="card-panel eh-open_fondo">
                    <div class="row">
                        <div class="col l3">
                            <span class="black-text">EV. AUDITIVA <strong class="tooltipped" style="cursor: help"
                                                                          data-position="bottom" data-delay="50"
                                                                          data-tooltip="RIESGO IRA PARA MENORES DE 3 AÑOS">(?)</strong></span>
                        </div>
                        <div class="col l8">
                            <select name="evaluacion_auditiva" id="evaluacion_auditiva">
                                <option></option>
                                <option disabled>---------</option>
                                <option>NORMAL</option>
                                <option>ALTERADA</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#evaluacion_auditiva').jqxDropDownList({
                                        width: '100%',
                                        theme: 'eh-open',
                                        height: '25px'
                                    });


                                    $("#evaluacion_auditiva").on('change', function () {
                                        var val = $("#evaluacion_auditiva").val();
                                        $.post('db/update/paciente_antropometria.php', {
                                            rut: '<?php echo $rut; ?>',
                                            val: val,
                                            column: 'evaluacion_auditiva',
                                            fecha_registro: '<?php echo $fecha_registro; ?>'

                                        }, function (data) {
                                            alertaLateral(data);
                                            $('.tooltipped').tooltip({delay: 50});
                                        });

                                    });
                                    $('.tooltipped').tooltip({delay: 50});
                                })
                            </script>
                        </div>
                        <div class="col l1">
                            <i class="mdi-editor-insert-chart"
                               onclick="verHistorialInfantil('<?php echo $rut ?>','evaluacion_auditiva')"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col l12 m12 s12">
        <?php
        if ($paciente->validaIRA()){
        ?>
        <div class="col l12 s12 m12">
            <div class="card-panel red darken-4">
                <div class="row">
                    <div class="col l3">
                        <span class="black-text">SCORE IRA <strong class="tooltipped" style="cursor: help"
                                                                   data-position="bottom" data-delay="50"
                                                                   data-tooltip="RIESGO IRA PARA MENORES DE 7 MESES">(?)</strong></span>
                    </div>
                    <div class="col l8">
                        <select name="ira_score" id="ira_score">
                            <option></option>
                            <option>LEVE</option>
                            <option>MODERADO</option>
                            <option>GRAVE</option>
                        </select>
                        <script type="text/javascript">
                            $(function () {
                                $('#ira_score').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                                $("#ira_score").on('change', function () {
                                    var val = $("#ira_score").val();
                                    $.post('db/update/paciente_antropometria.php', {
                                        rut: '<?php echo $rut; ?>',
                                        val: val,
                                        column: 'SCORE_IRA',
                                        fecha_registro: '<?php echo $fecha_registro; ?>'

                                    }, function (data) {
                                        alertaLateral(data);
                                        $('.tooltipped').tooltip({delay: 50});
                                    });
                                    if (val !== 'LEVE') {
                                        $('#IRA_ATENCION').show("swing");
                                    } else {
                                        $('#IRA_ATENCION').hide("swing");
                                    }

                                });
                                $('.tooltipped').tooltip({delay: 50});
                            })
                        </script>
                    </div>
                    <div class="col l1">
                        <i class="mdi-editor-insert-chart"
                           onclick="verHistorialInfantil('<?php echo $rut ?>','SCORE_IRA')"></i>
                    </div>
                </div>
                <div class="row" id="IRA_ATENCION" style="display: none">
                    <p class="white-text">INDICAR SI TIENE VISITA POR PROFESIONAL KINESIOLOGO</p>
                    <div class="col l3">
                        <span class="black-text">TIENE VISITA <strong class="tooltipped" style="cursor: help"
                                                                      data-position="bottom" data-delay="50"
                                                                      data-tooltip="RIESGO IRA PARA MENORES DE 7 MESES">(?)</strong></span>
                    </div>
                    <div class="col l8">
                        <select name="ira_visita" id="ira_visita">
                            <option></option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                        <script type="text/javascript">
                            $(function () {
                                $('#ira_visita').jqxDropDownList({
                                    width: '100%',
                                    theme: 'eh-open',
                                    height: '25px'
                                });

                                $("#ira_visita").on('change', function () {
                                    var val = $("#ira_visita").val();
                                    $.post('db/update/paciente_antropometria.php', {
                                        rut: '<?php echo $rut; ?>',
                                        val: val,
                                        column: 'VISITA_SCORE',
                                        fecha_registro: '<?php echo $fecha_registro; ?>'

                                    }, function (data) {
                                        alertaLateral(data);
                                        $('.tooltipped').tooltip({delay: 50});
                                    });

                                });
                                $('.tooltipped').tooltip({delay: 50});
                            })
                        </script>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<style type="text/css">
    .btn:hover {
        background-color: #3fff7f;
    }
</style>
