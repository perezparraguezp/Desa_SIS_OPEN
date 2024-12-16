<label>ATRIBUTO</label>
<select name="atributo"
        id="atributo">

    <?php
    include "../../../../php/config.php";
    $indicador = $_POST['indicador'];//parametro de la table
    $table_sql = $_POST['table_sql'];//tabla
    $tiene_estado = true;
    switch ($indicador){
        case 'FAMILIAS INSCRITAS':{
            ?>

            <option>TODAS</option>
            <?php
            break;
        }
        case 'FAMILIAS POR RIESGO':{
            ?>

            <option>BAJO</option>
            <option>MEDIO</option>
            <option>ALTO</option>
            <?php
            break;
        }
        case 'FAMILIAS POR RIESGO VIGENCIA':{
            ?>
            <option>VIGENTES</option>
            <option>NO VIGENTES</option>
            <option>SIN EVALUACION</option>
            <?php
            break;
        }
        case 'VDI VIGENCIA':{
            ?>
            <option>VDI VIGENTE</option>
            <option>VDI NO VIGENTE</option>
            <option>VDI SIN REGISTRO</option>
            <?php
            break;
        }
        case 'TRAZADORES':{
            $sql = "select * from trazadores_familia";
            $res = mysql_query($sql);
            while($row = mysql_fetch_array($res)){
                ?>
                <option value="<?php echo $row['id_trazador']; ?>"><?php echo $row['nombre_trazador']; ?></option>
                    <?php
            }
            ?>


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