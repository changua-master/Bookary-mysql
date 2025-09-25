<?php
session_start();
include_once '../config/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.html');
    exit();
}

// Fetch categories for the dropdown
$categorias_result = $conexion->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro - Bookary</title>
    <link rel="stylesheet" href="../assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include '../includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="container section">
            <div class="form-container">
                <h1 class="form-title">Agregar Nuevo Libro</h1>
                <p class="form-subtitle">Completa los datos para añadir un nuevo libro al catálogo.</p>
                
                <form action="guardar_libro.php" method="POST" class="book-form">
                    <div class="form-grid">
                        <!-- Columna 1 -->
                        <div class="form-column">
                            <div class="form-group">
                                <label for="titulo" class="form-label"><i class="fas fa-book"></i> Título</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ej: Cien Años de Soledad" required>
                            </div>

                            <div class="form-group">
                                <label for="autor" class="form-label"><i class="fas fa-user-edit"></i> Autor</label>
                                <input type="text" id="autor" name="autor" class="form-control" placeholder="Ej: Gabriel García Márquez" required>
                            </div>

                            <div class="form-group">
                                <label for="editorial" class="form-label"><i class="fas fa-building"></i> Editorial</label>
                                <input type="text" id="editorial" name="editorial" class="form-control" placeholder="Ej: Sudamericana">
                            </div>
                            
                            <div class="form-group">
                                <label for="id_categoria" class="form-label"><i class="fas fa-tags"></i> Categoría</label>
                                <select id="id_categoria" name="id_categoria" class="form-control" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php while ($categoria = $categorias_result->fetch_assoc()): ?>
                                        <option value="<?php echo $categoria['id']; ?>">
                                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="form-column">
                            <div class="form-group">
                                <label for="isbn" class="form-label"><i class="fas fa-barcode"></i> ISBN</label>
                                <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Ej: 978-0307350444">
                            </div>

                            <div class="form-group">
                                <label for="ano_publicacion" class="form-label"><i class="fas fa-calendar-alt"></i> Año de Publicación</label>
                                <input type="number" id="ano_publicacion" name="ano_publicacion" class="form-control" placeholder="Ej: 1967" min="1000" max="<?php echo date('Y'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="ejemplares" class="form-label"><i class="fas fa-copy"></i> Ejemplares</label>
                                <input type="number" id="ejemplares" name="ejemplares" class="form-control" value="1" min="0">
                            </div>

                            <div class="form-group">
                                <label for="ubicacion" class="form-label"><i class="fas fa-map-marker-alt"></i> Ubicación</label>
                                <input type="text" id="ubicacion" name="ubicacion" class="form-control" placeholder="Ej: Estantería A-3">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Libro
                        </button>
                        <a href="admin.php" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/sidebar.js"></script>
</body>
</html>
