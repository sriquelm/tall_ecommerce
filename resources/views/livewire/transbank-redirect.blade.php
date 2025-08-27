<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redirigiendo a Webpay...</title>
</head>
<body>
    <p>Redirigiendo a Webpay, por favor espera...</p>
    <form id="webpayForm" method="POST" action="{{ $url }}">
        <input type="hidden" name="token_ws" value="{{ $token }}" />
        <noscript>
            <button type="submit">Continuar a Webpay</button>
        </noscript>
    </form>

    <script>
        (function(){
            document.getElementById('webpayForm').submit();
        })();
    </script>
</body>
</html>
