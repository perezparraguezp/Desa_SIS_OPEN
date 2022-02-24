<div class="row">
    <div class="col l4">PROFESIONAL</div>
    <div class="col l8">
        <select name="tipo_profeisonal" id="tipo_profeisonal">
            <option>ANTITABACO</option>
            <option>AUTOCUIDADO SEGÚN PATOLOGÍA</option>
            <option>USO DE TERAPIA INHALATORIA </option>
            <option>EDUCACION INTEGRAL EN SALUD RESPIRATORIA  </option>
            <option>ESTILO DE VIDA SALUDABLES </option>
            <option>OTRAS </option>
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
            <option>5 A 9 </option>
            <option>10 A 14 </option>
            <option>15 A 19</option>
            <option>20 A 24</option>
            <option>25 A 39</option>
            <option>40 A 44</option>
            <option>45 A 49</option>
            <option>50 y 54</option>
            <option>55 y 59</option>
            <option>60 y 64</option>
            <option>65 y 69</option>
            <option>70 y 74</option>
            <option>75 y 79</option>
            <option>80 y MAS</option>
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

