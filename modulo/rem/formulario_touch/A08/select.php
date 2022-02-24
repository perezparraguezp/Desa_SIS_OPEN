<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A2">ATENCIONES DE URGENCIA REALIZADAS EN SAPU Y SAR </option>
        <option value="A3">ATENCIONES DE URGENCIA REALIZADAS EN ESTABLECIMIENTOS DE BAJA COMPLEJIDAD </option>
        <option value="A4">CONSULTAS EN SISTEMA DE ATENCIÓN DE URGENCIA EN CENTROS DE SALUD RURAL (SUR) Y POSTAS RURALES </option>
        <option value="A5">CONSULTAS EN SISTEMA DE ATENCIÓN DE URGENCIA EN CENTROS DE SALUD RURAL (SUR) Y POSTAS RURALES </option>
        <option value="B">CATEGORIZACIÓN DE PACIENTES, PREVIA A LA ATENCIÓN MÉDICA (Establecimientos Alta, Mediana o Baja Complejidad y SAR) </option>
        <option value="F">PACIENTES FALLECIDOS EN UEH (Establecimientos Alta, Mediana o Baja Complejidad, SAR, SAPU y SUR) </option>
        <option value="G">ATENCIONES MÉDICAS ASOCIADAS A  VIOLENCIA </option>
        <option value="H">ATENCIONES  POR ANTICONCEPCIÓN DE EMERGENCIA </option>
        <option value="O">ATENCIONES  EN URGENCIA POR VIOLENCIA SEXUAL </option>
        <option value="R">ATENCIONES POR MORDEDURA EN SERVICIO DE  URGENCIA DE LA RED </option>
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
            $.post('formulario/A08/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
