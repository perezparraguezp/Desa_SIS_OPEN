<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">PERSONAS QUE INGRESAN A EDUCACIÓN GRUPAL SEGÚN ÁREAS TEMÁTICAS Y EDAD</option>
        <option value="B">CONSULTA MÉDICA EN ATENCIÓN PRIMARIA DE SALUD POR LLAMADA TELEFÓNICA</option>
        <option value="D">ATENCIÓN ODONTOLÓGICA NIVEL PRIMARIO</option>
        <option value="E1">ACCIONES TELEFÓNICAS DE SALUD MENTAL (APS Y ESPECIALIDAD)</option>
        <option value="E2">CONTROLES DE SALUD MENTAL REMOTOS (APS Y ESPECIALIDAD)</option>
        <option value="F">ACCIONES DE SEGUIMIENTO TELEFÓNICO EN EL PROGRAMA DE SALUD CARDIOVASCULAR EN APS EN EL CONTEXTO DE EMERGENCIA SANITARIA</option>
        <option value="G"> HOSPITALIZACIÓN DOMICILIARIA EN APS </option>
        <option value="I">ACTIVIDADES DE ACOMPAÑAMIENTO REMOTO A PERSONAS MAYORES Y SUS FAMILIAS POR PARTE DEL PROGRAMA MÁS ADULTOS</option>
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
            $.post('formulario/A32/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
