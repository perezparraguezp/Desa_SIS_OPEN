<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">INGRESOS DE GESTANTES A PROGRAMA PRENATAL </option>
        <option value="C">INGRESOS A PROGRAMA DE REGULACIÓN DE FERTILIDAD Y SALUD SEXUAL </option>
        <option value="C01">EGRESOS DE PROGRAMA DE REGULACIÓN DE FERTILIDAD Y SALUD SEXUAL </option>
        <option value="F">INGRESOS Y EGRESOS A SALA DE ESTIMULACIÓN SERVICIO ITINERANTE Y ATENCIÓN DOMICILIARIA </option>
        <option value="F01">REINGRESOS Y EGRESOS POR SEGUNDA VEZ A MODALIDAD DE ESTIMULACIÓN EN EL CENTRO DE SALUD </option>
        <option value="G">INGRESOS DE NIÑOS Y NIÑAS CON NECESIDADES ESPECIALES DE BAJA COMPLEJIDAD A CONTROL DE SALUD INFANTIL EN APS </option>
        <option value="H">INGRESOS AL PSCV </option>
        <option value="I">EGRESOS  DEL PSCV </option>
        <option value="J">INGRESOS Y EGRESOS AL PROGRAMA DE PACIENTES CON DEPENDENCIA LEVE, MODERADA Y SEVERA </option>
        <option value="K">INGRESOS AL PROGRAMA DEL ADULTO MAYOR SEGÚN CONDICIÓN DE FUNCIONALIDAD Y DEPENDENCIA </option>
        <option value="L">EGRESOS DEL PROGRAMA DEL ADULTO MAYOR SEGÚN CONDICIÓN DE FUNCIONALIDAD Y DEPENDENCIA </option>
        <option value="M">INGRESOS Y EGRESOS DEL  PROGRAMA MÁS ADULTOS MAYORES AUTOVALENTES </option>
        /* FALTA N y O */
        <option value="P">INGRESOS Y EGRESOS AL COMPONENTE ALCOHOL Y DROGA EN APS/ESPECIALIDAD </option>
        <option value="Q">PROGRAMA DE REHABILITACIÓN (PERSONAS CON TRASTORNOS PSIQUIÁTRICOS) </option>
        <option value="R">INGRESOS Y EGRESOS A PROGRAMA INFECCIÓN POR TRANSMISIÓN SEXUAL (Uso de establecimientos que realizan atención de ITS) </option>
        <option value="T">INGRESOS Y EGRESOS POR COMERCIO SEXUAL (Uso exclusivo de Unidades Control Comercio Sexual) </option>
        <option value="U">INGRESOS Y EGRESOS PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN ATENCIÓN PRIMARIA </option>
        <option value="V">INGRESOS  INTEGRALES DE PERSONAS CON CONDICIONES CRÓNICAS EN ATENCIÓN PRIMARIA </option>
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
            $.post('formulario/A05/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
