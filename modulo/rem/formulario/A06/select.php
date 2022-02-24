<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">CONTROLES DE ATENCIÓN PRIMARIA / ESPECIALIDADES </option>
        <option value="A02">CONSULTORÍAS DE SALUD MENTAL EN APS </option>
        <option value="B2">PROGRAMA DE REHABILITACIÓN (PERSONAS CON TRASTORNOS PSIQUIÁTRICOS) </option>
        <option value="D"> PLANES Y EVALUACIONES PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN ATENCIÓN PRIMARIA </option>
        <option value="E">PLANES DE CUIDADO INTEGRAL (PCI) </option>
        <option value="I">SALUD MENTAL EN SITUACIONES DE EMERGENCIA O DESASTRE </option>

    </select>
</div>
<script type="text/javascript">
    $(function(){
        $('#seccion').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $("#seccion").on('change',function(){
            var seccion = $("#seccion").val();
            $.post('formulario/A06/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
