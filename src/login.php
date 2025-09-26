<?php
session_start();
include "../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT id, username, password, role FROM users WHERE username = ? AND password = ?";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'Administrador') {
                $_SESSION['role'] = 'admin';
                header("Location: admin/dashboard-admin.php");
            } else {
                $_SESSION['role'] = 'estudiante';
                header("Location: student/dashboard.php");
            }
            exit();
        } else {
            // Redirige de vuelta al login si las credenciales son incorrectas
            header("Location: login.html?error=1");
            exit();
        }
    }
} else {
    // Redirige al login si se accede directamente a login.php sin POST
    header("Location: login.html");
    exit();
}
$conexion->close();
?>