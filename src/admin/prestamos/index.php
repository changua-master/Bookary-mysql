<?php
session_start();
require_once '../../config/conexion.php';

// 1. Verificación de rol y sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.html');
    exit();
}

// 2. Obtener préstamos de la base de datos (uniendo tablas)
$sql = "SELECT 
            p.id, 
            l.titulo AS libro_titulo, 
            u.username AS usuario_nombre, 
            p.fecha_prestamo, 
            p.fecha_devolucion, 
            p.estado
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        JOIN users u ON p.id_usuario = u.id
        ORDER BY p.fecha_prestamo DESC";

$resultado = $conexion->query($sql);

if ($resultado === false) {
    die("Error al obtener los préstamos: " . $conexion->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos - Bookary</title>
    <link rel="stylesheet" href="../../assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="container section">
            <div class="admin-header">
                <h1 class="admin-title">Gestión de Préstamos</h1>
                <a href="crear_prestamo.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Préstamo
                </a>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Libro</th>
                            <th>Usuario</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado->num_rows > 0): ?>
                            <?php while ($prestamo = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $prestamo['id']; ?></td>
                                    <td><?php echo htmlspecialchars($prestamo['libro_titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($prestamo['usuario_nombre']); ?></td>
                                    <td><?php echo $prestamo['fecha_prestamo']; ?></td>
                                    <td><?php echo $prestamo['fecha_devolucion']; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($prestamo['estado']); ?>">
                                            <?php echo htmlspecialchars($prestamo['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($prestamo['estado'] === 'activo'): ?>
                                            <a href="registrar_devolucion.php?id=<?php echo $prestamo['id']; ?>" class="btn btn-success btn-xs">Marcar Devolución</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No hay préstamos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../assets/js/sidebar.js"></script>
</body>
</html>
