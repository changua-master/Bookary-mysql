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
    <title>Registro - Bookary</title>
    <!-- CAMBIAR: CSS unificado -->
    <link rel="stylesheet" href="bookary.css">
</head>
<body>
    <!-- CAMBIAR: Mostrar mensajes si existen -->
    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-info">
            <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
        </div>
    <?php } ?>

    <!-- CAMBIAR: Estructura del formulario -->
    <div class="auth-page">
        <div class="auth-container">
            <form class="auth-form" method="POST" action="registrar.php">
                <div class="form-header">
                    <div class="navbar-brand">Book<span>ary</span></div>
                    <h1 class="auth-title">Crear Cuenta</h1>
                    <p class="form-subtitle">Únete a nuestra comunidad literaria</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" class="form-input" placeholder="Ingresa tu nombre de usuario" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Crea una contraseña segura" required>
                </div>

                <button type="submit" class="btn btn-primary btn-full btn-lg">
                    <i class="fas fa-user-plus"></i> Crear Cuenta
                </button>

                <div class="auth-links">
                    <a href="login.html">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
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
    $_SESSION['mensaje'] = '<div class="message error">Error de conexión: ' . $conn->connect_error .'</div>'; 
    header("Location: registrar.php");
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
        header("Location: registrar.php");
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
?>






