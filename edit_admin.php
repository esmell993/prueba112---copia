<?php
$conectatealadba = new mysqli("localhost", "root", "", "proyecto_facturacion");

if ($conectatealadba->connect_error) {
    die("Conexión fallida: " . $conectatealadba->connect_error);
}

$nombre_cliente = isset($_GET["cliente"]) ? $_GET["cliente"] : "";

$mensaje_exito = isset($_GET["mensaje"]) ? $_GET["mensaje"] : "";

$sql_facturas_cliente = "SELECT codigo_factura, nombre_producto, cantidad, precio_unitario, subtotal
                        FROM semi_factura
                        WHERE nombre_cliente = ?
                        ORDER BY codigo_factura";

$stmt_facturas_cliente = $conectatealadba->prepare($sql_facturas_cliente);
$stmt_facturas_cliente->bind_param("s", $nombre_cliente);
$stmt_facturas_cliente->execute();
$result_facturas_cliente = $stmt_facturas_cliente->get_result();

if (!$result_facturas_cliente) {
    die("Error en la consulta de facturas del cliente: " . $conectatealadba->error);
}

$stmt_facturas_cliente->close();
$conectatealadba->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Factura</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ececec;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: black solid;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            border: black solid;
        }

        th {
            background-color: #2980B9;
            color: white;
        }

        .e {
            display: inline-block;
            text-align: center;
            margin: 7px;
            color: #fff;
            background-color: #2471A3;
            text-decoration: none;
            border-radius: 4px;
            height: 25px;
            width: 100px;
            border: black solid 2px;
        }

        .mensaje-exito {
            text-align: center;
            color: #4CAF50;
            font-weight: bold;
            margin-bottom: 20px;
            border: 1px solid #4CAF50;
            padding: 10px;
            border-radius: 4px;
        }

        @media screen and (max-width: 600px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 1px;
            }
            .e{
                width: 60px;
            }
        }
    </style>
</head>

<body>
    <center>
        <?php include('sub_header.php'); ?>
        <h1>Editar Factura - Cliente: <?php echo $nombre_cliente; ?></h1>

        <?php if ($mensaje_exito): ?>
            <p class="mensaje-exito"><?php echo $mensaje_exito; ?></p>
        <?php endif; ?>
    </center>
    
    <table>
        <tr>
            <th>Código Factura</th>
            <th>Nombre Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>Acciones</th>
        </tr>
        <?php
        while ($row_factura = $result_facturas_cliente->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_factura["codigo_factura"] . "</td>";
            echo "<td>" . $row_factura["nombre_producto"] . "</td>";
            echo "<td>" . $row_factura["cantidad"] . "</td>";
            echo "<td>" . $row_factura["precio_unitario"] . "</td>";
            echo "<td>" . $row_factura["subtotal"] . "</td>";
            echo "<td><a class=e href='edit_producto.php?codigo_factura=" . $row_factura["codigo_factura"] . "'>Editar</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
