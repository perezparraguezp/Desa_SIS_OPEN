<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
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
    <div class="col l4">COMPONENTE</div>
    <div class="col l8">
        <select name="componente" id="componente">
            <option>Nº DE AUDIT (EMP/EMPAM)</option>
            <option>Nº DE AUDIT APLICADO</option>
            <option>Nº DE ASSIST (EMP/EMPAM)</option>
            <option>N° DE ASSIST APLICADO</option>
            <option>N° DE CRAFFT EN CONTROL DE SALUD INTEGRAL DEL ADOLESCENTE</option>
            <option>N° DE CRAFFT APLICADO	</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">RESULTADO</div>
    <div class="col l8">
        <select name="resultado_componente" id="resultado_componente">
            <option>BAJO RIESGO</option>
            <option>CONSUMO RIESGOSO / INTERMEDIO</option>
            <option>POSIBLE CONSUMO PERJUDICIAL O DEPENDENCIA</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#componente').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#resultado_componente').jqxDropDownList({
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