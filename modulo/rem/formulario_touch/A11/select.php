<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">TRATAMIENTO DE SIFILIS EN GESTANTES </option>
        <option value="C">ABORTOS Y DEFUNCIONES FETALES ATRIBUIDAS A SIFILIS SEGÚN EDAD GESTACIONAL </option>
        <option value="F">RECIEN NACIDOS EXPUESTOS AL VIH QUE RECIBE PROTOCOLO DE TRANSMISION VERTICAL</option>
        <option value="G">RECIEN NACIDOS EXPUESTOS AL VIH QUE RECIBEN LECHE MATERNIZADA AL ALTA </option>
        <option value="H">GESTANTES ESTUDIADAS PARA ESTREPTOCOCCUS GRUPO B (EGB) </option>
        <option value="I">GESTANTES EVALUADAS PARA HEPATITIS B </option>
        <option value="J">PROFILAXIS DE TRANSMISIÓN VERTICAL APLICADA AL RECIEN NACIDO, HIJO DE MADRE HEPATITIS B POSITIVA </option>
        <option value="K">SEGUIMIENTO DE NIÑOS Y NIÑAS AL AÑO DE VIDA </option>

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
            $.post('formulario/A11/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
