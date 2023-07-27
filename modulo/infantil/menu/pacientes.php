

<div id='tabs_pacientes_pscv'
     style="font-size: 0.8em;">
    <ul>
        <li>LISTADO GENERAL</li>
        <li>LISTADO ESTADISTICO</li>
    </ul>
    <div id="content-pacientes" class="content">
        <div class="content container" id="div_form_paciente">
        </div>
    </div>
    <div  id="pacientes_estadistica" class="content"></div>
</div>
<script type="text/javascript">
    $(function(){
        loadForm_gridPacientes();
        load_lista_infantil_estadistica();
        $('#tabs_pacientes_pscv').jqxTabs({
            width: '100%',
            theme: 'eh-open',
            position: 'top'});
    });
    function load_lista_infantil_estadistica() {
        var div = 'pacientes_estadistica';
        $.post('grid/estadistica.php',{
        },function(data){
            $("#"+div).html(data);
        });
    }
    function loadForm_newPaciente(){
        $.post('formulario/nuevo_paciente.php',
            {},function (data){
                $("#div_form_paciente").html(data);
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
            });
    }
    function loadForm_gridPacientes(){
        $.post('grid/pacientes.php',
            {},function (data){
                $("#div_form_paciente").html(data);
            });
    }
    function loadForm_ImportPacientes(){
        $.post('iframe/import_paciente.php',
            {},function (data){
                $("#div_form_paciente").html(data);
            });
    }

    function validar_Rut_Paciente(){
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
    }
</script>