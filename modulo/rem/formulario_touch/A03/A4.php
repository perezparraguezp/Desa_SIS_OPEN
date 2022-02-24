<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>1 MES</option>
            <option>2 MESES</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">APLICACIÓN DE PROTOCOLO NEUROSENSORIAL</div>
    <div class="col l8">
        <select name="protocolo_neurosensorial" id="protocolo_neurosensorial">
            <option>NORMAL</option>
            <option>ANORMAL</option>
            <option>MUY ANORMAL</option>
        </select>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#protocolo_neurosensorial').jqxDropDownList({
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