<?php
session_start();
require_once '../../config/conexion.php';

// 1. Verificación de rol y sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.html');
    exit();
}

// 2. Obtener y validar el ID del préstamo
$id_prestamo = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id_prestamo === false) {
    $_SESSION['error_message'] = "ID de préstamo no válido.";
    header('Location: index.php');
    exit();
}

// 3. Obtener el ID del libro antes de actualizar
$sql_get_libro = "SELECT id_libro FROM prestamos WHERE id = ?";
$stmt_get_libro = $conexion->prepare($sql_get_libro);
$stmt_get_libro->bind_param("i", $id_prestamo);
$stmt_get_libro->execute();
$resultado = $stmt_get_libro->get_result();
$prestamo = $resultado->fetch_assoc();

if (!$prestamo) {
    $_SESSION['error_message'] = "El préstamo no existe.";
    header('Location: index.php');
    exit();
}
$id_libro = $prestamo['id_libro'];
$stmt_get_libro->close();


// 4. Lógica de la transacción para la devolución
$conexion->begin_transaction();

try {
    // Actualizar el estado del préstamo a 'devuelto'
    $sql_prestamo = "UPDATE prestamos SET estado = 'devuelto', fecha_devolucion = CURDATE() WHERE id = ?";
    $stmt_prestamo = $conexion->prepare($sql_prestamo);
    $stmt_prestamo->bind_param("i", $id_prestamo);
    $stmt_prestamo->execute();

    // Incrementar el número de ejemplares del libro
    $sql_libro = "UPDATE libros SET ejemplares = ejemplares + 1 WHERE id = ?";
    $stmt_libro = $conexion->prepare($sql_libro);
    $stmt_libro->bind_param("i", $id_libro);
    $stmt_libro->execute();

    // Confirmar la transacción
    $conexion->commit();

    $_SESSION['success_message'] = "Devolución registrada exitosamente.";
    header('Location: index.php');

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conexion->rollback();
    error_log("Error al registrar la devolución: " . $e->getMessage());
    $_SESSION['error_message'] = "Error al registrar la devolución. Inténtalo de nuevo.";
    header('Location: index.php');
}

$stmt_prestamo->close();
$stmt_libro->close();
$conexion->close();
exit();
?>
