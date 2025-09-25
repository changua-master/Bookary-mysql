<?php
session_start();
require_once '../../config/conexion.php';

// 1. Verificación de rol y sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.html');
    exit();
}

// 2. Obtener listas de libros y usuarios para los dropdowns
$libros_result = $conexion->query("SELECT id, titulo FROM libros WHERE ejemplares > 0 ORDER BY titulo ASC");
$usuarios_result = $conexion->query("SELECT id, username FROM users WHERE role = 'estudiante' ORDER BY username ASC");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Préstamo - Bookary</title>
    <link rel="stylesheet" href="../../assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include '../../includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="container section">
            <div class="form-container">
                <h1 class="form-title">Crear Nuevo Préstamo</h1>
                <form action="guardar_prestamo.php" method="POST" class="book-form">
                    <div class="form-group">
                        <label for="id_libro" class="form-label"><i class="fas fa-book"></i> Libro</label>
                        <select id="id_libro" name="id_libro" class="form-control" required>
                            <option value="">Selecciona un libro disponible</option>
                            <?php while ($libro = $libros_result->fetch_assoc()): ?>
                                <option value="<?php echo $libro['id']; ?>"><?php echo htmlspecialchars($libro['titulo']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_usuario" class="form-label"><i class="fas fa-user"></i> Usuario</label>
                        <select id="id_usuario" name="id_usuario" class="form-control" required>
                            <option value="">Selecciona un usuario</option>
                            <?php while ($usuario = $usuarios_result->fetch_assoc()): ?>
                                <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['username']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_devolucion" class="form-label"><i class="fas fa-calendar-alt"></i> Fecha de Devolución</label>
                        <input type="date" id="fecha_devolucion" name="fecha_devolucion" class="form-control" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Préstamo
                        </button>
                        <a href="index.php" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../assets/js/sidebar.js"></script>
</body>
</html>
