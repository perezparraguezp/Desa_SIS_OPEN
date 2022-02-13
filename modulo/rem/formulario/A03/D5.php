<div class="row">
    <div class="col l4">EDAD</div>
    <div class="col l8">
        <select name="edad" id="edad">
            <option>65 A 69</option>
            <option>70 A 74</option>
            <option>75 A 79</option>
            <option>80 Y 84</option>
            <option>85 Y 89</option>
            <option>90 Y MAS</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l4">INDICE BARTHEL</div>
    <div class="col l8">
        <select name="barthel" id="barthel">
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
        $('#barthel').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
    })
</script>