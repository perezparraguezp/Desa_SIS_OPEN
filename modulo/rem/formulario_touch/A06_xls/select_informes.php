
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">SECCIÓN A1</option>
        <option value="A2">SECCIÓN A2</option>
        <option value="B1">SECCIÓN B1</option>
        <option value="B2">SECCIÓN B2</option>
        <option value="B4">SECCIÓN B4</option>
        <option value="C1">SECCIÓN C1</option>
        <option value="C2">SECCIÓN C2</option>
        <option value="D">SECCIÓN D</option>
        <option value="E">SECCIÓN E</option>
        <option value="F">SECCIÓN F</option>
        <option value="G">SECCIÓN G</option>
        <option value="H">SECCIÓN H</option>
        <option value="I">SECCIÓN I</option>

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
            $.post('formulario_touch/A06_xls/'+seccion+'.php',{
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
