<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.html');
    exit();
}

include "../config/conexion.php";


// 2. Lógica para obtener los datos de la base de datos
$sql = "SELECT id, titulo, autor, categoria, ejemplares FROM libros ORDER BY id DESC";
$resultado = $conexion->query($sql);

if ($resultado === false) {
    // Si la consulta falla, muestra un mensaje de error
    die("Error al cargar los libros: " . $conexion->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - Bookary</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="../assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="admin-layout">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Menú Principal</h3>
            <button class="sidebar-close" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="admin.php" class="sidebar-link">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </li>
            <li class="sidebar-item">
                <a href="agregar_libro.php" class="sidebar-link">
                    <i class="fas fa-book-medical"></i> Agregar Libro
                </a>
            </li>
            <li class="sidebar-item">
                <a href="prestamos.php" class="sidebar-link">
                    <i class="fas fa-book-reader"></i> Préstamos
                </a>
            </li>
            <li class="sidebar-item">
                <a href="usuarios.php" class="sidebar-link">
                    <i class="fas fa-users"></i> Usuarios
                </a>
            </li>
            <li class="sidebar-item">
                <a href="reportes.php" class="sidebar-link">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </li>

        </ul>
    </div>
    <!-- Overlay para el sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Navbar con menú desplegable -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <div class="navbar-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="#" class="navbar-brand">Book<span>ary</span></a>
                </div>
                <div class="navbar-right">
                    <div class="user-menu">
                        <a href="perfil.php" class="nav-link">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                        <a href="usuarios.php" class="nav-link">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                        <div class="dropdown">
                            <button class="dropdown-toggle" id="adminMenu">
                                <i class="fas fa-user-circle"></i> Administrador
                            </button>
                        </div>
                        <a href="cerrar.php" class="nav-link logout-link">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container section main-content" id="mainContent">
        <!-- CAMBIAR: Header de administración -->
        <div class="admin-header">
            <h1 class="admin-title">Panel de Administración</h1>
            <div class="admin-actions">
                <a href="agregar_libro.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Libro
                </a>
                <a href="reportes.php" class="btn btn-outline">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="stats-summary">
            <div class="stat-item">
                <span class="stat-value">1,250</span>
                <span class="stat-label">Total Libros</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">856</span>
                <span class="stat-label">Usuarios</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">124</span>
                <span class="stat-label">Préstamos Activos</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">98%</span>
                <span class="stat-label">Disponibilidad</span>
            </div>
        </div>
            <div class="chart-container">
                <canvas id="statsChart"></canvas>
            </div>
        </div>

        <!-- Tabla de libros -->
        <div class="table-container">
            <div class="table-header">
                <h2>Lista de Libros</h2>
            </div>
            <table class="table" id="librosTable">
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
                            <a href="editar_libro.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="eliminar_libro.php?id=<?php echo $row['id']; ?>" class="btn btn-error btn-xs">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Scripts -->
    <script src="sidebar.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <!-- Dashboard Script -->
    <script src="dashboard.js"></script>
</body>
</html>
<?php
$conexion->close();
?>