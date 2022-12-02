
<script type="text/javascript">
    $(function () {
        load_lista_pcvp();
        load_lista_pscv_estadistica();

        $('#tabs_pacientes_pscv').jqxTabs({
            width: '100%',
            theme: 'eh-open',
            position: 'top'});
    });
    function load_lista_pcvp() {
        var div = 'content-pacientes';
        $.post('grid/pacientes.php',{
        },function(data){
            $("#"+div).html(data);
        });
    }
    function load_lista_pscv_estadistica() {
        var div = 'pacientes_estadistica';
        $.post('grid/pacientes_estadistica.php',{
        },function(data){
            $("#"+div).html(data);
        });
    }
    function load_form_nuevo_pcvp() {
        var div = 'content-pacientes';
        $.post('formulario/paciente.php',{
        },function(data){
            $("#"+div).html(data);
        });
    }
    function importar_pacientes_pscv() {
        var div = 'content-pacientes';
        $.post('iframe/import_paciente.php',{
        },function(data){
            $("#"+div).html(data);
        });
    }
</script>
<div id='tabs_pacientes_pscv'
     style="font-size: 0.8em;">
    <ul>
        <li>LISTADO GENERAL</li>
        <li>LISTADO ESTADISTICO</li>
    </ul>
    <div id="content-pacientes" class="content"></div>
    <div  id="pacientes_estadistica" class="content"></div>
</div>

