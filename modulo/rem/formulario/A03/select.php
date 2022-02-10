<?php
?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">APLICACIÓN DE INSTRUMENTO Y RESULTADO EN EL NIÑO (A)</option>
        <option value="B">EVALUACIÓN, APLICACIÓN Y RESULTADOS DE ESCALAS EN  LA MUJER</option>
        <option value="C">RESULTADOS DE LA EVALUACIÓN DEL ESTADO NUTRICIONAL DEL ADOLESCENTE CON CONTROL SALUD INTEGRAL</option>
        <option value="D">OTRAS EVALUACIONES, APLICACIONES Y RESULTADOS DE ESCALAS EN TODAS LAS EDADES</option>
        <option value="E">APLICACIÓN DE PAUTA DETECCIÓN DE FACTORES DE RIESGO PSICOSOCIAL INFANTIL</option>
        <option value="F">TAMIZAJE TRASTORNO ESPECTRO AUTISTA  (MCHAT)</option>
        <option value="G">APLICACIÓN ESCALA MRS EN MUJERES EN EDAD DE CLIMATERIO</option>

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
            $.post('formulario/A03/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        });
    })
</script>
