<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.html');
    exit();
}

require_once '../../config/conexion.php';

if (isset($_GET['Id'])) {
    $id = $_GET['Id'];

    $sql = "DELETE FROM libros WHERE Id = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header('Location: ../dashboard.php?delete_success=1');
        } else {
            header('Location: ../dashboard.php?delete_error=1');
        }
        $stmt->close();
    } else {
        header('Location: ../dashboard.php?delete_error=1');
    }
} else {
    header('Location: ../dashboard.php');
}

$conexion->close();
?>