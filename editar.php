<?php
// Configuración de la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "alumno";
$puerto = 3306;

$mensaje = "";
$mensaje_tipo = "";

// Obtener el ID del alumno a editar
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id == 0) {
    die("ID de alumno no válido");
}

$conn = mysqli_connect($servername, $username, $password, $dbname, $puerto);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Obtener datos actuales del alumno
$sql = "SELECT id, nombre, rol, Nºcontrol, foto FROM datos2 WHERE id = $id";
$result = mysqli_query($conn, $sql);
$alumno = mysqli_fetch_assoc($result);

if (!$alumno) {
    die("Alumno no encontrado");
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    $Nºcontrol = mysqli_real_escape_string($conn, $_POST['Nºcontrol']);
    $foto = mysqli_real_escape_string($conn, $_POST['foto']);
    
    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($rol) && !empty($Nºcontrol) && !empty($foto)) {
        // Actualizar el alumno en la base de datos
        $sql_update = "UPDATE datos2 SET 
                      nombre = '$nombre', 
                      rol = '$rol', 
                      Nºcontrol = '$Nºcontrol', 
                      foto = '$foto' 
                      WHERE id = $id";
        
        if (mysqli_query($conn, $sql_update)) {
            $mensaje = "Alumno actualizado correctamente";
            $mensaje_tipo = "exito";
            
            // Actualizar los datos locales
            $alumno['nombre'] = $nombre;
            $alumno['rol'] = $rol;
            $alumno['Nºcontrol'] = $Nºcontrol;
            $alumno['foto'] = $foto;
        } else {
            $mensaje = "Error al actualizar el alumno: " . mysqli_error($conn);
            $mensaje_tipo = "error";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios";
        $mensaje_tipo = "error";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Alumno - Equipo Triple 7</title>
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
        
        .foto-preview {
            text-align: center;
            margin: 15px 0;
        }
        
        .foto-preview img {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            border: 2px solid #ddd;
        }
        
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-actualizar {
            background-color: #f39c12;
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
        
        .btn-actualizar:hover {
            background-color: #e67e22;
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
        
        .btn-cancelar {
            background-color: #95a5a6;
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
            margin-left: 10px;
        }
        
        .btn-cancelar:hover {
            background-color: #7f8c8d;
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
            padding: 10px;
            border-radius: 4px;
        }
        
        .id-alumno {
            background-color: #2c3e50;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="titulo-equipo">Editar Alumno - Equipo Triple 7</div>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje <?php echo $mensaje_tipo; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div class="contenedor-formulario">
        <div class="id-alumno">ID del Alumno: <?php echo $alumno['id']; ?></div>
        
        <div class="info">
            <strong>Información:</strong> Modifique los campos que desee actualizar y haga clic en "Actualizar Alumno".
        </div>
        
        <div class="foto-preview">
            <img src="<?php echo $alumno['foto']; ?>" alt="Foto actual" onerror="this.src='https://via.placeholder.com/120x150?text=Imagen+no+disponible'">
            <p>Vista previa de la foto actual</p>
        </div>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>">
            <div class="form-group">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="rol">Rol en el equipo:</label>
                <input type="text" id="rol" name="rol" value="<?php echo htmlspecialchars($alumno['rol']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="Nºcontrol">Número de control:</label>
                <input type="text" id="Nºcontrol" name="Nºcontrol" value="<?php echo htmlspecialchars($alumno['Nºcontrol']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="foto">URL de la foto:</label>
                <input type="text" id="foto" name="foto" value="<?php echo htmlspecialchars($alumno['foto']); ?>" required 
                       placeholder="Ej: https://ejemplo.com/foto.jpg" 
                       onchange="document.getElementById('preview-img').src = this.value;">
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn-actualizar">Actualizar Alumno</button>
                <a href="index.php" class="btn-volver">Volver a la lista</a>
                <a href="javascript:history.back()" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        // Actualizar vista previa en tiempo real
        document.getElementById('foto').addEventListener('input', function() {
            document.getElementById('preview-img').src = this.value;
        });
    </script>
</body>
</html>