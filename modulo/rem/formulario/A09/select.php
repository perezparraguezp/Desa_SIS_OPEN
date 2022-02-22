<?php

?>
<div class="col l4">SECCION</div>
<div class="col l8">
    <select name="seccion" id="seccion">
        <option disabled="disabled" selected="selected">SELECCIONE UNA CATEGORIA A REALIZAR EVALUACIÓN</option>
        <option value="A">CONSULTAS Y CONTROLES ODONTOLÓGICOS REALIZADOS EN APS </option>
        <option value="B">ACTIVIDADES DE ODONTOLOGÍA GENERAL  REALIZADOS EN NIVEL PRIMARIO Y SECUNDARIO DE SALUD </option>
        <option value="G1">PROGRAMA SEMBRANDO SONRISAS </option>
        <option value="I">CONSULTAS, INGRESOS Y EGRESOS EN ESPECIALIDADES ODONTOLÓGICAS REALIZADOS EN NIVEL PRIMARIO Y SECUNDARIO DE SALUD</option>
        <option value="J">ACTIVIDADES EFECTUADAS POR TÉCNICO PARAMÉDICO DENTAL Y/O HIGIENISTAS DENTALES </option>

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
            $.post('formulario/A09/'+seccion+'.php',{
            },function(data){
                $("#div_seccion").html(data);
            });
        })
    })
</script>
