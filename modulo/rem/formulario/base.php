<?php
?>
<div class="row">
    <div class="col l4">RUT</div>
    <div class="col l8"><input type="text" name="rut" id="rut" /></div>
</div>
<div class="row">
    <div class="col l12">NOMBRE COMPLETO</div>
    <div class="col l12"><input type="text" name="nombre" id="nombre" /></div>
</div>
<div class="row">
    <div class="col l4">SEXO</div>
    <div class="col l8">
        <div class="row">
            <div class="col l6 l6 l6 tooltipped" data-position="bottom" data-delay="50" data-tooltip="MASCULINO">
                <div class="row center-align">
                    <label class="white-text" for="sexo_m"  >
                        <img src="../../images/rem/masculino.png" height="50px" />
                    </label><br />
                    <input type="radio"
                           style="position: relative;visibility: visible;left: 0px;"
                           id="sexo_m" name="sexo" value="M" checked="checked" >
                </div>
            </div>
            <div class="col l6 l6 l6 tooltipped" data-position="bottom" data-delay="50" data-tooltip="FEMENINO">
                <div class="row center-align">
                    <label class="white-text" for="sexo_f">
                        <img src="../../images/rem/femenino.png" height="50px" />
                    </label><br />
                    <input type="radio"
                           style="position: relative;visibility: visible;left: 0px;"
                           id="sexo_f" name="sexo" value="F" >
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col l12">PUEBLO ORIGINARIO</div>
    <div class="col l12">
        <select name="pueblo" id="pueblo">
            <option>NO</option>
            <option>SI</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col l12">POBLACIÓN MIGRANTE</div>
    <div class="col l12">
        <select name="migrante" id="migrante">
            <option>NO</option>
            <option>SI</option>
        </select>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#pueblo').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $('#migrante').jqxDropDownList({
            width: '100%',
            theme: 'eh-open',
            height: '25px'
        });
        $("#rut").on('change',function(){
            $('#rut').Rut({
                on_error: function() {
                    $(this).focus();
                    //alert('Rut incorrecto');
                    alertaLateral('RUT INCORRECTO');
                    $('#rut').val('');
                    $('#rut').focus();
                    $('#rut').css({
                        "border": "solid red 1px"
                    });
                },
                on_success: function (){
                    var rut = $('#rut').val();
                    buscarDatosPersona(rut,'nombre_completo','nombre');
                    buscarDatosPersona(rut,'sexo','sexo');
                }
            });
        });
    })
</script>
