<?php
date_default_timezone_set('America/La_Paz');
session_start();

$conectatealadba = new mysqli("localhost", "root", "", "proyecto_facturacion");

if ($conectatealadba->connect_error) {
    die("Conexión fallida: " . $conectatealadba->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoproducto = isset($_POST["codigoproducto"]) ? htmlspecialchars($_POST["codigoproducto"]) : '';
    $nombre_cliente = isset($_POST["nombre_cliente"]) ? htmlspecialchars($_POST["nombre_cliente"]) : 'Nombre Cliente No Especificado';

    if (!empty($codigoproducto)) {
        $cantidad_equitativa = isset($_POST["qty"]) ? intval($_POST["qty"]) : 0;

        $stmt_producto = $conectatealadba->prepare("SELECT codigo_producto, nombre_producto, descripccion, cantidad, precio, categoria, fecha_v FROM productos WHERE codigo_producto = ?");

        if (!$stmt_producto) {
            die("Error en la preparación de la consulta: " . $conectatealadba->error);
        }

        $stmt_producto->bind_param("s", $codigoproducto);
        $stmt_producto->execute();
        $result_producto = $stmt_producto->get_result();

        if (!$result_producto) {
            die("Error en la ejecución de la consulta: " . $stmt_producto->error);
        }

        if ($result_producto->num_rows > 0) {
            $row_producto = $result_producto->fetch_assoc();

            if ($row_producto["cantidad"] >= $cantidad_equitativa) {

                $total = floatval($cantidad_equitativa) * floatval($row_producto["precio"]);

                $codigo_factura = date("YmdHis");

                $correo_empleado = isset($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : 'correo_del_usuario';

                $stmt_insertar_factura = $conectatealadba->prepare("INSERT INTO semi_factura (codigo_factura, codigo_producto, nombre_producto, descripccion, precio_unitario, cantidad, subtotal, correo_empleado, fecha, nombre_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?)");

                if (!$stmt_insertar_factura) {
                    die("Error en la preparación de la consulta: " . $conectatealadba->error);
                }

                $stmt_insertar_factura->bind_param("ssssddsss", $codigo_factura, $row_producto["codigo_producto"], $row_producto["nombre_producto"], $row_producto["descripccion"], $row_producto["precio"], $cantidad_equitativa, $total, $correo_empleado, $nombre_cliente);

                if ($stmt_insertar_factura->execute()) {
                    $nueva_cantidad = $row_producto["cantidad"] - $cantidad_equitativa;
                    $stmt_actualizar_cantidad = $conectatealadba->prepare("UPDATE productos SET cantidad = ? WHERE codigo_producto = ?");
                    $stmt_actualizar_cantidad->bind_param("is", $nueva_cantidad, $row_producto["codigo_producto"]);
                    $stmt_actualizar_cantidad->execute();

                    if (!$stmt_actualizar_cantidad) {
                        die("Error al actualizar la cantidad del producto: " . $conectatealadba->error);
                    }
                    

                    echo "<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid gray;
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #D5DBDB;
        }
        p {
            color:green;
        }
        .total {
            background-color: #EAEDED;
        }
    </style>";

echo "<p>Compra realizada con éxito.</p>";

echo "<table>";
echo "<tr><th>Codigo Producto</th><th>Nombre Producto</th><th>Descripción</th><th>Cantidad</th><th>Precio</th><th>Fecha Vencimiento</th><th>Nombre Cliente</th><th>Total</th></tr>";
echo "<tr>
        <td>" . htmlspecialchars($row_producto["codigo_producto"]) . "</td>
        <td>" . htmlspecialchars($row_producto["nombre_producto"]) . "</td>
        <td>" . htmlspecialchars($row_producto["descripccion"]) . "</td>
        <td>" . $cantidad_equitativa . "</td>
        <td>RD$" . number_format(floatval($row_producto["precio"]), 2, ',', '.') . "</td>
        <td>" . htmlspecialchars($row_producto["fecha_v"]) . "</td>
        <td>" . htmlspecialchars($nombre_cliente) . "</td>
        <td class='total'>RD$" . number_format($total, 2, ',', '.') . "</td>
      </tr>";
echo "</table>";
echo "<hr>";

                } else {
                    die("Error en la ejecución de la consulta: " . $stmt_insertar_factura->error);
                }
            } else {
                echo "La cantidad actual del producto es insuficiente, ya que solo hay ".htmlspecialchars($row_producto["cantidad"])." unidades disponibles.";
            }
        } else {
            echo "El producto con código " . htmlspecialchars($codigoproducto) . " no fue encontrado.";
        }
    } else {
        echo "No se ha seleccionado ningún producto.";
    }
}

$conectatealadba->close();
?>

