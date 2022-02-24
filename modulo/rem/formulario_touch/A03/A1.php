<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>MENOR 1 MES</option>
            <option>1 MES</option>
            <option>2 MESES</option>
            <option>3 MESES</option>
            <option>4 MESES</option>
            <option>5 MESES</option>
            <option>6 MESES</option>
            <option>7 A 11 MESES</option>
            <option>12 A 17 MESES</option>
            <option>18 A 24 MESES</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">PAUTA BREVE</div>
    <div class="col l8">
        <select name="pauta_breve" id="pauta_breve">
            <option>NORMAL</option>
            <option>ALTERADA</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#pauta_breve').jqxDropDownList({
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