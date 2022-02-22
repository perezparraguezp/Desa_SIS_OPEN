<div class="row">
    <div class="col l4">PROFESIONAL</div>
    <div class="col l8">
        <select name="tipo_profeisonal" id="tipo_profeisonal">
            <option>Leve</option>
            <option>Moderado</option>
            <option>Severo </option>
        </select>
        <script type="text/javascript">
            $(function(){
                $('#tipo_profeisonal').jqxDropDownList({
                    width: '100%',
                    theme: 'eh-open',
                    height: '25px'
                });

            });
        </script>
    </div>
</div>
<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>MENOR 1 AÑO </option>
            <option>1 A 4</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">REINGRESO</div>
            <div class="settings-setter">
                <div id="reingreso"></div>
                <input type="hidden" name="input_reingreso" id="input_reingreso" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#reingreso').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#reingreso').on('change',function(){
                    if($('#reingreso').val()===true){
                        $("#input_reingreso").val('SI');
                    }else{
                        $("#input_reingreso").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>

<script type="text/javascript">
    $(function(){

        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>
