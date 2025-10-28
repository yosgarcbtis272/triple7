<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname= "alumno";
$puerto= 3306 ;
$conn = mysqli_connect($servername, $username, $password, $dbname, $puerto);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Procesar mensajes de eliminación
$mensaje = "";
if (isset($_GET['eliminado'])) {
    if ($_GET['eliminado'] == '1') {
        $mensaje = "<div class='mensaje exito'>Alumno eliminado correctamente</div>";
    } else {
        $mensaje = "<div class='mensaje error'>Error al eliminar el alumno</div>";
    }
}

$sql = "SELECT id, nombre, rol, Nºcontrol, foto FROM datos2";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Alumnos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .titulo-equipo {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #e8f4f8; /* Azul claro */
        }
        
        tr:nth-child(odd) {
            background-color: #f0e6fa; /* Lila claro */
        }
        
        tr:hover {
            background-color: #ffeaa7; /* Amarillo claro al pasar el cursor */
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        td {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .foto-alumno {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            border: 2px solid #ddd;
        }
        
        a {
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
        }
        
        a:hover {
            text-decoration: underline;
            color: #1a5276;
        }
        
        .sin-alumnos {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #7f8c8d;
        }
        
        .acciones {
            text-align: center;
        }
        
        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .btn-eliminar:hover {
            background-color: #c0392b;
        }
        
        .mensaje {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="titulo-equipo">Equipo Triple 7</div>

    <?php echo $mensaje; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Nº Control</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
            <?php 
            $contador = 0;
            while($row = mysqli_fetch_assoc($result)): 
                $contador++;
            ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td>
                        <a href="https://www.google.com/search?q=<?php echo urlencode($row["nombre"]); ?>" target="_blank">
                            <?php echo $row["nombre"]; ?>
                        </a>
                    </td>
                    <td><?php echo $row["rol"]; ?></td>
                    <td><?php echo $row["Nºcontrol"]; ?></td>
                    <td>
                        <img src="<?php echo $row['foto']; ?>" class="foto-alumno" alt="Foto de <?php echo $row['nombre']; ?>">
                    </td>
                    <td class="acciones">
                        <form action="eliminar_alumno.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a <?php echo $row['nombre']; ?>?');">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="sin-alumnos">Sin alumnos registrados</div>
    <?php endif; ?>
</body>
</html>

<?php mysqli_close($conn); ?>