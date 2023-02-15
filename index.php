<?php
    require_once "config.php";

    session_start();

    // Comprueba si el usuario ha iniciado sesión
    if (!isset($_SESSION["username"])) {
        header("Location: /user/login");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>DELIVERYGOOD</title>
    </head>
    <body></body>
</html>