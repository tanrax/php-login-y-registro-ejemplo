<?php 
// Comprobamos si existe la sesión de apodo
session_start();
if (!isset($_SESSION['user'])) {
    // En caso contrario devolvemos a la página login.php
    header('Location: index.php');
    die();
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
    Hola
</body>
</html>