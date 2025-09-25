<?php
session_start();
include "conexion.php";


// 2. Lógica para obtener los datos de la base de datos
$sql = "SELECT id, titulo, autor, categoria, ejemplares FROM libros ORDER BY id DESC";
$resultado = $conexion->query($sql);

if ($resultado === false) {
    // Si la consulta falla, muestra un mensaje de error
    die("Error al cargar los libros: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Libros</title>
    <link rel="stylesheet" href="bookary.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav>
    <ul id="sub-nav" class="nav">
        <li><a href="cerrar.php" class="btn btn-danger">Cerrar Sesión</a></li>
    </ul>
</nav>

<div class="login-container">
    <div class="login-form shadow" style="max-width:700px;width:100%">
        <h2 class="text-center mb-4">Lista de libros</h2>
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
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
                    <?php
                    // 3. Visualización de los datos
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['titulo']}</td>";
                        echo "<td>{$row['autor']}</td>";
                        echo "<td>{$row['categoria']}</td>";
                        echo "<td>{$row['ejemplares']}</td>";
                        echo "<td>
                            <a href='editar_libro.php?id={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='eliminar_libro.php?id={$row['id']}' class='btn btn-danger btn-sm'>Eliminar</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="inicio.html" class="caramelito-link">Volver al inicio</a>
        </div>
    </div>
</div>

</body>
</html>

<?php
$conexion->close();
?>