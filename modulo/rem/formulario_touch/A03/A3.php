<input type="hidden" name="test_vulnerabilidad" value="SI" />
<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>MENOR 7 MESES</option>
            <option>7 A 11 MESES</option>
            <option>12 A 17 MESES</option>
            <option>18 A 23 MESES</option>
            <option>24 A 47 MESES</option>
            <option>48 A 59 MESES</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">PRIMERA EVALUACION</div>
    <div class="col l8">
        <select name="primera_evaluacion" id="primera_evaluacion">
            <option>NO APLICA</option>
            <option>NORMAL CON REZAGO</option>
            <option>RIESGO</option>
            <option>RETRASO</option>
            <option>OTRA VULNERABILIDAD</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#primera_evaluacion').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>
