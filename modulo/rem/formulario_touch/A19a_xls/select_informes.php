
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">SECCIÓN A</option>
        <option value="A2">SECCIÓN A2</option>
        <option value="A3">SECCIÓN A3</option>
        <option value="A4">SECCIÓN A4</option>
        <option value="B">SECCIÓN B</option>
        <option value="B2">SECCIÓN B2</option>
        <option value="B3">SECCIÓN B3</option>
        <option value="B4">SECCIÓN B4</option>

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
            $.post('formulario_touch/A19a_xls/'+seccion+'.php',{
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
