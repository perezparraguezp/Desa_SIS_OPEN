<div class="row">
    <div class="col l4">PATOLOGÍA</div>
    <div class="col l8">
        <select name="tipo_condicion" id="tipo_condicion">
            <option>SÍFILIS</option>
            <option>GONORREA</option>
            <option>CONDILOMA</option>
            <option>HERPES</option>
            <option>CHLAMYDIAS</option>
            <option>URETRITIS NO GONOCÓCICA</option>
            <option>LINFOGRANULOMA</option>
            <option>CHANCROIDE</option>
            <option>OTRAS ITS</option>
        </select>
        <script type="text/javascript">
            $(function(){
                $('#tipo_condicion').jqxDropDownList({
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
            <option>10 A 14</option>
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
<script type="text/javascript">
    $(function(){

        $('#edad').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>
<div class="row">
    <div class="col l4">EGRESOS</div>
    <div class="col l8">
        <select name="tipo_egreso" id="tipo_egreso">
            <option>POR ALTA</option>
            <option>POR ABANDONO</option>
        </select>
        <script type="text/javascript">
            $(function(){
                $('#tipo_egreso').jqxDropDownList({
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
            <div class="settings-label">TRANS</div>
            <div class="settings-setter">
                <div id="trans"></div>
                <input type="hidden" name="input_trans" id="input_trans" value="NO" />
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#trans').jqxSwitchButton({
                    height: 27, width: 81,
                    theme: 'eh-open',
                    onLabel:'SI',
                    offLabel:'NO',
                });
                $('#trans').on('change',function(){
                    if($('#trans').val()===true){
                        $("#input_trans").val('SI');
                    }else{
                        $("#input_trans").val('NO');
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
