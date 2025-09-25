<?php
session_start();
// Si hay una sesión activa, verificar si están intentando acceder directamente al dashboard
if (isset($_SESSION['rol'])) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    // Solo redirigir si están intentando acceder a los dashboards
    if ($currentPage === 'dashboard-admin.php' || $currentPage === 'dashboard-student.php') {
        if ($_SESSION['rol'] === 'admin') {
            header('Location: dashboard-admin.php');
            exit();
        } else {
            header('Location: dashboard-student.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Bookary</title>
    <link rel="stylesheet" href="bookary.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-welcome {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-welcome::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: rotate 30s linear infinite;
        }

        .welcome-container {
            text-align: center;
            color: var(--color-white);
            position: relative;
            z-index: 1;
            padding: 2rem;
            max-width: 600px;
        }

        .welcome-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.8s ease;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .welcome-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .welcome-btn {
            padding: 1rem 2rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-login {
            background: var(--color-white);
            color: var(--color-primary);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-register {
            border: 2px solid var(--color-white);
            color: var(--color-white);
        }

        .btn-register:hover {
            background: var(--color-white);
            color: var(--color-primary);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <main class="hero-welcome">
        <div class="welcome-container">
            <h1 class="welcome-title">Bienvenido a Bookary</h1>
            <p class="welcome-subtitle">Tu biblioteca digital personal. Descubre, aprende y comparte conocimiento.</p>
            <div class="welcome-buttons">
                <a href="login.html" class="welcome-btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="singup.html" class="welcome-btn btn-register">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            </div>
        </div>
    </main>
</body>
</html>