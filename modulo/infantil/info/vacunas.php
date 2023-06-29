<?php
include "../../../php/config.php";
include '../../../php/objetos/persona.php';
$rut = str_replace('.','',$_POST['rut']);
$paciente = new persona($rut);

$vacunas = array('2 MESES','4 MESES','6 MESES','12 MESES ','18 MESES','3 AÑOS','1ro BASICO');

for ($v = 0 ; $v < count($vacunas) ; $v++){

    if($vacunas[$v] <= $paciente->total_meses){
        ?>
        <div class="row">
            <div class="col l8">VACUNA <?php echo $vacunas[$v]; ?></div>
            <?php
            if($vacunas[$v]=='2 MESES'){
                $valor = $paciente->vacuna2M();
            }else{
                if($vacunas[$v]=='4 MESES'){
                    $valor = $paciente->vacuna4M();
                }else{
                    if($vacunas[$v]=='6 MESES'){
                        $valor = $paciente->vacuna6M();
                    }else{
                        if($vacunas[$v]=='12 MESES'){
                            $valor = $paciente->vacuna12M();
                        }else{
                            if($vacunas[$v]=='18 MESES'){
                                $valor = $paciente->vacuna18M();
                            }else{
                                if($vacunas[$v]=='3 AÑOS'){
                                    $valor = $paciente->vacuna3Anios();
                                }else{
                                    if($vacunas[$v]=='1ro BASICO'){
                                        $valor = $paciente->vacuna5Anios();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
            <div class="col l4 center center-align" style="font-weight: bold"><?php echo $valor; ?></div>
        </div>
        <?php
    }
}

?>

