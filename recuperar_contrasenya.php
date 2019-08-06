<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//-----------------------------------------------------
// Imports
//-----------------------------------------------------
require_once('DB.php');

//-----------------------------------------------------
// Variables
//-----------------------------------------------------
$miDB = new DB();
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Generamos el token
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    // Guardamos el token 
    $miDB->actualizarToken($email, $token);
    // Solamente enviamos el email si existe el correo
    if($miDB->comprobarExisteCorreo($email)) {

        //-----------------------------------------------------
        // Enviar email
        //-----------------------------------------------------
        // Nuestro mensaje debe ser HTML
        $mensaje = "
        <html>
        <head>
            <title>Cambiar contraseña</title>
        </head>
        <body>
            <p>¿Qué tal? Pulsa el siguiente enlace para cambiar tu contraseña</p>
            <p>
                <a href=\"http://localhost:9000/cambiar_contrasenya.php?token=$token&email=" . urlencode($email) . "\">Cambiar</a> 
            </p>
        </body>
        </html>
        ";

        
        // Load Composer's autoloader
        require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'localhost';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = false;                                   // Enable SMTP authentication
            $mail->Username   = '';                     // SMTP username
            $mail->Password   = '';                               // SMTP password
            $mail->Port       = 1025;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Cambiar contraseña';
            $mail->Body    = $mensaje;
            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperar contrasenya</title>
</head>
<body>
    <h1>Recupera tu contraseña</h1>
    <h2>Te enviamos las instrucciones por email</h2>
    <form action="" method="post">
        <label>
            Tu email
            <input type="text" name="email">
        </label>
        <input type="submit" value="Recuperar">
    </form> 
    <p>
        <a href="/">Volver</a> 
    </p>
</body>
</html>