

<div class="">
    <div class="row">
        <div class="col l2">
            <form id="formFiltroMap_final" class="card-panel">
                <p>
                    <input class="with-gap"
                           name="riesgo" type="radio" id="alto" onclick="updateVistaMapa('ALTO')" />
                    <label for="alto">RIESGO ALTO</label>
                </p>
                <p>
                    <input class="with-gap" name="riesgo" type="radio" id="medio" onclick="updateVistaMapa('MEDIO')" />
                    <label for="medio">RIESGO MEDIO</label>
                </p>
                <p>
                    <input class="with-gap" name="riesgo" type="radio" id="bajo" onclick="updateVistaMapa('BAJO')" />
                    <label for="bajo">RIESGO BAJO</label>
                </p>
                <p>
                    <input class="with-gap" name="riesgo" type="radio" id="todos" onclick="updateVistaMapa('TODOS')" checked />
                    <label for="todos">TODOS</label>
                </p>
            </form>
        </div>
        <div class="col l10">
            <div class="container" id="mapa_actualizado">
                <iframe src="mapa/general.php" style="width: 100%;height: 700px;">
                </iframe>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Detectar cambios en cualquier select por su atributo name

    });
    function updateVistaMapa(tipo){
        $("#mapa_actualizado").html('BUSCANDO FAMILIAS');
        $.post('mapa/general.php', {
            tipo:tipo
        }, function (data) {
            $("#mapa_actualizado").html(data);
        });
    }
</script>