<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>60 A 64</option>
            <option>65 A 69</option>
            <option>70 A 74</option>
            <option>75 A 79</option>
            <option>80 Y MAS</option>
<!--            <option>85 Y 89</option>-->
<!--            <option>90 Y MAS</option>-->
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">TIMED UP AND GO</div>
    <div class="col l8">
        <select name="time_up_go" id="time_up_go">
            <option>NO APLICA</option>
            <option>MEJORA</option>
            <option>MANTIENE</option>
            <option>DISMINUYE</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">CUESTIONARIO</div>
    <div class="col l8">
        <select name="cuestionario" id="cuestionario">
            <option>NO APLICA</option>
            <option>MEJORA</option>
            <option>MANTIENE</option>
            <option>DISMINUYE</option>
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
        $('#time_up_go').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#cuestionario').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>