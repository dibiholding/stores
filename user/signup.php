<?php

  require_once("../config.php");

  // Comprueba si se ha enviado el formulario de registro
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    
    // Encripta la contraseña con la función password_hash()
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    
    // Comprueba si el nombre de usuario ya está en uso
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        echo "El nombre de usuario ya está en uso";
    } else {
        // Inserta el nuevo usuario en la base de datos con la contraseña encriptada
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $username, $password_encrypted, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario registrado con éxito";
            header("Location: /user/login");
            exit();
        } else {
            echo "Error al registrar al usuario: " . mysqli_error($conn);
        }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Registro de usuario</title>
  </head>
  <body>
    <h1>Registro de usuario</h1>
    <form method="post" action="/user/signup">
      <label for="username">Nombre de usuario:</label>
      <input type="text" name="username" required><br><br>
      <label for="password">Contraseña:</label>
      <input type="password" name="password" required><br><br>
      <label for="email">Correo electrónico:</label>
      <input type="email" name="email" required><br><br>
      <input type="submit" value="Registrarse">
    </form>
  </body>
</html>
