<?php
?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">REALIZADO POR UN PROFESIONAL</option>
        <option value="B">SEGUN RESULTADO DEL ESTADO NUTRICIONAL</option>
        <option value="C">SEGUN ESTADO DE SALUD</option>
        <option value="D">SEGUN ESTADO DE SALUD (LABORATORIO)</option>
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
            $.post('formulario/A02/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
