<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - Bookary</title>
    <link rel="stylesheet" href="assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <!-- Sidebar específico para administrador -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Panel Administrativo</h3>
            <button class="sidebar-close" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="dashboard-admin.php" class="sidebar-link active">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </li>
            <li class="sidebar-item">
                <a href="admin.php" class="sidebar-link">
                    <i class="fas fa-book"></i> Gestión de Libros
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
            <li class="sidebar-item">
                <a href="configuracion.php" class="sidebar-link">
                    <i class="fas fa-cog"></i> Configuración
                </a>
            </li>
        </ul>
    </div>
    <!-- Overlay para el sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="#" class="navbar-brand">Book<span>ary</span></a>
                <ul class="navbar-nav">
                    <li class="dropdown">
                        <button class="dropdown-toggle" id="adminMenu">
                            <i class="fas fa-user-circle"></i>
                            Administrador
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="adminMenu">
                            <a href="perfil.php" class="dropdown-item">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="cerrar.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container section main-content" id="mainContent">
        <div class="welcome-section">
            <h1 class="welcome-title">Bienvenido al Panel de Administración</h1>
            <p class="welcome-subtitle">Selecciona una de las opciones para comenzar</p>
        </div>

        <div class="dashboard-grid">
            <a href="admin.php" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3>Gestión de Libros</h3>
                <p>Administra el catálogo de libros</p>
            </a>
            <a href="prestamos.php" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3>Préstamos</h3>
                <p>Gestiona los préstamos activos</p>
            </a>
            <a href="usuarios.php" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Usuarios</h3>
                <p>Administra los usuarios del sistema</p>
            </a>
            <a href="reportes.php" class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Reportes</h3>
                <p>Visualiza estadísticas y reportes</p>
            </a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>