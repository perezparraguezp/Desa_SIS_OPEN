
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">SECCIÓN A</option>
        <option value="A2">SECCIÓN A2</option>
        <option value="A3">SECCIÓN A3</option>
        <option value="A4">SECCIÓN A4</option>
        <option value="A5">SECCIÓN A5</option>
        <option value="A6">SECCIÓN A6</option>
        <option value="A7">SECCIÓN A7</option>
        <option value="A8">SECCIÓN A8</option>
        <option value="A9">SECCIÓN A9</option>
        <option value="A10">SECCIÓN A10</option>
        <option value="A11">SECCIÓN A11</option>
        <option value="A12">SECCIÓN A12</option>
        <option value="C">SECCIÓN C</option>
        <option value="C2">SECCIÓN C2</option>
        <option value="C3">SECCIÓN C3</option>
        <option value="D">SECCIÓN D</option>
        <option value="D2">SECCIÓN D2</option>



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
            $.post('formulario_touch/A28_xls/'+seccion+'.php',{
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
