<?php
$vif ='';
?>

<div class="container card-panel">
    <div class="row">
        <div class="col l12">
            <input type="checkbox" id="vif"
                   onchange="updateParametroFamilia('vif')"
                <?php echo $vif=='SI'?'checked="checked"':'' ?>
                   name="vif"  />
            <label class="white-text" for="vif">VIF</label>
        </div>
    </div>
</div>
