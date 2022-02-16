<?php
?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">CONSULTAS MÉDICAS </option>
        <option value="B">CONSULTAS DE PROFESIONALES NO MEDICOS </option>
        <option value="H">INTERVENCIÓN INDIVIDUAL DEL USUARIO EN PROGRAMA ELIGE VIDA SANA </option>
        <option value="L">CLASIFICACIÓN DE CONSULTA NUTRICIONAL POR GRUPO DE EDAD </option>
        <option value="M">CONSULTA DE LACTANCIA MATERNA EN MENORES CONTROLADOS </option>
        <option value="N">ATENCIONES AMBULATORIAS POR  EL PROGRAMA TUBERCULOSIS </option>
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
            $.post('formulario/A04/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
