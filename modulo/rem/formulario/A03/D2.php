<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>6 A 11 MESES</option>
            <option>12 A 23 MESES</option>
            <option>2 A 4</option>
            <option>5 A 9</option>
            <option>10 A 14</option>
            <option>15 A 19</option>
            <option>20 A 24</option>
            <option>25 A 44</option>
            <option>45 A 64</option>
            <option>65 A 69</option>
            <option>70 A 79</option>
            <option>80 Y MAS</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">ORIGEN FÍSICO</div>
    <div class="col l8">
        <select name="origen_fisico" id="origen_fisico">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">ORIGEN SENSORIAL VISUAL</div>
    <div class="col l8">
        <select name="origen_sensorial_visual" id="origen_sensorial_visual">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">ORIGEN SENSORIAL AUDITIVO</div>
    <div class="col l8">
        <select name="origen_sensorial_auditivo" id="origen_sensorial_auditivo">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">ORIGEN MENTAL PSÍQUICO</div>
    <div class="col l8">
        <select name="origen_mental_psiquico" id="origen_mental_psiquico">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">ORIGEN MENTAL INTELECTUAL</div>
    <div class="col l8">
        <select name="origen_mental_intelectual" id="origen_mental_intelectual">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">ORIGEN MÚLTIPLE</div>
    <div class="col l8">
        <select name="origen_multiple" id="origen_multiple">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">EVALUACIÓN INGRESO</div>
    <div class="col l8">
        <select name="evaluacion_ingreso" id="evaluacion_ingreso">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">EVALUACIÓN EGRESO</div>
    <div class="col l8">
        <select name="evaluacion_egreso" id="evaluacion_egreso">
            <option>NO APLICA</option>
            <option>SIN DISCAPACIDAD</option>
            <option>DISCAPACIDAD LEVE</option>
            <option>DISCAPACIDAD MODERADA</option>
            <option>DISCAPACIDAD SEVERA</option>
            <option>DISCAPACIDAD PROFUNDA</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#origen_fisico').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#origen_sensorial_visual').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#origen_sensorial_auditivo').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#origen_mental_psiquico').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#origen_mental_intelectual').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#origen_multiple').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#evaluacion_ingreso').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#evaluacion_egreso').jqxDropDownList({
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