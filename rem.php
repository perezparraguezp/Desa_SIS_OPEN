<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi App con Iframe</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        iframe {
            width: 100%;
            height: 100vh;
            border: none;
            display: block;
        }
    </style>
</head>
<body>
<iframe id="appIframe"></iframe>

<script>
    (function() {
        const IFRAME_URL = 'https://script.google.com/macros/s/AKfycbxRWhUdKouUl_-BlI3FCUZvx5GEMd3kWaJb7KvxyAcAgirU05PXAkfW4iJS7CS937th/exec';

        function getDeviceInfo() {
            const ua = navigator.userAgent;
            return {
                isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(ua),
                isTablet: /iPad|Android(?!.*Mobile)/i.test(ua),
                os: getOS(ua),
                browser: getBrowser(ua),
                screenWidth: window.innerWidth,
                screenHeight: window.innerHeight,
                touchPoints: navigator.maxTouchPoints || 0,
                pixelRatio: window.devicePixelRatio || 1
            };
        }

        function getOS(ua) {
            if (/Windows/i.test(ua)) return 'windows';
            if (/Mac/i.test(ua)) return 'macos';
            if (/Android/i.test(ua)) return 'android';
            if (/iOS|iPhone|iPad|iPod/i.test(ua)) return 'ios';
            return 'unknown';
        }

        function getBrowser(ua) {
            if (/Chrome/i.test(ua) && !/Edge/i.test(ua)) return 'chrome';
            if (/Safari/i.test(ua) && !/Chrome/i.test(ua)) return 'safari';
            if (/Firefox/i.test(ua)) return 'firefox';
            if (/Edge/i.test(ua)) return 'edge';
            return 'other';
        }

        function cargarIframe() {
            const deviceInfo = getDeviceInfo();
            const params = new URLSearchParams({
                desde_iframe: 'true',
                mobile: deviceInfo.isMobile,
                tablet: deviceInfo.isTablet,
                os: deviceInfo.os,
                browser: deviceInfo.browser,
                ancho: deviceInfo.screenWidth,
                alto: deviceInfo.screenHeight,
                touch: deviceInfo.touchPoints > 0,
                timestamp: Date.now() // Para evitar caché
            });

            const iframe = document.getElementById('appIframe');
            iframe.src = `${IFRAME_URL}?${params.toString()}`;

            console.log('Cargando iframe con parámetros:', deviceInfo);
        }

        // Solo cargar una vez al inicio
        cargarIframe();

        // NO agregar evento resize para evitar recargas constantes
    })();
</script>
</body>
</html>