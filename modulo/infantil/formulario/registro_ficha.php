<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';
include '../../../php/objetos/profesional.php';
//$rut = str_replace('.','',$_POST['rut']);
list($rut,$nombre) = explode(" | ",$_POST['rut']);
$fecha_registro = $_POST['fecha_registro'];
if($fecha_registro==''){
    $fecha_registro = date('Y-m-d');
}

$paciente = new persona($rut);

$paciente->definirEdadFecha($fecha_registro);

$profesional = new profesional($_SESSION['id_usuario']);
if($paciente->existe==false){
    ?>
    <div class="container">
        <div class="row">
            <div class="col l4 center-align">
                <img src="../no_modulo.png" width="200" />
            </div>
            <div class="col l8 center-align">
                <fieldset>
                    <legend>INFORMACIÓN</legend>
                    <?php
                    if(valida_rut($rut)==true){
                        ?><p><header>EL RUN <strong><?php echo formatoRUT($rut); ?></strong> NO SE ENCUENTRA EN LOS REGISTROS.</header></p>
                        <p>VERIFIQUE LA INFORMACION Y PROCEDA A INGRESAR EL PACIENTE EN EL MODULO DE INGRESO.</p>
                        <div class="card-panel PANEL_MENU_SIS" style="background-color: #f1ffc5;">
                            <div class="row">
                                <div class="col l4 m4 s4">
                                    <i class="mdi-social-people"></i>
                                </div>
                                <div class="col l8 m8 s8">
                                    <a style="color: black" href="../some/" target="_blank">
                                        <strong>INGRESO DE PACIENTES</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else{
                        ?><p><header>EL RUN <strong><?php echo formatoRUT($rut); ?></strong> NO ES VALIDO, VERIFIQUE ESTA INFORMACION.</header></p>

                        <?php
                    }
                    ?>

                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col l12">
                <input type="button"
                       style="width: 100%;"
                       onclick="loadMenu_Infantil('menu_1','registro_tarjetero','<?php echo $rut; ?>')"

                       class="btn-large red lighten-2 white-text"
                       value=" <-- VOLVER" />
            </div>
        </div>
    </div>
    <?php
}else{

    if($paciente->getModuloPaciente('m_infancia')=='NO'){
        ?>
        <div class="container">
            <div class="row">
                <div class="col l4 center-align">
                    <img src="../no_modulo.png" width="200" />
                </div>
                <div class="col l8 center-align">
                    <fieldset>
                        <legend>INFORMACIÓN</legend>
                        <?php
                        if(valida_rut($rut)==true){
                            ?><p><header>EL RUN <strong><?php echo formatoRUT($rut); ?></strong> ES VALIDO, PERO NO SE ENCUENTRA EN LOS REGISTROS DE ESTE MODULO.</header></p>
                            <p>DEBE DIRIGIRSE AL MODULO DE INGRESO DE PACIENTES Y VERIFICAR ESTA INFORMACIÓN.</p>
                            <div class="card-panel PANEL_MENU_SIS" style="background-color: #f1ffc5;">
                                <div class="row">
                                    <div class="col l4 m4 s4">
                                        <i class="mdi-social-people"></i>
                                    </div>
                                    <div class="col l8 m8 s8">
                                        <a style="color: black" href="../some/index.php" target="_blank">
                                            <strong>INGRESO DE PACIENTES</strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }else{
                            ?><p><header>EL RUN <strong><?php echo formatoRUT($rut); ?></strong> NO ES VALIDO, VERIFIQUE ESTA INFORMACION.</header></p>

                            <?php
                        }
                        ?>

                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col l12">
                    <input type="button"
                           style="width: 100%;"
                           onclick="loadMenu_Infantil('menu_1','registro_tarjetero','<?php echo $rut; ?>')"
                           class="btn-large red lighten-2 white-text"
                           value=" <-- VOLVER" />
                </div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                // Create jqxTabs.
                $('#tabs_registro').jqxTabs({ width: '100%', height: 450,theme: 'eh-open',
                    position: 'top',scrollPosition: 'both',selectedItem: 1});

                loadInfoPaciente('<?php echo $rut; ?>');
                //antropometria
                loadFormAntropometria('<?php echo $rut; ?>');
                loadFormVacunas('<?php echo $rut; ?>');
                historial_psicomotor('<?php echo $rut; ?>');
                loadFormPendientes('<?php echo $rut; ?>');
                loadFormPsicomotor('<?php echo $rut; ?>');
                loadFormDental('<?php echo $rut; ?>');
                loadInfoNacimiento('<?php echo $rut; ?>');
            });
            function loadInfoPaciente(rut){
                $.post('../default/banner_paciente.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#info_paciente").html(data);
                });
            }
            function loadInfoNacimiento(rut){
                $.post('formulario/datos_nacimiento.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#form_datos_nacimiento").html(data);
                });
            }
            function loadHistorialPaciente(rut) {
                $.post('php/info/registro_ficha/historial_general.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#form_historial").html(data);
                });
            }
            function historial_psicomotor(rut){
                $.post('info/historial_psicomotor.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#historial_psicomotor").html(data);
                });
            }
            function historial_dental(rut){
                $.post('info/historial_dental.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#historial_dental").html(data);
                });
            }
            function loadFormPsicomotor(rut){
                $.post('formulario/psicomotor.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#form_psicomotor").html(data);
                });
            }
            function loadFormDental(rut){
                $.post('formulario/dental.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#form_dental").html(data);
                });
            }
            function loadFormAntropometria(rut){
                $.post('formulario/antropometria.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'

                },function(data){
                    $("#form_antropometria").html(data);
                });
            }
            function loadFormVacunas(rut){
                $.post('formulario/vacunas.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'
                },function(data){
                    $("#form_vacunas").html(data);
                });
            }
            function loadFormPendientes(rut){
                $.post('formulario/pendientes.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'
                },function(data){
                    $("#form_pendientes").html(data);
                });
            }
            function loadFormNANEA(rut){
                $.post('formulario/nanea.php',{
                    rut:rut,
                    fecha_registro:'<?php echo $fecha_registro; ?>'
                },function(data){
                    $("#form_nanea").html(data);
                });
            }
            function insertAntropometria() {
                $.post('php/db/insert/antropometria.php',
                    $("#form_antropometria").serialize()
                    ,function(data){
                        $("#form_vacunas").html(data);
                    });
            }
            function updatePaciente(){
                $.post('php/db/update/paciente.php',
                    $("#form_perfil").serialize(),function(data){
                        alertaLateral(data);
                        loadInfoPaciente('<?php echo $rut; ?>');
                    });
            }
            function boxAgendamiento(modulo){
                $.post('../default/modal/agenda/proxima_cita.php',{
                    rut:'<?php echo $rut; ?>',
                    modulo:modulo
                },function(data){
                    if(data !== 'ERROR_SQL'){
                        $("#modal").html(data);
                        $("#modal").css({'width':'800px'});
                        document.getElementById("btn-modal").click();
                    }
                });
            }
            function boxHistorialPaciente(rut){
                $.post('modal/historial.php',{
                    rut:rut,
                },function(data){
                    if(data !== 'ERROR_SQL'){
                        $("#modal").html(data);
                        $("#modal").css({'width':'1100px'});
                        document.getElementById("btn-modal").click();
                    }
                });
            }
            function boxEditarPaciente(rut) {
                $.post('../default/formulario/editar_paciente.php',{
                    rut:rut,
                },function(data){
                    if(data !== 'ERROR_SQL'){
                        $("#modal").html(data);
                        $("#modal").css({'width':'1100px'});
                        document.getElementById("btn-modal").click();
                    }
                });
            }
            function loadHistorialVacunas(){
                $.post('info/vacunas.php',{
                    rut:'<?php echo $rut; ?>'
                },function(data){
                    $("#div_historialVacunas").html(data);
                });
            }
            function box_HistorialGeneral(){
                $.post('../default/modal/historial.php',{
                    rut:'<?php echo $rut; ?>'
                },function(data){
                    if(data !== 'ERROR_SQL'){
                        $("#modal").html(data);
                        $("#modal").css({'width':'800px'});
                        document.getElementById("btn-modal").click();
                    }
                });
            }


        </script>
        <div class="col l12" style="padding-top: 10px;">
            <div class="row">
                <div class="col l10" >
                    <div id="info_paciente" class="card-panel" style="font-size: 0.7em;">

                    </div>
                </div>
                <div class="col l2">
                    <div class="card center" style="font-size: 0.7em;">
                        <div class="row">
                            <button style="width: 100%;height: 30px;line-height: 20px;"
                                    onclick="boxEditarPaciente('<?php echo $rut; ?>')"
                                    class="btn-large open_principal white-text">
                                <i class="mdi-image-edit right " style="font-size: 0.9em;"></i> EDITAR
                            </button>
                        </div>
                        <div class="row">
                            <button style="width: 100%;height: 30px;line-height: 20px;"
                                    onclick="box_HistorialGeneral('<?php echo $rut; ?>')"
                                    class="btn-large open_principal white-text">
                                <i class="mdi-action-history right" style="font-size: 0.9em;"></i> HISTORIAL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="font-size: 0.9em;">
                <?php
                if($fecha_registro!=date('Y-m-d')){
                    ?>
                    <div class="col l10">Profesional <strong><?php echo $profesional->nombre; ?></strong></div>
                    <div class="col l2" style="padding-right: 10px;text-align: right;animation-name: parpadeo;background-color: red;color: white;font-weight: bold;">FECHA REGISTRO <?php echo fechaNormal($fecha_registro); ?></div>
                    <?php
                }else{
                    ?>
                    <div class="col l10">Profesional <strong><?php echo $profesional->nombre; ?></strong></div>
                    <div class="col l2 right-align" style="padding-right: 10px;text-align: right;background-color: #0D47A1;color: white;font-weight: bold;">FECHA REGISTRO <?php echo fechaNormal($fecha_registro); ?></div>
                    <?php
                }
                ?>

            </div>
            <div id='tabs_registro' style="font-size: 0.8em;">
                <ul>
                    <li style="margin-left: 30px;text-align: center">DATOS DE NACIMIENTO</li>
                    <li style="margin-left: 30px;">ANTROPOMETRIA</li>
                    <?php
                    if($paciente->nanea!=''){
                        ?>
                        <li onclick="loadFormNANEA('<?php echo $rut; ?>');" style="background-color: yellow;">NANEA</li>
                    <?php
                    }
                    ?>
                    <li onclick="loadHistorialVacunas()">REGISTRO VACUNAS</li>
                    <li onclick="historial_psicomotor('<?php echo $rut; ?>');">DESARROLLO PSICOMOTOR</li>
                    <li onclick="historial_dental('<?php echo $rut; ?>')">PROGRAMA DENTAL</li>
                    <li onclick="loadFormPendientes('<?php echo $rut; ?>');">PENDIENTES</li>
                    <li style="background-color: #0a73a7;cursor: pointer;color: white" onclick="boxAgendamiento('INFANTIL')">FINALIZAR ATENCIÓN</li>
                </ul>
                <div>
                    <!-- DATOS DE NACIMIENTO -->
                    <form name="form_datos_nacimiento" id="form_datos_nacimiento" class="col l12"></form>
                </div>
                <div>
                    <!-- ANTROPOMETRIA -->
                    <form name="form_antropometria" id="form_antropometria" class="col l12"></form>
                </div>
                <?php
                if($paciente->nanea!=''){
                    ?>
                    <div>
                        <!-- NANEA -->
                        <form name="form_nanea" id="form_nanea" class="col l12"></form>
                    </div>
                    <?php
                }
                ?>
                <div>
                    <!-- VACUNAS -->
                    <form name="form_vacunas" id="form_vacunas" class="col l12"></form>
                </div>
                <div>
                    <!-- PSICOMOTOR -->
                    <form name="form_psicomotor" id="form_psicomotor" class="col l12"></form>
                </div>
                <div>
                    <!-- DENTAL -->
                    <form name="form_dental" id="form_dental" class="col l12"></form>
                </div>
                <div>
                    <!-- PENDIENTES -->
                    <form name="form_pendientes" id="form_pendientes" class="col l12"></form>
                </div>
                <div></div>
            </div>
            <div class="row">
                <div class="col l3">
                    <input type="button"
                           style="width: 100%;"
                           onclick="loadMenu_Infantil('menu_1','registro_tarjetero','<?php echo $rut; ?>')"
                           class="btn-large red lighten-2 white-text"
                           value=" <-- VOLVER" />
                </div>
                <div class="col l9">
                    <input type="button" style="width: 100%;"
                           onclick="boxAgendamiento('INFANTIL')"
                           class="btn-large eh-open_principal" VALUE="FINALIZAR ATENCIÓN" />
                </div>
            </div>
        </div>

        <?php
    }
}



?>
