<?php
include "../../../php/config.php";
include "../../../php/objetos/persona.php";
include "../../../php/objetos/profesional.php";

$rut = $_POST['rut'];
$fecha_registro = $_POST['fecha_registro'];

$paciente = new persona($rut);


// Obtener columnas
$columnas = array();
$column_query = mysql_query("SHOW COLUMNS FROM sm_registros where Type='int(11)' ");
while ($col = mysql_fetch_array($column_query)) {
    $columnas[] = $col['Field'];
}

// Obtener los datos del registro
$datos_query = mysql_query("SELECT * FROM sm_registros WHERE rut = '$rut' LIMIT 1");
$datos = mysql_fetch_array($datos_query);

$script ='';
foreach ($columnas as $columna) {
    if (isset($datos[$columna]) && $datos[$columna] == 1) {
        $activados[] = $columna;
         $script .= '$("#'.$columna.'").prop("checked", true);';
    }
}


?>
<style type="text/css">
    #form_1_diagnostico{
        font-size: 0.8em;
    }
    #form_1_diagnostico label{
        font-size: 0.9em;
    }
</style>
<script type="text/javascript">
    $(function(){
        $("#form_1_diagnostico input").on('change',function(){
            var item = $(this).attr("id");
            var valor = $(this).is(':checked') ? 1 : 0; // 0 si se desmarca
            $.post('db/update/sm_diagnostico.php',{
                rut:'<?php echo $rut; ?>',
                colum:item,
                valor:valor,
                fecha_registro:'<?php echo $fecha_registro; ?>'
            },function(data){
                alertaLateral('ACTUALIZADO');
            });
        });
        <?php
        echo $script;
        ?>

    })
