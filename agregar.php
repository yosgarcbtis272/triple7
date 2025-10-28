<?php
// Configuración de la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "alumno";
$puerto = 3306;

// Procesar el formulario cuando se envía
$mensaje = "";
$mensaje_tipo = ""; // éxito o error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect($servername, $username, $password, $dbname, $puerto);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Obtener y sanitizar los datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    $Nºcontrol = mysqli_real_escape_string($conn, $_POST['Nºcontrol']);
    $foto = mysqli_real_escape_string($conn, $_POST['foto']);
    
    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($rol) && !empty($Nºcontrol) && !empty($foto)) {
        // Insertar el nuevo alumno en la base de datos
        $sql = "INSERT INTO datos2 (nombre, rol, Nºcontrol, foto) VALUES ('$nombre', '$rol', '$Nºcontrol', '$foto')";
        
        if (mysqli_query($conn, $sql)) {
            $mensaje = "Alumno agregado correctamente";
            $mensaje_tipo = "exito";
            
            // Limpiar los campos del formulario
            $_POST = array();
        } else {
            $mensaje = "Error al agregar el alumno: " . mysqli_error($conn);
            $mensaje_tipo = "error";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios";
        $mensaje_tipo = "error";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Alumno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .titulo-equipo {
            background: linear-gradient(135deg, #9fb100ff 0%, #008fa8ff 100%);
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 24px;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(245, 59, 59, 0.1);
            width: 50%;
            margin: 0 auto;
        }
        
        .contenedor-formulario {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-agregar {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        
        .btn-agregar:hover {
            background-color: #219a52;
        }
        
        .btn-volver {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-volver:hover {
            background-color: #2980b9;
        }
        
        .mensaje {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            width: 50%;
            margin: 0 auto 20px auto;
        }
        
        .exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="titulo-equipo">Agregar Nuevo Alumno - Equipo Triple 7</div>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje <?php echo $mensaje_tipo; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="contenedor-formulario">
        <div class="info">
            <strong>Información:</strong> Complete todos los campos para agregar un nuevo alumno al sistema.
        </div>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="rol">Rol en el equipo:</label>
                <input type="text" id="rol" name="rol" value="<?php echo isset($_POST['rol']) ? $_POST['rol'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="Nºcontrol">Número de control:</label>
                <input type="text" id="Nºcontrol" name="Nºcontrol" value="<?php echo isset($_POST['Nºcontrol']) ? $_POST['Nºcontrol'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="foto">URL de la foto:</label>
                <input type="text" id="foto" name="foto" value="<?php echo isset($_POST['foto']) ? $_POST['foto'] : ''; ?>" required placeholder="Ej: https://ejemplo.com/foto.jpg">
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn-agregar">Agregar Alumno</button>
                <a href="index.php" class="btn-volver">Volver a la lista</a>
            </div>
        </form>
    </div>
</body>
</html>