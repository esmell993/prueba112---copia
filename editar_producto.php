<?php
$conectatealadba = new mysqli("localhost", "root", "", "proyecto_facturacion");

if ($conectatealadba->connect_error) {
    die("Conexión fallida: " . $conectatealadba->connect_error);
}

$codigo_factura = isset($_GET["codigo_factura"]) ? $_GET["codigo_factura"] : "";

$sql_detalle_factura = "SELECT codigo_factura, nombre_producto, cantidad, precio_unitario, subtotal
                        FROM semi_factura
                        WHERE codigo_factura = ?";
$stmt_detalle_factura = $conectatealadba->prepare($sql_detalle_factura);
$stmt_detalle_factura->bind_param("s", $codigo_factura);
$stmt_detalle_factura->execute();
$result_detalle_factura = $stmt_detalle_factura->get_result();

if (!$result_detalle_factura) {
    die("Error en la consulta de detalles de la factura: " . $conectatealadba->error);
}

$row_detalle_factura = $result_detalle_factura->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["eliminar_producto"])) {

        $sql_eliminar_producto = "DELETE FROM semi_factura WHERE codigo_factura = ?";

        $stmt_eliminar_producto = $conectatealadba->prepare($sql_eliminar_producto);
        $stmt_eliminar_producto->bind_param("s", $codigo_factura);

        if ($stmt_eliminar_producto->execute()) {

            header("Location: editar_factura.php?cliente=" . $row_detalle_factura["nombre_cliente"] . "&mensaje=eliminado");
            exit();
        } else {
            echo "Error al eliminar el producto: " . $stmt_eliminar_producto->error;
        }

        $stmt_eliminar_producto->close();
    } elseif (isset($_POST["actualizar_cantidad"])) {
        $cantidad_actual = $row_detalle_factura["cantidad"];

        $diferencia_cantidad = $_POST["nueva_cantidad"] - $cantidad_actual;

        $sql_actualizar_cantidad = "UPDATE semi_factura
                                    SET cantidad = ?, subtotal = cantidad * precio_unitario
                                    WHERE codigo_factura = ?";

        $stmt_actualizar_cantidad = $conectatealadba->prepare($sql_actualizar_cantidad);
        $stmt_actualizar_cantidad->bind_param("ds", $_POST["nueva_cantidad"], $codigo_factura);

        if ($stmt_actualizar_cantidad->execute()) {
            $sql_actualizar_inventario = "UPDATE productos SET cantidad = cantidad - ? WHERE nombre_producto = ?";
            $stmt_actualizar_inventario = $conectatealadba->prepare($sql_actualizar_inventario);
            $stmt_actualizar_inventario->bind_param("is", $diferencia_cantidad, $row_detalle_factura["nombre_producto"]);
            $stmt_actualizar_inventario->execute();

            header("Location: editar_factura.php?cliente=" . $row_detalle_factura["nombre_cliente"] . "&mensaje=actualizado&codigo_factura=$codigo_factura");
            exit();
        } else {
            echo "Error al actualizar la cantidad: " . $stmt_actualizar_cantidad->error;
        }

        $stmt_actualizar_cantidad->close();
    }
}

$stmt_detalle_factura->close();
$conectatealadba->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            width: 50%;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .eliminar-btn {
            background-color: #FF0000;
        }
    </style>
</head>

<body>
<?php include('sub_header2.php'); ?>

<h1>Editar Producto en Factura</h1>
<form method="post" action="">
    <label for="nueva_cantidad">Cantidad Actual:</label>
    <input type="text" value="<?php echo $row_detalle_factura["cantidad"]; ?>" readonly>

    <label for="nueva_cantidad">Nueva Cantidad:</label>
    <input type="number" name="nueva_cantidad" value="<?php echo $row_detalle_factura["cantidad"]; ?>" required>

    <button type="submit" name="actualizar_cantidad">Actualizar Cantidad</button>
    <button type="submit" name="eliminar_producto" class="eliminar-btn">Eliminar Producto</button>
</form>
</body>
</html>
