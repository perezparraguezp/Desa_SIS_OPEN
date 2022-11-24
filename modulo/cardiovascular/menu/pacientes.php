
<!--<div class="row">-->
<!--    <div class="col l12">-->
<!--        <div class="col l4">-->
<!--            <a class="btn waves-effect waves-light col s12" onclick="load_form_nuevo_pcvp()"><i class="mdi-social-person"></i>REGISTRAR NUEVO PACIENTE</a>-->
<!--        </div>-->
<!--        <div class="col l4">-->
<!--            <a class="btn waves-effect waves-light col s12" onclick="load_lista_pcvp()"><i class="mdi-action-account-child"></i> VER LISTADO DE PACIENTES</a>-->
<!--        </div>-->
<!--        <div class="col l4">-->
<!--            <a class="btn light-green lighten-2 col s12" onclick="importar_pacientes_pscv()"><i class="mdi-communication-import-export"></i> IMPORTAR PACIENTES</a>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

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
<div id='tabs_pacientes_pscv' style="font-size: 0.8em;">
    <ul>
        <li>LISTADO GENERAL</li>
        <li>LISTADO ESTADISTICO</li>
    </ul>
    <div id="content-pacientes" class="content"></div>
    <div  id="pacientes_estadistica" class="content"></div>
</div>

