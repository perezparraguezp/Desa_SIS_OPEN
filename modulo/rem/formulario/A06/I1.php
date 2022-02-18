<div class="row">
    <div class="col l4">PROFESIONAL</div>
    <div class="col l8">
        <select name="tipo_profeisonal" id="tipo_profeisonal">
            <option>MÉDICO</option>
            <option>PSICÓLOGO/A</option>
            <option>ENFERMERA /O</option>
            <option>MATRONA /ÓN</option>
            <option>ASISTENTE SOCIAL</option>
            <option>OTROS PROFESIONALES</option>
            <option>TERAPEUTA OCUPACIONAL</option>
            <option>TÉCNICO PARAMÉDICO y EN SALUD MENTAL</option>
            <option>GESTOR COMUNITARIO</option>
            <option>TÉCNICO REHABILITACIÓN ALCOHOL Y DROGAS</option>
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
            <option>0 A 4 </option>
            <option>5 A 9 </option>
            <option>10 A 14 </option>
            <option>15 A 19</option>
            <option>20 A 24</option>
            <option>25 A 29</option>
            <option>30 A 34</option>
            <option>35 A 39</option>
            <option>40 A 44</option>
            <option>45 A 49</option>
            <option>50 A 54</option>
            <option>55 y 59</option>
            <option>60 y 64</option>
            <option>65 y 69</option>
            <option>70 y 74</option>
            <option>75 y 79</option>
            <option>80 y MAS</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">BENEFICIARIO</div>
            <div class="settings-setter">
                <div id="beneficiario"></div>
                <input type="hidden" name="input_beneficiario" id="input_beneficiario" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#beneficiario').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#beneficiario').on('change',function(){
                    if($('#beneficiario').val()===true){
                        $("#input_beneficiario").val('SI');
                    }else{
                        $("#input_beneficiario").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>
<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">Niños, Niñas, Adolescentes y Jóvenes Población  SENAME</div>
            <div class="settings-setter">
                <div id="sename"></div>
                <input type="hidden" name="input_sename" id="input_sename" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#sename').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#sename').on('change',function(){
                    if($('#sename').val()===true){
                        $("#input_sename").val('SI');
                    }else{
                        $("#input_sename").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>

<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">Acciones no presenciales o remotas</div>
            <div class="settings-setter">
                <div id="acciones"></div>
                <input type="hidden" name="input_acciones" id="input_acciones" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#acciones').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#acciones').on('change',function(){
                    if($('#acciones').val()===true){
                        $("#input_acciones").val('SI');
                    }else{
                        $("#input_acciones").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>
<div class="row">
   <div class="col l12">
     <div class="settings-section">
        <div class="settings-label">Atenciones a funcionarios de la salud</div>
        <div class="settings-setter">
            <div id="atenciones"></div>
            <input type="hidden" name="input_atenciones" id="input_atenciones" value="NO" />
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $('#atenciones').jqxSwitchButton({
                height: 27, width: 81,
                theme: 'eh-open',
                onLabel:'SI',
                offLabel:'NO',
            });
            $('#atenciones').on('change',function(){
                if($('#atenciones').val()===true){
                    $("#input_atenciones").val('SI');
                }else{
                    $("#input_atenciones").val('NO');
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
