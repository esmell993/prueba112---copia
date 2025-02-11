
<?php
// Verificamos si se recibió un ID válido por GET
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "prueba_f");
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Verificamos si se envió un formulario de edición
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibimos los datos del formulario
        $codigo = $_POST["codigo"];
        $nombre_producto = $_POST["nombre_producto"];
        $descripcion = $_POST["descripcion"];
        $cantidad = $_POST["cantidad"];
        $precio = $_POST["precio"];
        $fecha_v = $_POST["fecha_v"];

        // Preparamos la consulta SQL de actualización
        $sql = "UPDATE productos SET 
                codigo_producto='$codigo', 
                nombre_producto='$nombre_producto', 
                descripccion='$descripcion', 
                cantidad='$cantidad', 
                precio='$precio',  
                fecha_v='$fecha_v' 
                WHERE id='$id'";

        // Ejecutamos la consulta
        if ($conn->query($sql) === TRUE) {
            echo "Producto actualizado exitosamente!";
            header("Location: inventario.php");
        } else {
            echo "Error al actualizar el producto: " . $conn->error;
        }
    }

    // Obtenemos los datos del producto a editar
    $result = $conn->query("SELECT * FROM productos WHERE id='$id'");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        body{
            background-color: #D7DBDD;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        input[type="text"] ,input[type="decimal"],
        input[type="number"] ,input[type="date"] ,
    select {
        padding: 10px 15px;
        margin: 8px 5px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        max-width:50% ;
        width:50% ;
    }
    .boton  
        {
            background-color: #154360;
    color: white;
    height: 30px;
    border-radius:20px;
    width:30%;
        }
        section{
            margin: 10px;;
        }
</style>

        </head>

<body>
<?php include('headereditar.php'); ?>
    <center>
 <section>
    <form method="post" enctype="multipart/form-data">
        <input type="number" name="codigo" placeholder="Código" required autocomplete="off" value="<?php echo $row['codigo_producto']; ?>">
        <input type="text" name="nombre_producto" placeholder="Nombre del producto" required autocomplete="off" value="<?php echo $row['nombre_producto']; ?>">
        <input type="text" name="descripcion" placeholder="Descripción" required autocomplete="off" value="<?php echo $row['descripccion']; ?>">
        <input type="number" name="cantidad" placeholder="Cantidad" required autocomplete="off" value="<?php echo $row['cantidad']; ?>">
        <input type="decimal" name="precio" placeholder="Precio" required autocomplete="off" value="<?php echo $row['precio']; ?>">
        <br>
        <input type="date" name="fecha_v" placeholder="Fecha de vencimiento" required autocomplete="off" value="<?php echo $row['fecha_v']; ?>">
        <br>

        <input  class ="boton"type="submit" value="Actualizar">
    </form>
    </center>
    </section>
</body>
</html>
<?php
    } else {
        echo "No se encontró ningún producto con ese ID.";
    }

    // Cerramos la conexión a la base de datos
    $conn->close();
} else {
    echo "ID de producto inválido.";
}
?>
