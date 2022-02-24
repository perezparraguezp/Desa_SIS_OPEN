<div class="row">

    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">ESPACIO AMIGABLE</div>
            <div class="settings-setter">
                <div id="espacio"></div>
                <input type="hidden" name="input_espacio" id="input_espacio" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#espacio').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#espacio').on('change',function(){
                    if($('#espacio').val()===true){
                        $("#input_espacio").val('SI');
                    }else{
                        $("#input_espacio").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>
<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">Ingreso por Cambio de Método Anticonceptivo</div>
            <div class="settings-setter">
                <div id="anticonceptivo"></div>
                <input type="hidden" name="input_anticonceptivo" id="input_anticonceptivo" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#anticonceptivo').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#anticonceptivo').on('change',function(){
                    if($('#anticonceptivo').val()===true){
                        $("#input_anticonceptivo").val('SI');
                    }else{
                        $("#input_anticonceptivo").val('NO');
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