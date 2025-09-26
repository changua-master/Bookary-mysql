<?php
session_start();
require_once '../../config/conexion.php';

// 1. Verificación de rol y sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.html');
    exit();
}

// 2. Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: crear_prestamo.php');
    exit();
}

// 3. Recolección y validación de datos
$id_libro = filter_input(INPUT_POST, 'id_libro', FILTER_VALIDATE_INT);
$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
$fecha_devolucion = $_POST['fecha_devolucion'] ?? '';

if ($id_libro === false || $id_usuario === false || empty($fecha_devolucion)) {
    $_SESSION['error_message'] = "Todos los campos son obligatorios.";
    header('Location: crear_prestamo.php');
    exit();
}

$fecha_prestamo = date('Y-m-d');

// 4. Lógica de la transacción
$conexion->begin_transaction();

try {
    // Insertar el préstamo
    $sql_prestamo = "INSERT INTO prestamos (id_libro, id_usuario, fecha_prestamo, fecha_devolucion, estado) VALUES (?, ?, ?, ?, 'activo')";
    $stmt_prestamo = $conexion->prepare($sql_prestamo);
    $stmt_prestamo->bind_param("iiss", $id_libro, $id_usuario, $fecha_prestamo, $fecha_devolucion);
    $stmt_prestamo->execute();

    // Actualizar el número de ejemplares del libro
    $sql_libro = "UPDATE libros SET ejemplares = ejemplares - 1 WHERE id = ? AND ejemplares > 0";
    $stmt_libro = $conexion->prepare($sql_libro);
    $stmt_libro->bind_param("i", $id_libro);
    $stmt_libro->execute();

    // Confirmar la transacción
    $conexion->commit();

    $_SESSION['success_message'] = "Préstamo registrado exitosamente.";
    header('Location: index.php');

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conexion->rollback();
    error_log("Error al guardar el préstamo: " . $e->getMessage());
    $_SESSION['error_message'] = "Error al registrar el préstamo. Inténtalo de nuevo.";
    header('Location: crear_prestamo.php');
}

$stmt_prestamo->close();
$stmt_libro->close();
$conexion->close();
exit();
?>
