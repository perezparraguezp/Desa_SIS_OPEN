
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">SECCIÓN A</option>
        <option value="B">SECCIÓN B</option>
        <option value="C">SECCIÓN C</option>
        <option value="D">SECCIÓN D</option>
        <option value="E">SECCIÓN E</option>
        <option value="E1">SECCIÓN E1</option>
        <option value="F">SECCIÓN F</option>
        <option value="G">SECCIÓN G</option>
        <option value="H">SECCIÓN H</option>
        <option value="I">SECCIÓN I</option>
        <option value="J">SECCIÓN J</option>
        <option value="K">SECCIÓN K</option>
        <option value="L">SECCIÓN L</option>
        <option value="M">SECCIÓN M</option>
        <option value="N">SECCIÓN N</option>
        <option value="O">SECCIÓN O</option>
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
            $.post('formulario_touch/A04_xls/'+seccion+'.php',{
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
