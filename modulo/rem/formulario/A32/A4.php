
<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>0 A 4</option>
            <option>5 A 9</option>
            <option>10 A 14</option>
            <option>15 A 19</option>
            <option>20 A 24</option>
            <option>25 A 20</option>
            <option>30 A 34</option>
            <option>35 A 39</option>
            <option>40 A 44</option>
            <option>45 A 49</option>
            <option>50 A 54</option>
            <option>55 A 59</option>
            <option>60 A 64</option>
            <option>65 A 69</option>
            <option>70 A 74</option>
            <option>75 A 79</option>
            <option>80 Y MAS</option>
        </select>
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


