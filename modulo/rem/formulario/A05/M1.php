<div class="row">
    <div class="col l4">CONDICIÓN</div>
    <div class="col l8">
        <select name="tipo_condicion" id="tipo_condicion">
            <option>AUTOVALENTE SIN RIESGO</option>
            <option>AUTOVALENTE CON RIESGO</option>
            <option>RIESGO DE DEPENDENCIA</option>
            <option>COMPLETA CICLO</option>
            <option>ABANDONO</option>
            <option>TRASLADO</option>
            <option>FALLECIMIENTO</option>
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
            <option>60 A 64</option>
            <option>65 A 69</option>
            <option>70 A 74</option>
            <option>75 A 79</option>
            <option>80 y Más</option>
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