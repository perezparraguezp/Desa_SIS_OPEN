<?php
include '../../../php/config.php';
include '../../../php/objetos/profesional.php';
$id_familia = $_POST['id_familia'];
$id_establecimiento =1;
session_start();
$profesional = new profesional($_SESSION['id_usuario']);
?>
<style type="text/css">
    #form_paciente input{
        text-align: left;
    }
</style>
<form name="form_vdi"
      id="form_vdi" class="card-panel left-align modal-content">
    <input type="hidden" name="id_familia" value="<?php echo $id_familia; ?>" />
    <input type="hidden" name="id_profesional" value="<?php echo $profesional->id_profesional; ?>" />
    <script type="text/javascript">
        $(document).ready(function () {
            // Create jqxNavigationBar
            $("#jqxNavigationBar").jqxNavigationBar({ width: '100%',theme: 'eh-open', height: 460});

        });
    </script>

    <div id='jqxNavigationBar'>
        <div>PROFESIONAL QUE REGISTRA LA FAMILIA: <?php echo $profesional->nombre; ?></div>
        <div style="padding: 20px;">
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">SECTOR</div>
                    <div class="col l8">
                        <select name="sector_familia" id="sector_familia">
                            <option value="-1">SELECCIONE UN SECTOR COMUNAL</option>
                            <?php
                            $sql1 = "select * from sector_comunal 
                          where id_establecimiento='$id_establecimiento' 
                          order by nombre_sector_comunal asc";
                            $res1 = mysql_query($sql1);
                            while($row1 = mysql_fetch_array($res1)){
                                ?>
                                <option value="<?php echo strtoupper($row1['id_sector_comunal']); ?>"><?php echo strtoupper($row1['nombre_sector_comunal']); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">CENTRO MEDICO</div>
                    <div class="col l8" >
                        <select name="id_centro" id="id_centro">
                            <option value="-1">SELECCIONE UN CENTRO MEDICO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">SECTOR CENTRO</div>
                    <div class="col l8" id="div_sector_id">
                        <select name="id_sector_centro" id="id_sector_centro">
                            <option value="-1">SELECCIONAR SECTOR DEL CENTRO MEDICO</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">NOMBRE DE LA FAMILIA</div>
                    <div class="col l8">
                        <input type="text" name="nombre" id="nombre" placeholder="EJEMPLO: GONZALES-ROJAS" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">CODIGO DE LA FAMILIA</div>
                    <div class="col l8">
                        <input type="text" name="codigo_familia" id="codigo_familia" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col l12 m12 s12">
                    <div class="col l4">DIRECCION</div>
                    <div class="col l8">
                        <textarea id="direccion" name="direccion"></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr />
    <div class="row">
        <input type="button"
               value="REGISTRAR FAMILIA"
               style="text-align: center;"
               onclick="insertFamilia()"
               class="btn waves-effect modal-trigger waves-light col s12 " />

    </div>
</form>
<div class="modal-footer">
    <a href="#" id="close_modal" class="waves-effect waves-red btn-flat modal-action modal-close">CERRAR</a>
</div>
<script type="text/javascript">
    $(function(){
        $('#sector_familia').jqxDropDownList({
            width: '98%',
            theme: 'eh-open',
            height: '25px'
        });
        $("#sector_familia").on('change',function(){

            var id_sector_comunal = $("#sector_familia").val();
            $.post('ajax/select/centro_medico.php', {
                id:id_sector_comunal
            }, function (data) {
                $("#id_centro").html(data);

                $('#id_centro').jqxDropDownList({
                    width: '98%',
                    theme: 'eh-open',
                    height: '25px'
                });

                $("#id_centro").on('change',function(){
                    var centro = $("#id_centro").val();
                    $.post('../default/ajax/select/sectores_centro_interno.php',{
                        id_centro:centro
                    },function(data){
                        $("#div_sector_id").html('');
                        $("#div_sector_id").html('<select id="id_sector_centro" name="id_sector_centro"></select>');
                        $("#id_sector_centro").html(data);
                        $("#id_sector_centro").jqxDropDownList({width: '100%',theme: 'eh-open', height: 30});
                    });
                });

            });
        });



    })

    function insertFamilia(){
        var id_centro = $("#id_centro").val();
        var nombre = $("#nombre").val();
        var direccion = $("#direccion").val();

        if(id_centro!=='-1'){
            if(nombre!==''){
                if(direccion!==''){
                    if(confirm('Desea Crear Esta Familia en el Sistema')){
                        $.post('db/insert/familia.php',
                            $("#form_vdi").serialize(),function (data){
                                if(data!=='ERROR_SQL'){
                                    alertaLateral('REGISTRO EXITOSO!');
                                    load_lista_familias();
                                    document.getElementById("close_modal").click();


                                }

                            });
                    }
                }else{

                    $("#direccion").css({'border':'solid 1px red'});
                    alertaLateral('DEBE INDICAR UNA DIRECCION');
                    $("#direccion").focus();

                }
            }else{
                alertaLateral('DEBE INDICAR NOMBRE PARA LA FAMILIA');
            }
        }else{
            alertaLateral('DEBE SELECCIONAR EL CENTRO AL QUE PERTENECERA LA FAMILIA');
        }


    }
</script>
