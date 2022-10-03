<label>ATRIBUTO</label>
<select name="atributo"
        id="atributo">
    <option selected disabled value="">SELECCIONAR ATRIBUTO</option>
    <?php
    $indicador = $_POST['indicador'];//parametro de la table
    $table_sql = $_POST['table_sql'];//tabla
    $tiene_estado = true;
    switch ($indicador){
        case 'PATOLOGIAS':{
            ?>
            <option value="patologia_dm">DIABETES</option>
            <option value="patologia_hta">HIPERTENSION ARTERIAL</option>
            <option value="patologia_vih">VIH</option>
            <?php
            break;
        }
        case 'ESTADO DEL PACIENTE':{
            ?>

            <option value="regulacion_fertilidad">REGULACION DE FERTILIDAD</option>
            <option value="gestacion">GESTACION</option>
            <option value="climaterio">CLIMATERIO</option>
            <?php
            break;
        }
        case 'ESTADO NUTRICIONAL':{
            ?>
            <option value="BP">BAJO PESO</option>
            <option value="N">NORMAL</option>
            <option value="SP">SOBREPESO</option>
            <option value="OB">OBESIDAD</option>
            <?php
            break;
        }
        case 'SOSPECHA MALTRATO':{
            ?>
            <option>SI</option>
            <option>NO</option>
            <?php
            break;
        }
        case '+ ADULTO MAYOR':{
            ?>
            <option >AUTOVALENTE SIN RIESGO</option>
            <option >AUTOVALENTE CON RIESGO</option>
            <option >RIESGO DEPENDENCIA</option>
            <?php
            break;
        }
        case 'RIESGO CAIDA : TIMED UP AND GO':{
            ?>
            <option>NORMAL</option>
            <option>LEVE</option>
            <option>ALTO</option>
            <?php
            break;
        }

        case 'RIESGO CAIDA : ESTACION UNIPODAL':{
            ?>
            <option>NORMAL</option>
            <option>ALTERADO</option>
            <?php
            break;
        }
        case 'REGULACION DE FERTILIDAD':{
            ?>
            <option>ORAL COMBINADO</option>
            <option>ORAL PROGESTÁGENO</option>
            <option>INYECTABLE COMBINADO</option>
            <option>INYECTABLE PROGESTÁGENO</option>
            <option>IMPLANTE ETONOGESTREL (3 AÑOS)</option>
            <option>IMPLANTE LEVONORGESTREL (5 AÑOS)</option>
            <option>SOLO PRESERVATIVO MAC</option>
            <option>D.I.U. T DE COBRE (10 AÑOS)</option>
            <option>D.I.U. CON LEVORGESTREL (6 AÑOS)</option>
            <option>ESTERILIZACION QUIRURGICA</option>
            <?php
            break;
        }

    }
    ?>
</select>
<script type="text/javascript">
    $(function(){
        $('#atributo').jqxDropDownList({
            width: '98%',
            theme: 'eh-open',
            height: '25px'
        });
    });
</script>