</script>
<div id="form_1_diagnostico" class="">
    <div class="row">
        <div class="col l2">
            <div class="row">
                <div class="card-panel col l12 light-blue lighten-5 black-text center" style="border: solid 1px black;padding: 10px;">
                    <div class="row">
                        <div class="col l12 center">
                            <div class="row">
                                <div class="col l12">
                                    DATOS ESPECIFICOS
                                </div>
                            </div>
                        </div>
                        <div class="col l12 left-align">
                            <div class="row">
                                <div class="col l12 white-text" style="border: solid 1px black; padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l12">
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="transgenero"
                                                           name="transgenero"  />
                                                    <label class="white-text" for="transgenero">TRANSGENERO</label>
                                                </div>
                                            </div>
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="gestante"
                                                           name="gestante"  />
                                                    <label class="white-text" for="gestante">GESTANTE</label>
                                                </div>
                                            </div>
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="madre_menor"
                                                           name="madre_menor"  />
                                                    <label class="white-text" for="madre_menor">MADRE DE < 5 AÑOS</label>
                                                </div>
                                            </div>
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="sename"
                                                           name="sename"  />
                                                    <label class="white-text" for="sename">SENAME</label>
                                                </div>
                                            </div>
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="mejor_ninez"
                                                           name="mejor_ninez"  />
                                                    <label class="white-text" for="mejor_ninez">MEJOR NIÑEZ</label>
                                                </div>
                                            </div>
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="programa"
                                                           name="programa"  />
                                                    <label class="white-text" for="programa">PROG. ACOMPAÑAMIENTO</label>
                                                </div>
                                            </div>
                                            <div class="row light-blue lighten-2 white-text" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="plan_cuidado"
                                                           name="plan_cuidado"  />
                                                    <label class="white-text" for="plan_cuidado">PLAN CUIDADO INTEGRAL E.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l2">
            <div class="row">
                <div class="card-panel col l12 green lighten-5 black-text center" style="border: solid 1px black;padding: 10px;">
                    <div class="row">
                        <div class="col l12 center">
                            <div class="row">
                                <div class="col l12">
                                    FACTORES DE RIESGO Y CONDICIONES DE LA SALUD MENTAL
                                </div>
                            </div>
                        </div>
                        <div class="col l12 left-align">
                            <div class="row">
                                <div class="col l12 green darken-4 white-text" style="border: solid 1px black; padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l6 center-align">
                                            <header>VIOLENCIA FISICA</header>
                                        </div>
                                        <div class="col l6">
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f34"
                                                           name="f34"  />
                                                    <label class="black-text" for="f34">VICTIMA</label>
                                                </div>
                                            </div>
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f35"
                                                           name="f35"  />
                                                    <label class="black-text" for="f35">AGRESOR</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l12 green darken-4 white-text" style="border: solid 1px black; padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l6 center-align">
                                            <header>VIOLENCIA SEXUAL</header>
                                        </div>
                                        <div class="col l6">
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f34a"
                                                           name="f34a"  />
                                                    <label class="black-text" for="f34a">VICTIMA</label>
                                                </div>
                                            </div>
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f35a"
                                                           name="f35a"  />
                                                    <label class="black-text" for="f35a">AGRESOR</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l12 green darken-4 white-text" style="border: solid 1px black; padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l6 center-align">
                                            <header>VIOLENCIA PSICOLOGICA</header>
                                        </div>
                                        <div class="col l6">
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f34b"
                                                           name="f34b"  />
                                                    <label class="black-text" for="f34b">VICTIMA</label>
                                                </div>
                                            </div>
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f35b"
                                                           name="f35b"  />
                                                    <label class="black-text" for="f35b">AGRESOR</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col l12 green darken-4 white-text" style="border: solid 1px black; padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l6 center-align">
                                            <header>SUICIDIO</header>
                                        </div>
                                        <div class="col l6">
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f36"
                                                           name="f36"  />
                                                    <label class="black-text" for="f36">IDEACIÓN</label>
                                                </div>
                                            </div>
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f37"
                                                           name="f37"  />
                                                    <label class="black-text" for="f37">INTENTO</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col l12" style=";padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l12">
                                            <div class="row green lighten-3" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f38"
                                                           name="f38"  />
                                                    <label class="black-text" for="f38">ABUSO SEXUAL</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l2" style="margin-left: 10px;">
            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;">
                    <div class="row">
                        <div class="col l12 center">TRANSTORNO DEL <br />HUMOR (AFECTIVOS)</div>
                        <div class="col l12 left-align">
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f1"
                                           name="f1"  />
                                    <label class="black-text" for="f1">DEP. LEVE</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f2"
                                           name="f2"  />
                                    <label class="black-text" for="f2">DEP. MOD</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f3"
                                           name="f3"  />
                                    <label class="black-text" for="f3">DEP. GRAVE</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f4"
                                           name="f4"  />
                                    <label class="black-text" for="f4">POST PARTO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f5"
                                           name="f5"  />
                                    <label class="black-text" for="f5">T. BIPOLAR</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;">
                    <div class="row">
                        <div class="col l12 center">TRANSTORNO DEL <br />COMPORTAMIENTO Y DE LAS EMOCIONES DE  COMIENZO HABITUAL EN LA INFNAICA Y ADOLESCENCIA</div>
                        <div class="col l12 left-align">
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f1"
                                           name="f1"  />
                                    <label class="black-text" for="f1">DEP. LEVE</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f6"
                                           name="f6"  />
                                    <label class="black-text" for="f6">T. HIPERCINÈTICO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f7"
                                           name="f7"  />
                                    <label class="black-text" for="f7">T. DISOCIAL DESAFIANTE Y OPOSICIONISTA</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f8"
                                           name="f8"  />
                                    <label class="black-text" for="f8">T. ANSIEDAD DE SEPARACION EN LA INF.</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f9"
                                           name="f9"  />
                                    <label class="black-text" for="f9">OTROS T. DE INICIO EN INFANCIA Y ADOLESCENCIA</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l2" style="margin-left: 10px;">
            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;padding: 10px;">
                    <div class="row">
                        <div class="col l12 center">
                            <div class="row">
                                <div class="col l12">
                                    TRANSTORNO POR <br />CONSUMO DE PSICOTROPICOS
                                </div>
                            </div>
                        </div>
                        <div class="col l12 left-align">
                            <div class="row">
                                <div class="col l12 red lighten-3" style="border: solid 1px black; padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l6 center-align">
                                            <header>CONSUMO <br />PERJUDICIAL</header>
                                        </div>
                                        <div class="col l6">
                                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f10"
                                                           name="f10"  />
                                                    <label class="black-text" for="f10">ALCOHOL</label>
                                                </div>
                                            </div>
                                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f11"
                                                           name="f11"  />
                                                    <label class="black-text" for="f11">DROGAS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col l12 red lighten-3" style="border: solid 1px black;padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l6 center-align">
                                            <header>CONSUMO <br />DEPENDIENTE</header>
                                        </div>
                                        <div class="col l6">
                                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f10"
                                                           name="f10"  />
                                                    <label class="black-text" for="f10">ALCOHOL</label>
                                                </div>
                                            </div>
                                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f11"
                                                           name="f11"  />
                                                    <label class="black-text" for="f11">DROGAS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col l12" style=";padding-top: 10px;" >
                                    <div class="row">
                                        <div class="col l12">
                                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                                <div class="col l12">
                                                    <input type="checkbox" id="f12"
                                                           name="f12"  />
                                                    <label class="black-text" for="f12">CONSUMO DROGAS Y ALCOHOL</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;">
                    <div class="row">
                        <div class="col l12 center">DEMENCIAS <br /> (INCLUYE ALZHEIMER)</div>
                        <div class="col l12 left-align">
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f13"
                                           name="f13"  />
                                    <label class="black-text" for="f13">LEVE</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f14"
                                           name="f14"  />
                                    <label class="black-text" for="f14">MODERADO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f15"
                                           name="f15"  />
                                    <label class="black-text" for="f15">AVANZADO</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l2" style="margin-left: 10px;">
            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;">
                    <div class="row">
                        <div class="col l12 center">TRASTORNOS DE <br /> ANSIEDAD</div>
                        <div class="col l12 left-align">
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f16"
                                           name="f16"  />
                                    <label class="black-text" for="f16">T. ESTRÉS POST TRAUMATICO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f17"
                                           name="f17"  />
                                    <label class="black-text" for="f17">T. PANICO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f18"
                                           name="f18"  />
                                    <label class="black-text" for="f18">FOBIAS SOCIALES</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f19"
                                           name="f19"  />
                                    <label class="black-text" for="f19">T. ANSIEDAD GENERALIZADA</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f20"
                                           name="f20"  />
                                    <label class="black-text" for="f20">OTROS T. DECANSIEDAD</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;">
                    <div class="row">
                        <div class="col l12 center">TRASTORNOS DE <br /> GENERALIZADOS DEL DESARROLLO</div>
                        <div class="col l12 left-align">
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f21"
                                           name="f21"  />
                                    <label class="black-text" for="f21">AUTISMO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f22"
                                           name="f22"  />
                                    <label class="black-text" for="f22">ASPERGER</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f23"
                                           name="f23"  />
                                    <label class="black-text" for="f23">S. DE RETT</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f24"
                                           name="f24"  />
                                    <label class="black-text" for="f24">T. DE SINTEGRATIVO DE LA INF.</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="f25"
                                           name="f25"  />
                                    <label class="black-text" for="f25">T. GENERALIZADO DEL DESARROLLO NO ESP.</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l2" style="margin-left: 10px;">
            <div class="row">
                <div class="card-panel col l12 red darken-3 white-text center" style="border: solid 1px black;">
                    <div class="row">
                        <div class="col l12 center">OTROS TRASTORNOS Y ENFERMEDADES</div>
                        <div class="col l12 left-align">
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t27"
                                           name="t27"  />
                                    <label class="black-text" for="t27">EZQUISOFRENIA</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t28"
                                           name="t28"  />
                                    <label class="black-text" for="t28">RETRASO MENTAL</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t29"
                                           name="t29"  />
                                    <label class="black-text" for="t29">EPILEPSIA</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t30"
                                           name="t30"  />
                                    <label class="black-text" for="t30">TRANSTORNO ADAPTATIVO</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t31"
                                           name="t31"  />
                                    <label class="black-text" for="t31">T. DE LA CDTA. ALIMENTARIA</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t32"
                                           name="t32"  />
                                    <label class="black-text" for="t32">T. DE LA PERSONALIDAD</label>
                                </div>
                            </div>
                            <div class="row red lighten-4" style="border: solid 1px black;padding-left: 20px;">
                                <div class="col l12">
                                    <input type="checkbox" id="t33"
                                           name="t33"  />
                                    <label class="black-text" for="t33">OTROS</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>