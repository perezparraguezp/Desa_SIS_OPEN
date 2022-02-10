<?php
?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">REALIZADO POR PROFESIONAL</option>
        <option value="B">CONTROLES DE SALUD SEGUN SICLO VITAL</option>
        <option value="C">CONTROLES SEGÚN PROBLEMAS DE SALUD</option>
        <option value="D">CONTROLES DE SALUD INTEGRAL DE ADOLESCENTES</option>
        <option value="E">CONTROLES DE SALUD EN ESTABLECIMIENTO EDUCACIONAL</option>
        <option value="F">CONTROLES INTEGRALES DE PERSONAS CON CONDICIONES CRÓNICAS</option>
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
            $.post('formulario/A02_xls/'+seccion+'.php',{
                fecha_inicio:$("#fecha_inicio").val(),
                fecha_termino:$("#fecha_terminio").val(),
                lugar:$("#lugar").val(),
                formulario:$("#formulario_informe").val(),
                seccion:$("#seccion").val(),
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
