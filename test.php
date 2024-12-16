<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicador de Riesgo - Barra Vertical</title>
    <!-- Incluir jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Estilos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        /* Contenedor de la barra */
        .container {
            position: relative;
            width: 50px;
            height: 300px;
            margin: 0 auto;
            border: 1px solid #000;
        }

        /* Barra de colores */
        .bar {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, darkgreen 20%, lightgreen 20%, lightgreen 40%, yellow 40%, yellow 60%, orange 60%, orange 80%, red 80%);
        }

        /* Flecha o marcador */
        .arrow {
            width: 0;
            height: 0;
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
            border-right: 20px solid black;
            position: absolute;
            left: -30px; /* Colocamos la flecha a la izquierda de la barra */
            transform: translateY(-50%);
            transition: top 0.5s ease;
        }

        /* Mostrar el estado actual de riesgo */
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

<!-- Contenedor de la barra vertical -->
<div class="container">
    <div class="bar"></div>
    <div class="arrow" id="arrow"></div>
</div>

<!-- Mostrar el estado de riesgo actual -->
<p class="current-risk">Estado actual: <span id="current-risk-text">Verde Oscuro</span></p>

<!-- Botones de control para cambiar el estado -->
<div class="controls">
    <button data-risk="darkgreen">Verde Oscuro</button>
    <button data-risk="lightgreen">Verde Claro</button>
    <button data-risk="yellow">Amarillo</button>
    <button data-risk="orange">Naranja</button>
    <button data-risk="red">Rojo</button>
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        // Función para mover la flecha según el nivel de riesgo
        function moveArrow(topPercentage, riskText) {
            const arrowPosition = topPercentage + '%';
            $('#arrow').css('top', arrowPosition);

            // Actualizar el texto del estado de riesgo
            $('#current-risk-text').text(riskText);
        }

        // Inicialmente, la flecha está en "verde oscuro"
        moveArrow(90, 'Verde Oscuro');

        // Manejar los botones para cambiar el estado de riesgo
        $('button').click(function() {
            const riskLevel = $(this).data('risk');
            let position, riskText;

            switch (riskLevel) {
                case 'darkgreen':
                    position = 90; // Verde oscuro (parte inferior)
                    riskText = 'Verde Oscuro';
                    break;
                case 'lightgreen':
                    position = 70; // Verde claro
                    riskText = 'Verde Claro';
                    break;
                case 'yellow':
                    position = 50; // Amarillo (centro)
                    riskText = 'Amarillo';
                    break;
                case 'orange':
                    position = 30; // Naranja
                    riskText = 'Naranja';
                    break;
                case 'red':
                    position = 10; // Rojo (parte superior)
                    riskText = 'Rojo';
                    break;
            }

            // Mover la flecha y actualizar el texto
            moveArrow(position, riskText);
        });
    });
</script>

</body>
</html>
