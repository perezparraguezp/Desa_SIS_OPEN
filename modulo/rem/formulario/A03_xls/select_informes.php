<?php
?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A1">SECCIÓN A.1</option>
        <option value="A2">SECCIÓN A.2</option>
        <option value="A3">SECCIÓN A.3</option>
        <option value="A4">SECCIÓN A.4</option>
        <option value="A5">SECCIÓN A.5</option>
        <option value="B1">SECCIÓN B.1</option>
        <option value="B2">SECCIÓN B.2</option>
        <option value="B3">SECCIÓN B.3</option>
        <option value="C">SECCIÓN C</option>
        <option value="D1">SECCIÓN D.1</option>
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
            $.post('formulario/A03_xls/'+seccion+'.php',{
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
