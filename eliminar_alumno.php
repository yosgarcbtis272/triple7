<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "alumno";
$puerto = 3306;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    
    $conn = mysqli_connect($servername, $username, $password, $dbname, $puerto);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    $sql = "DELETE FROM datos2 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $resultado = mysqli_stmt_execute($stmt);
        
        if ($resultado) {
            header("Location: index.php?eliminado=1");
            exit();
        } else {
            header("Location: index.php?eliminado=0");
            exit();
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header("Location: index.php?eliminado=0");
        exit();
    }
    
    mysqli_close($conn);
} else {
    header("Location: index.php");
    exit();
}
?>