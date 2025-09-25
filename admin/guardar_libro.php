<?php
session_start();
include_once '../config/conexion.php';

// 1. Verificación de rol y sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.html');
    exit();
}

// 2. Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: agregar_libro.php');
    exit();
}

// 3. Recolección y saneamiento de datos
$titulo = trim($_POST['titulo'] ?? '');
$autor = trim($_POST['autor'] ?? '');
$editorial = trim($_POST['editorial'] ?? null);
$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);
$isbn = trim($_POST['isbn'] ?? null);
$ano_publicacion = filter_input(INPUT_POST, 'ano_publicacion', FILTER_VALIDATE_INT);
$ejemplares = filter_input(INPUT_POST, 'ejemplares', FILTER_VALIDATE_INT);
$ubicacion = trim($_POST['ubicacion'] ?? null);

// 4. Validación de datos esenciales
if (empty($titulo) || empty($autor) || $id_categoria === false) {
    $_SESSION['error_message'] = "Error: El título, autor y categoría son obligatorios.";
    header('Location: agregar_libro.php');
    exit();
}

// Convertir valores vacíos a NULL para la base de datos
$editorial = $editorial ?: null;
$isbn = $isbn ?: null;
$ano_publicacion = $ano_publicacion ?: null;
$ubicacion = $ubicacion ?: null;
$ejemplares = ($ejemplares !== false && $ejemplares >= 0) ? $ejemplares : 0;


// 5. Preparar la consulta SQL para inserción
$sql = "INSERT INTO libros (titulo, autor, editorial, id_categoria, isbn, ano_publicacion, ejemplares, ubicacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if ($stmt === false) {
    // Manejo de error en la preparación
    error_log("Error al preparar la consulta: " . $conexion->error);
    $_SESSION['error_message'] = "Error interno del servidor al preparar la consulta.";
    header('Location: agregar_libro.php');
    exit();
}

// 6. Vincular parámetros y ejecutar
$stmt->bind_param("sssisiss", 
    $titulo, 
    $autor, 
    $editorial, 
    $id_categoria, 
    $isbn, 
    $ano_publicacion, 
    $ejemplares, 
    $ubicacion
);

if ($stmt->execute()) {
    // Éxito en la inserción
    $_SESSION['success_message'] = "¡Libro agregado exitosamente!";
    header('Location: admin.php');
} else {
    // Error en la ejecución
    error_log("Error al ejecutar la consulta: " . $stmt->error);
    $_SESSION['error_message'] = "Error al guardar el libro. Por favor, inténtalo de nuevo.";
    header('Location: agregar_libro.php');
}

// 7. Cerrar statement y conexión
$stmt->close();
$conexion->close();
exit();
?>
