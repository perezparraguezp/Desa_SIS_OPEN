<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicador de Riesgo - Semáforo</title>
    <!-- Incluir jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Estilos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        /* Contenedor del semáforo */
        .semaforo {
            width: 80px;
            height: 220px;
            background-color: #333;
            border-radius: 20px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }

        /* Luces del semáforo */
        .light {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #555;
            transition: background-color 0.3s ease;
        }

        /* Colores de las luces encendidas */
        .red.active {
            background-color: red;
        }

        .yellow.active {
            background-color: yellow;
        }

        .green.active {
            background-color: green;
        }

        /* Texto que muestra el estado */
        .current-risk {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        /* Botones de control */
        .controls {
            margin-top: 20px;
        }

        button {
            margin: 5px;
            padding: 10px;
            border: none;
            background-color: #eee;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<!-- Contenedor del semáforo -->
<div class="semaforo">
    <div class="light red" id="light-red"></div>
    <div class="light yellow" id="light-yellow"></div>
    <div class="light green" id="light-green"></div>
</div>

<!-- Mostrar el estado de riesgo actual -->
<p class="current-risk">Estado actual: <span id="current-risk-text">Rojo</span></p>

<!-- Botones de control para cambiar el estado -->
<div class="controls">
    <button data-risk="red">Rojo</button>
    <button data-risk="yellow">Amarillo</button>
    <button data-risk="green">Verde</button>
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        // Función para encender la luz del semáforo según el nivel de riesgo
        function activateLight(riskLevel, riskText) {
            // Apagar todas las luces
            $('.light').removeClass('active');

            // Encender la luz según el nivel de riesgo
            $('#light-' + riskLevel).addClass('active');

            // Actualizar el texto del estado de riesgo
            $('#current-risk-text').text(riskText);
        }

        // Inicialmente, el semáforo está en "rojo"
        activateLight('red', 'Rojo');

        // Manejar los botones para cambiar el estado de riesgo
        $('button').click(function() {
            const riskLevel = $(this).data('risk');
            let riskText;

            switch (riskLevel) {
                case 'red':
                    riskText = 'Rojo';
                    break;
                case 'yellow':
                    riskText = 'Amarillo';
                    break;
                case 'green':
                    riskText = 'Verde';
                    break;
            }

            // Activar la luz correspondiente
            activateLight(riskLevel, riskText);
        });
    });
</script>

</body>
</html>
