<?php
?>
<script type="text/javascript">
    $(function(){

    });
    function loadFormulario(seccion){
        $.post('formulario/A01/'+seccion+'.php',{
        },function(data){
            $("#div_seccion").html(data);
        });
    }
</script>
<div class="row">
    <div class="card col l2 eh-open_principal" style="padding: 20px;margin-left: 5px;" onclick="loadFormulario('A')">
        CONTROLES DE SALUD SEXUAL Y REPRODUCTIVA
    </div>
    <div class="card col l2 eh-open_principal" style="padding: 20px;margin-left: 5px;" onclick="loadFormulario('B')">
        CONTROLES DE SALUD SEGUN SICLO VITAL
    </div>
    <div class="card col l2 eh-open_principal" style="padding: 20px;margin-left: 5px;" onclick="loadFormulario('C')">
        CONTROLES SEGÚN PROBLEMAS DE SALUD
    </div>
</div>
