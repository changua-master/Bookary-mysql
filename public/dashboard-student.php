<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante - Bookary</title>
    <link rel="stylesheet" href="assets/css/bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="student-layout">
    <!-- Sidebar específico para estudiante -->
    <div class="sidebar student-sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Mi Biblioteca</h3>
            <button class="sidebar-close" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="dashboard-student.php" class="sidebar-link active">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </li>
            <li class="sidebar-item">
                <a href="catalogo.php" class="sidebar-link">
                    <i class="fas fa-books"></i> Catálogo
                </a>
            </li>
            <li class="sidebar-item">
                <a href="mis-prestamos.php" class="sidebar-link">
                    <i class="fas fa-book-reader"></i> Mis Préstamos
                </a>
            </li>
            <li class="sidebar-item">
                <a href="favoritos.php" class="sidebar-link">
                    <i class="fas fa-heart"></i> Mis Favoritos
                </a>
            </li>
            <li class="sidebar-item">
                <a href="historial.php" class="sidebar-link">
                    <i class="fas fa-history"></i> Historial
                </a>
            </li>
        </ul>
    </div>
    <!-- Overlay para el sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    <nav class="navbar student-navbar">
        <div class="container">
            <div class="navbar-content">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="#" class="navbar-brand">Book<span>ary</span></a>
                <ul class="navbar-nav">
                    <li class="dropdown">
                        <button class="dropdown-toggle" id="studentMenu">
                            <i class="fas fa-user-circle"></i>
                            Estudiante
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="studentMenu">
                            <a href="perfil-estudiante.php" class="dropdown-item">
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
            <h1 class="welcome-title">Bienvenido a tu Biblioteca Personal</h1>
            <p class="welcome-subtitle">Explora nuestro catálogo y gestiona tus préstamos</p>
        </div>

        <div class="dashboard-grid">
            <a href="catalogo.php" class="dashboard-card student-card">
                <div class="card-icon">
                    <i class="fas fa-books"></i>
                </div>
                <h3>Explorar Catálogo</h3>
                <p>Descubre nuevos libros</p>
            </a>
            <a href="mis-prestamos.php" class="dashboard-card student-card">
                <div class="card-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3>Mis Préstamos</h3>
                <p>Gestiona tus libros prestados</p>
            </a>
            <a href="favoritos.php" class="dashboard-card student-card">
                <div class="card-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Favoritos</h3>
                <p>Tus libros guardados</p>
            </a>
            <a href="historial.php" class="dashboard-card student-card">
                <div class="card-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h3>Historial</h3>
                <p>Tu actividad en la biblioteca</p>
            </a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>