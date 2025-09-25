<?php
session_start();
$host = "localhost"; 
$dbname = "bookary"; 
$user = "root"; 
$pass = ""; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    $_SESSION['mensaje'] = '<div class="message error">Conexión fallida: ' . $conn->connect_error . '</div>';
    header("Location: singup.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="stylesheet" href="styles.css">
    <title>Bookary - Registro de Usuarios</title>
    
</head>
<body>
    <?php
            session_start();
            if (isset($_SESSION['mensaje'])) {
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }
            ?>
    <div class="container">
        <div class="header">
            <div class="logo">B</div>
            <h1>Bookary</h1>
            <p>Únete a nuestra comunidad literaria</p>
        </div>

        <div class="form-container">
            <form method="POST" action="registrar.php">
                <div class="input-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="username" required placeholder="Ingresa tu nombre de usuario">
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="Crea una contraseña segura">
                </div>

                <button type="submit" class="btn-register">Crear Cuenta</button>
            </form>

           
        </div>
    </div>
    <footer>
    <div class="footer-content">
      <div class="footer-logo">
        <a href="#">BibliotecaVirtual</a>
        <p>©️ 2025 Todos los derechos reservados.</p>
      </div>
      <div class="footer-links">
        <a href="#">Términos</a>
        <a href="#">Privacidad</a>
        <a href="#">FAQ</a>
      </div>
    </div>
  </footer>
</body> 

</html>
<?php
session_start();

$host = "localhost"; 
$dbname = "bookary"; 
$user = "root"; 
$pass = ""; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    $_SESSION['mensaje'] = '<div class="message error">Conexión fallida: ' . $conn->connect_error .'</div>'; 
    header("Location: signup.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Verificar si ya existe
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['mensaje'] = '<div class="message error">El usuario <b>' . htmlspecialchars($username) . '</b> ya existe.</div>';
        header("Location: signup.html");
        exit();
    }

    $stmt->close();

    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password_hash);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = '<div class="message success">¡Cuenta creada exitosamente! Ahora puedes iniciar sesión.</div>';
    } else {
        $_SESSION['mensaje'] = '<div class="message error">Error al crear la cuenta. Inténtalo de nuevo.</div>';
    }

    $stmt->close();
}

$conn->close();
header("Location: login.php");
exit();
?>

            <div class="footer">
                <p>&copy; 2023 Bookary. Todos los derechos reservados.</p>






