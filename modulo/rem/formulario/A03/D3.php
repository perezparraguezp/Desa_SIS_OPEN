<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>0 A 4</option>
            <option>5 A 9</option>
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
            <option>60 A 64</option>
            <option>65 A 69</option>
            <option>70 A 74</option>
            <option>75 A 79</option>
            <option>80 Y MAS</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">EVALUACION AL INGRESO</div>
    <div class="col l8">
        <select name="eval_ingreso" id="eval_ingreso">
            <option>NO APLICA</option>
            <option>BAJO</option>
            <option>MEDIO</option>
            <option>ALTO</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">EVALUACION AL EGRESO</div>
    <div class="col l8">
        <select name="eval_egreso" id="eval_egreso">
            <option>NO APLICA</option>
            <option>BAJO</option>
            <option>MEDIO</option>
            <option>ALTO</option>
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
        $('#eval_ingreso').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#eval_egreso').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>