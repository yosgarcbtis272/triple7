<?php
// Configuración de la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "alumno";
$puerto = 3306;

// Verificar que se recibió el ID por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Conectar a la base de datos
    $conn = mysqli_connect($servername, $username, $password, $dbname, $puerto);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Obtener y sanitizar el ID
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Preparar y ejecutar la consulta de eliminación
    $sql = "DELETE FROM datos2 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $resultado = mysqli_stmt_execute($stmt);
        
        if ($resultado) {
            // Redirigir con mensaje de éxito
            header("Location: index.php?eliminado=1");
            exit();
        } else {
            // Redirigir con mensaje de error
            header("Location: index.php?eliminado=0");
            exit();
        }
        
        mysqli_stmt_close($stmt);
    } else {
        // Redirigir con mensaje de error
        header("Location: index.php?eliminado=0");
        exit();
    }
    
    mysqli_close($conn);
} else {
    // Si no se recibió el ID, redirigir a la página principal
    header("Location: index.php");
    exit();
}
?>