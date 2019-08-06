<?php

    //-----------------------------------------------------
    // Variables
    //-----------------------------------------------------
    require_once('DB.php');
    $miDB = new DB();
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;
    $error = False;

    // Validamos que el token y el email es correcto
    if(!$miDB->comprobarToken($token, $email)) {
        header('index.php');
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password1 = isset($_REQUEST['password1']) ? $_REQUEST['password1'] : null;
        $password2 = isset($_REQUEST['password2']) ? $_REQUEST['password2'] : null;
        if($password1 === $password2) {
            // Actualizar token
            // Actualizar contrasenya
            // Redireccionar a login con mensaje
        } else {
            $error = True;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Cambia tu contraseña ahora y free</h1> 
    <?php if ($error): ?>
        <p>
            Las contraseñas no son iguales o válidas.
        </p>
    <?php endif; ?>
    <form action="" method="post">
        <p>
            <label>
            Nueva contraseña
            <input type="password" name="password1"> 
        </p>
        <p>
            <label>
                Repite la contraseña
                <input type="password" name="password2"> 
            </label> 
        </p>
        <p>
            <input type="submit" value="Cambiar"> 
        </p>
    </form>
</body>
</html>