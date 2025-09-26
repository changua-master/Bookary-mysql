<?php
$host = "localhost";
$dbname = "bookary";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$id = $_GET['id'];
$sql = "SELECT * FROM prestamos WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result ->fetch_assoc();

if(isset ($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    $update  = "UPDATE prestamos SET nombre='$nombre', cargo='$cargo', fecha='$fecha', descripcion='$descripcion' WHERE id=$id";
    
    if ($conn->query($update) ) {
        header("Location: registro_actividades.php");
        exit();
    } else {
        echo "error al actualizar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="caramelito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h2>Editar Registro</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo $row['cargo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $row['fecha']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo $row['descripcion']; ?></textarea>
        </div>
        <button type="submit" name="actualizar" class="btn btn-success">Actualizar</button>
        <a href="registro_actividades.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>