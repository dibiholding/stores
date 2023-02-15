<?php
    session_start();

    // Comprueba si el usuario ya ha iniciado sesión
    if (isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    }

    require_once("../config.php");

    // Comprueba si se ha enviado el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoge los datos del formulario
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (!$conn) {
            die("La conexión con la base de datos ha fallado: " . mysqli_connect_error());
        }

        // Busca el usuario en la base de datos
        $stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            // Comprueba si la contraseña es correcta utilizando password_verify()
            if (password_verify($password, $row["password"])) {
                $_SESSION["username"] = $username;
                header("Location: index.php");
                exit();
            }
        }

        // Si las credenciales son incorrectas, muestra un mensaje de error
        $error = "Nombre de usuario o contraseña incorrectos";
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Iniciar sesión</title>
  </head>
  <body>
    <h1>Iniciar sesión</h1>
    <?php if (isset($error)): ?>
      <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="username">Nombre de usuario:</label>
      <input type="text" name="username" required><br><br>
      <label for="password">Contraseña:</label>
      <input type="password" name="password" required><br><br>
      <input type="submit" value="Iniciar sesión">
    </form>
  </body>
</html>
