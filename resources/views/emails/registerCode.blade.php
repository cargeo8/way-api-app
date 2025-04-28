<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de Registro</title>
</head>

<body
    style="margin: 0; padding: 0;
background-color: #f9f9f9;
background-image: linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%);
background-repeat: no-repeat;height: 100vh;
font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        <table width="100%" cellpadding="0" cellspacing="0"
            style="background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 20px;">
            <tr>
                <td align="center" style="padding-bottom: 20px;">
                    <img src="https://api.portalagenciasway.com/way-logo" alt="Logo Tienda Way" style="width: 135px;">
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-bottom: 20px;">
                    <h1 style="color: deeppink; font-size: 1.8em; margin: 0;">¡Bienvenido a Agencias Way El Salvador!
                    </h1>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-bottom: 20px;">
                    <p style="color: #333; font-size: 1em; margin: 0;">
                        Gracias por registrarte en nuestra aplicación. Para completar tu registro, utiliza el siguiente
                        código de verificación:
                    </p>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding: 20px 0;">
                    <div
                        style="background: deeppink; color: #fff; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 1.5em; display: inline-block;">
                        {{ $registrationCode ?? 'XXXXXX' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-top: 20px;">
                    <p style="color: #888; font-size: 0.9em; margin: 0;">
                        Si no creaste una cuenta, puedes ignorar este mensaje.
                    </p>
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 20px;">
            <p style="color: #aaa; font-size: 0.8em; margin: 0;">
                © {{ date('Y') }} Agencias Way El Salvador. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>

</html>
