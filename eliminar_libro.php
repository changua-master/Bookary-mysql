<?php
session_start();

$host = "localhost"; //variable servidor
$dbname = "bookary"; // variable bd
$user = "root"; //variable usuario
$pass = "";    //variable contraseña

$conn = new mysqli($host, $user, $pass, $dbname); //variable de conexion y verificacion
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // sino existe genera un error.
}

$id=$_GET['Id'];

    $sql = "DELETE FROM libros WHERE Id ='" .$id."'";
    $result=mysqli_query($conn,$sql);
 
    if($result){
        echo "<script>
        alert('Los datos han sido eliminados correctamente');
        </scrip>";
         header('Location: admin.php'); // Redirige después de la eliminación
    exit;
    }
   


$conn->close();
?>