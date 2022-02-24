<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">INGRESOS AGUDOS SEGÚN DIAGNOSTICO</option>
        <option value="B">INGRESO CRÓNICO SEGÚN DIAGNÓSTICO (SOLO MÉDICO)</option>
        <option value="C">EGRESOS</option>
        <option value="D">CONSULTAS DE MORBILIDAD POR ENFERMEDADES RESPIRATORIAS EN SALAS IRA, ERA Y MIXTA</option>
        <option value="E">CONTROLES REALIZADOS (CRONICOS)</option>
        <option value="F">SEGUIMIENTO DE ATENCIONES REALIZADAS EN AGUDOS</option>
        <option value="G">INASISTENTES A CONTROL DE CRÓNICOS</option>
        <option value="I">PROCEDIMIENTOS REALIZADOS</option>
        <option value="J">DERIVACIÓN DE PACIENTES SEGÚN DESTINO</option>
        <option value="K">RECEPCIÓN DE PACIENTES SEGÚN ORIGEN</option>
        <option value="M">EDUCACIÓN EN SALAS</option>
        <option value="N">VISITAS DOMICILIARIAS Y SEGUIMIENTO REALIZADOS POR EQUIPO IRA-ERA </option>
        <option value="P">APLICACIÓN DE ENCUESTA CALIDAD DE VIDA</option>

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
            $.post('formulario/A23/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
