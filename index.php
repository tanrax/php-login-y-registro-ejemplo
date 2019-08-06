<?php
//======================================================================
// LOGIN
//======================================================================

//-----------------------------------------------------
// Imports
//-----------------------------------------------------
require_once('DB.php');

//-----------------------------------------------------
// Variables
//-----------------------------------------------------
$miDB = new DB();
$errorLogin = False;
$erroresEmail = [];
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
$erroresPassword = [];
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

// Comprobamos si nos llega los datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //-----------------------------------------------------
    // Funciones Para Validar
    //-----------------------------------------------------
    /**
     * Método que valida si un texto no esta vacío
     * @param {string} - Texto a validar
     * @return {boolean}
     */
    function validar_requerido(string $texto): bool
    {
        return !(trim($texto) == '');
    }

    /**
     * Método que valida si es un número entero 
     * @param {string} - Número a validar
     * @return {bool}
     */
    function validar_entero(string $numero): bool
    {
        return filter_var($numero, FILTER_VALIDATE_INT);
    }

    /**
     * Método que valida si el texto tiene un formato válido de E-Mail
     * @param {string} - Email
     * @return {bool}
     */
    function validar_email(string $texto): bool
    {
        return filter_var($texto, FILTER_VALIDATE_EMAIL);
    }

    //-----------------------------------------------------
    // Validaciones
    //-----------------------------------------------------
    // Email no esta vacio
    if (!validar_requerido($email)) {
        $erroresEmail[] = 'El campo es obligatorio.';
    }
    // Email tiene formato
    if (!validar_email($email)) {
        $erroresEmail[] = 'El campo tiene un formato no válido.';
    }
    // Password no esta vacio 
    if (!validar_requerido($password)) {
        $erroresPassword[] = 'El campo es obligatorio.';
    }

    //-----------------------------------------------------
    // Redireccionamos usuario a privado
    //-----------------------------------------------------
    if ($miDB->validarUsuario($email, $password)) {
        // Si son correctos, creamos la sesión
        session_start();
        $_SESSION['user'] = $email;
        // Redireccionamos a la página segura
        header('Location: privado.php');
        die();
    } else {
        $errorLogin = True;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <?php if ($errorLogin): ?>
    <p>¡Ups! El email o el password no es válido.</p>
    <?php endif; ?>
    <form action="" method="post">
        <p>
            <label>
                Email
                <input type="text" name="email" value="<?= $email ?>">
            </label>
            <?php if (isset($erroresEmail)): ?>
                <ul class="errores">
                    <?php 
                        foreach ($erroresEmail as $error) {
                            echo '<li>' . $error . '</li>';
                        } 
                    ?> 
                </ul>
            <?php endif; ?>
        </p>
        <p>
            <label>
                Contraseña
                <input type="password" name="password">
            </label>
            <?php if (isset($erroresPassword)): ?>
                <ul class="errores">
                    <?php 
                        foreach ($erroresPassword as $error) {
                            echo '<li>' . $error . '</li>';
                        } 
                    ?> 
                </ul>
            <?php endif; ?>
        </p>
        <p>
            <input type="submit" value="Entrar">
        </p>
   </form> 
   <p><a href="recuperar_contrasenya.php">¿Has olvidado tu contraseña?</a></p>
</body>
</html>