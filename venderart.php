<?php

$conn = new mysqli("localhost", "root", "", "tienda_infor");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql_check = "SELECT nombre, cantidad, itbis FROM articulos WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['cantidad'] >= $cantidad) {
        $nombre = $row['nombre'];
        $itbis = $row['itbis'];

        $sql_update = "UPDATE articulos SET cantidad = cantidad - ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("is", $cantidad, $id);
        
        if ($stmt_update->execute()) {
            $mensaje = "Venta realizada con éxito. Se han vendido $cantidad unidades del artículo $nombre.";
        } else {
            $mensaje = "Error al realizar la venta: " . $conn->error;
        }
        
        $stmt_update->close();
    } else {
        $mensaje = "Error: No hay suficiente cantidad del artículo para realizar la venta o el artículo no existe.";
    }

    $stmt_check->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender Artículo</title>
    <link rel="stylesheet" href="vender.css">
</head>
<body>
    <h1>Vender Artículo</h1>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="text" name="id" placeholder="ID" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
    <?php
    if (!empty($mensaje)) {
        echo "<div class='mensaje'>$mensaje</div>";
    }
    ?>
        <input type="submit" value="Vender">
    </form>
    <a href="tabla_art.php">Ver artículos</a>
</body>
</html>

