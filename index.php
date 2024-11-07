<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "tienda_infor");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $itbis = $_POST['itbis'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO articulos (id, nombre, precio, itbis, cantidad) VALUES ('$id', '$nombre', $precio, $itbis, $cantidad)";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Artículo registrado con éxito";
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Informática</title>
    <link rel="stylesheet" href="registro.css">
</head>
<body>
    <h1>Tienda de Informática</h1>
    
    <h2>Registrar Artículo</h2>
    <?php
    if (isset($mensaje)) {
        echo "<div class='mensaje'>$mensaje</div>";
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>
        
        <label for="itbis">ITBIS:</label>
        <input type="number" id="itbis" name="itbis" step="0.01" required>
        
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>
        
        <input type="submit" value="Registrar">
    </form>

    <a href="tabla_art.php">Ver artículos</a>
    <a href="venderart.php">Vender artículos</a>
</body>
</html>
