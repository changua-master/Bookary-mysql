<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

// Corregir la ruta de inclusión para que funcione desde la raíz
include "config/conexion.php";

// Lógica para obtener los datos de la base de datos
$sql = "SELECT id, titulo, autor, categoria, ejemplares FROM libros ORDER BY id DESC";
$resultado = $conexion->query($sql);

if ($resultado === false) {
    die("Error al cargar los libros: " . $conexion->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros - Bookary</title>
    <!-- Estilos con rutas corregidas -->
    <link rel="stylesheet" href="assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="admin-layout">
    <!-- Sidebar con rutas corregidas -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Menú Principal</h3>
            <button class="sidebar-close" id="closeSidebar"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item"><a href="dashboard-admin.php" class="sidebar-link"><i class="fas fa-home"></i> Panel Principal</a></li>
            <li class="sidebar-item"><a href="admin.php" class="sidebar-link active"><i class="fas fa-book"></i> Gestión de Libros</a></li>
            <li class="sidebar-item"><a href="admin/prestamos/" class="sidebar-link"><i class="fas fa-book-reader"></i> Préstamos</a></li>
            <li class="sidebar-item"><a href="admin/usuarios/" class="sidebar-link"><i class="fas fa-users"></i> Usuarios</a></li>
        </ul>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <button class="toggle-sidebar" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                <a href="index.html" class="navbar-brand">Book<span>ary</span></a>
                <a href="cerrar.php" class="btn btn-secondary btn-sm">Cerrar Sesión <i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <main class="main-content" id="mainContent">
        <div class="container section">
            <div class="admin-header">
                <h1 class="admin-title">Gestión de Libros</h1>
                <div class="admin-actions">
                    <a href="admin/agregar_libro.php" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Libro</a>
                </div>
            </div>

            <!-- Tabla de libros -->
            <div class="table-container">
                <table class="table table-hover" id="librosTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Ejemplares</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($row['autor']); ?></td>
                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                            <td><?php echo $row['ejemplares']; ?></td>
                            <td>
                                <a href="admin/editar_libro.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
                                <a href="admin/libros/eliminar_libro.php?id=<?php echo $row['id']; ?>" class="btn btn-error btn-xs"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Scripts con rutas corregidas -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
<?php
$conexion->close();
?>
