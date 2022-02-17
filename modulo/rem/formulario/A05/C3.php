<div class="row">
    <div class="col l4">EDAD</div>
     <div class="col l8">
        <select name="edad" id="edad">
            <option>MENOR 15 </option>
            <option>15 A 19</option>
            <option>20 A 24</option>
            <option>25 A 29</option>
            <option>30 A 34</option>
            <option>35 A 39</option>
            <option>40 A 44</option>
            <option>45 A 49</option>
            <option>50 A 54</option>
            <option>55 A 59</option>
        </select>
     </div>
</div>
<div class="row">
    <div class="col l4">METODOS</div>
    <div class="col l8">
        <select name="metodo" id="metodo">
            <option>Oral Combinado</option>
            <option>Oral Progestágeno</option>
            <option>Inyectable Combinado</option>
            <option>Inyectable Progestágeno</option>
            <option>Implante Etonogestrel (3 años)</option>
            <option>Implante Levonorgestrel (5 años)</option>
        </select>
    </div>
</div>
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
        $('#metodo').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>