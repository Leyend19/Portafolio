<?php
$conn = new mysqli("localhost", "root", "", "tienda_infor");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM articulos");
$conn = new mysqli("localhost", "root", "", "tienda_infor");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_delete = "DELETE FROM articulos WHERE cantidad = 0";
if ($conn->query($sql_delete) === TRUE) {
    if ($conn->affected_rows > 0) {
        echo "<p>Se han eliminado " . $conn->affected_rows . " artículo(s) sin existencias.</p>";
    }
} else {
    echo "<p>Error al eliminar artículos: " . $conn->error . "</p>";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Artículos</title>
  <link rel="stylesheet" href="tabla.css">
</head>
<body>
    <h1>Lista de Artículos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>ITBIS</th>
            <th>Cantidad</th>
        </tr>
        <?php
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nombre']."</td>";
            echo "<td>".$row['precio']."</td>";
            echo "<td>".$row['itbis']."</td>";
            echo "<td>".$row['cantidad']."</td>";
            echo "</tr>";
        }
        $conn->close();
        ?>
    </table>
    <a href="index.php">Registrar otro artículo</a>
    <a href="venderart.php">Vender artículos</a>
</body>
</html>
