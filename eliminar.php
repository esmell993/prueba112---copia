<?php
// Verificamos si se recibió un ID válido por GET
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "prueba_f");
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Preparamos la consulta SQL de eliminación
    $sql = "DELETE FROM productos WHERE id='$id'";

    // Ejecutamos la consulta
    if ($conn->query($sql) === TRUE) {
        // Redirigimos a inventario.php
        header("Location: inventario.php");
        exit; // Terminamos el script para evitar cualquier salida adicional
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }

    // Cerramos la conexión a la base de datos
    $conn->close();
} else {
    echo "ID de producto inválido.";
}
?>

