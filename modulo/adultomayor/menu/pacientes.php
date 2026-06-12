<?php
/**
 * Created by PhpStorm.
 * User: ipapo
 * Date: 5/29/20
 * Time: 11:45 AM
 */

?>
<div id='tabs_pacientes_pscv'
     style="font-size: 0.8em;">
    <ul>
        <li>LISTADO GENERAL</li>
        <li>LISTADO ESTADISTICO</li>
    </ul>
    <div id="content-pacientes" class="content">

    </div>
    <div  id="pacientes_estadistica" class="content"></div>
</div>
<script type="text/javascript">
    $(function(){
        load_lista_am();
        load_lista_am_estadistica();
        $('#tabs_pacientes_pscv').jqxTabs({
            width: '100%',
            height:alto-130,
            theme: 'eh-open',
            position: 'top'});
    });
    function hide_loading(){
        $("#loading_seccion").hide();
    }



    function load_lista_am_estadistica() {
        var div = 'pacientes_estadistica';
        $.post('grid/estadistica.php',{
        },function(data){
            $("#"+div).html(data);
        });
    }
    function load_lista_am() {
        var div = 'content-pacientes';
        loading_div(div);
        $.post('grid/pacientes.php',{
        },function(data){
            $("#"+div).html(data);
            hide_loading();
        });
    }
    function load_form_nuevo_am() {
        var div = 'content-pacientes';
        loading_div(div);
        $.post('formulario/paciente.php',{
        },function(data){
            $("#"+div).html(data);
            hide_loading();
        });
    }
    function importar_pacientes_pscv() {
        var div = 'content-pacientes';
        loading_div(div);
        $.post('iframe/import_paciente.php',{
        },function(data){
            $("#"+div).html(data);
            hide_loading();
        });
    }
</script>
