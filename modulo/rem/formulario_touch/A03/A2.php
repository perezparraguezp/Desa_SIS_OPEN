<input type="hidden" name="test_psicomotor" value="SI" />
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
            <option>NORMAL</option>
            <option>NORMAL CON REZAGO</option>
            <option>RIESGO</option>
            <option>RETRASO</option>
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

<div class="row">
    <div class="col l4">REEVALUACIÓN</div>
    <div class="col l8">
        <select name="reevaluacion" id="reevaluacion">
            <option>NO APLICA</option>
            <option>NORMAL (desde normal con rezago)</option>
            <option>NORMAL (desde riesgo)</option>
            <option>NORMAL (desde retraso)</option>
            <option>NORMAL CON REZAGO (desde riesgo)</option>
            <option>NORMAL CON REZAGO (desde retraso)</option>
            <option>NORMAL CON REZAGO (desde normal con rezago)</option>
            <option>RIESGO (desde retraso)</option>
            <option>RIESGO (desde riesgo)</option>
            <option>RIESGO (desde normal con rezago)</option>
            <option>RETRASO (desde retraso)</option>
            <option>RETRASO (desde riesgo)</option>
            <option>RETRASO (desde normal con rezago)</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#reevaluacion').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>

<div class="row">
    <div class="col l4">DERIVADOS A ESPECIALIDAD</div>
    <div class="col l8">
        <select name="derivados" id="derivados">
            <option>NO APLICA</option>
            <option>RIESGO</option>
            <option>RETRASO</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#derivados').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>

<div class="row">
    <div class="col l4">TRASLADO DE ESTABLECIMIENTO</div>
    <div class="col l8">
        <select name="traslado" id="traslado">
            <option>NO APLICA</option>
            <option>NORMAL CON REZAGO</option>
            <option>RIESGO</option>
            <option>RETRASO</option>
        </select>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#traslado').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>
<div class="row">
    <div class="col l4">DERIVADO A MODALIDAD DE ESTIMULACION</div>
    <div class="col l8">
        <select name="estimulacion" id="estimulacion">
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
        $('#estimulacion').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>