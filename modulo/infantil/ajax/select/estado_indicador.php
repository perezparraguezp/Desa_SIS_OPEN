<label>ESTADO</label>
<select name="estado"
        id="estado">
    <?php
    include "../../../../php/config.php";
    $indicador = $_POST['indicador'];
    $table_sql = $_POST['table_sql'];
    $tiene_estado = true;
    switch ($table_sql){
        case 'DNI1':{

            $sql3 = "select * from antropometria 
                                        where DNI!='' 
                                        group by DNI";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['DNI']; ?></option>
                <?php
            }

            break;
        }
        case 'DNI2':{

            $sql3 = "select * from antropometria 
                                        where DNI!='' 
                                        group by DNI";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['DNI']; ?></option>
                <?php
            }

            break;
        }
        case 'DNI3':{

            $sql3 = "select * from antropometria 
                                        where DNI!='' 
                                        group by DNI";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['DNI']; ?></option>
                <?php
            }

            break;
        }
        case 'PCINT':{

            $sql3 = "select * from antropometria 
                                        where PCINT!='' 
                                        group by PCINT";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['PCINT']; ?></option>
                <?php
            }


            break;
        }
        case 'LME':{

            $sql3 = "select * from antropometria 
                                        where LME!='' 
                                        group by LME";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['LME']; ?></option>
                <?php
            }

            break;
        }
        case 'SCORE_IRA':{

            $sql3 = "select * from antropometria 
                                        where SCORE_IRA!='' 
                                        group by SCORE_IRA";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['SCORE_IRA']; ?></option>
                <?php
            }

            break;
        }
        case 'presion_arterial':{

            $sql3 = "select * from antropometria 
                                        where presion_arterial!='' 
                                        group by presion_arterial";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['presion_arterial']; ?></option>
                <?php
            }

            break;
        }
        case 'perimetro_craneal':{

            $sql3 = "select * from antropometria 
                                        where perimetro_craneal!='' 
                                        group by perimetro_craneal";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['perimetro_craneal']; ?></option>
                <?php
            }

            break;
        }
        case 'evaluacion_auditiva':{

            $sql3 = "select * from antropometria 
                                        where evaluacion_auditiva!='' 
                                        group by evaluacion_auditiva";
            echo $sql3;
            $res3 = mysql_query($sql3);
            print_r($sql3);
            print_r($res3);
            while ($row3 = mysql_fetch_array($res3)) {
                ?>
                <option><?php echo $row3['evaluacion_auditiva']; ?></option>
                <?php
            }

            break;
        }

    }
    ?>
</select>
