<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.html');
    exit();
}

require_once '../../config/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM libros WHERE id = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header('Location: ../../admin.php?delete_success=1');
        } else {
            header('Location: ../../admin.php?delete_error=1');
        }
        $stmt->close();
    } else {
        header('Location: ../../admin.php?delete_error=1');
    }
} else {
    header('Location: ../../admin.php');
}

$conexion->close();
?>