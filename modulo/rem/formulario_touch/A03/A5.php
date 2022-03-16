<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>DEL 1 MES</option>
            <option>DEL 3 MES</option>
            <option>DEL 6 MES</option>
            <option>DEL 12 MES</option>
            <option>DEL 24 MES</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">TIPO DE ALIMENTACIÓN</div>
    <div class="col l8">
        <select name="tipo_alimentacion" id="tipo_alimentacion">
            <option>LME</option>
            <option>LME/FL</option>
            <option>FL</option>
            <option>LM + SOLIDOS</option>
            <option>LM/FL + SOLIDOS</option>
            <option>FL + SOLIDOS</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#tipo_alimentacion').jqxDropDownList({
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