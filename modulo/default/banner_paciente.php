
<?php
include "../../php/config.php";
include '../../php/objetos/persona.php';
include '../../php/objetos/profesional.php';
$rut = str_replace('.','',$_POST['rut']);
$fecha_registro = $_POST['fecha_registro'];

if($fecha_registro==''){
    $fecha_registro = date('Y-m-d');
}

$paciente = new persona($rut);
$paciente->definirEdadFecha($fecha_registro);
list($establecimiento,$sector_interno,$sector_comunal) = explode(":",$paciente->getEstablecimiento());
?>
<style type="text/css">
    #banner_informativo{
        font-size: 1.4em;
    }
</style>
<div class="row" id="banner_informativo">
    <div class="col l1 center">
        <?php $imagen = $paciente->sexo=='F'?'mujer.png':'hombre.png'; ?>
        <img src="../../images/<?php echo $imagen; ?>" width="48" />
    </div>
    <div class="col l4">
        <div class="row">
            <strong><?php echo $paciente->nombre; ?></strong>
        </div>
        <div class="row">
            <?php echo $paciente->edad ?>
        </div>
        <div class="row">
            FN <?php echo fechaNormal($paciente->fecha_nacimiento); ?>
        </div>
        <div class="row">
            <?php echo $paciente->rut ?>
        </div>
        <?php
        if(trim($paciente->nanea)!='NO' && $paciente->nanea!=''){
            ?>
            <div class="row">
                NANEA <strong><?php echo $paciente->nanea ?></strong>
            </div>
            <?php
        }
        ?>
        <?php
        if( $paciente->semanas_gestacion!='' && $paciente->total_meses<=(12*2)){
            ?>
            <div class="row">
                SEMANAS DE GESTACIÓN <strong><?php echo $paciente->semanas_gestacion ?></strong>
            </div>
            <?php
        }
        ?>

    </div>
    <div class="col l1">
        <img src="../../images/centro_medico.png" width="48" />
    </div>
    <div class="col l4">
        <div class="row">
            <strong><?php echo $establecimiento; ?></strong>
        </div>
        <div class="row">
            <?php echo 'Sector: '.$sector_interno.' | '.$sector_comunal; ?>
        </div>
        <div class="row">
            <?php echo 'Ultimo Control: '.fechaNormal($paciente->getFechaUltimoControl()    ); ?>
        </div>
    </div>
</div>