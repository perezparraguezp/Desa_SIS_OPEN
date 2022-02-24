<div class="row">
    <div class="col l4">PROFESIONAL</div>
    <div class="col l8">
        <select name="tipo_profeisonal" id="tipo_profeisonal">
            <option>CONSULTA NUEVA </option>
            <option>CONTROL </option>
            <option>INGRESOS A TRATAMIENTO </option>
            <option>ALTAS DE TRATAMIENTO </option>
            <option>CONTROL DE ESPECIALIDAD POST ALTA </option>
            <option>ALTAS ADMINISTRATIVAS </option>
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
            <option>MENOR 1 AÑO A 1 AÑO</option>
            <option>2 </option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8 A 9</option>
            <option>10 A 14 </option>
            <option>15 A 19</option>
            <option>20 A 24</option>
            <option>25 A 34</option>
            <option>35 A 44</option>
            <option>45 A 59</option>
            <option>60 y 64</option>
            <option>65 y 74</option>
            <option>75 y MAS</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">CONSULTAS PERTINENTES</div>
    <div class="col l8">
        <select name="tipo_consulta" id="tipo_consulta">
            <option>Según Protocolo de Referencia </option>
            <option>Según condición clínica </option>
            <option>Sin Consultas </option> /*Es provisorio*/
        </select>
        <script type="text/javascript">
            $(function(){
                $('#tipo_consulta').jqxDropDownList({
                    width: '100%',
                    theme: 'eh-open',
                    height: '25px'
                });

            });
        </script>
    </div>
</div>

<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">INASISTENTE</div>
            <div class="settings-setter">
                <div id="inasistente"></div>
                <input type="hidden" name="input_inasistente" id="input_inasistente" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#inasistente').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#inasistente').on('change',function(){
                    if($('#inasistente').val()===true){
                        $("#input_inasistente").val('SI');
                    }else{
                        $("#input_inasistente").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>
<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">Compra de Servicio</div>
            <div class="settings-setter">
                <div id="compra"></div>
                <input type="hidden" name="input_compra" id="input_compra" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#compra').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#compra').on('change',function(){
                    if($('#compra').val()===true){
                        $("#input_compra").val('SI');
                    }else{
                        $("#input_compra").val('NO');
                    }
                });

            });
        </script>
    </div>
</div>
<div class="row">
    <div class="col l12">
        <div class="settings-section">
            <div class="settings-label">Usuario con Discapacidad</div>
            <div class="settings-setter">
                <div id="discapacidad"></div>
                <input type="hidden" name="input_discapacidad" id="input_discapacidad" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#discapacidad').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#discapacidad').on('change',function(){
                    if($('#discapacidad').val()===true){
                        $("#input_discapacidad").val('SI');
                    }else{
                        $("#input_discapacidad").val('NO');
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
<script type="text/javascript">
    $(function(){

        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>


