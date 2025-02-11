<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas</title>
    <style>
        body {
            background-color: #D7DBDD;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        section {
            max-width: 900px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .factura {
            border: 1px solid #ccc;
            border-radius: 0px;
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            width: calc(30% - 5px);
            box-sizing: border-box;
            transition: transform 0.3s ease-in-out;
            overflow: auto;
            max-height: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .factura:hover {
            transform: scale(1.02);
        }

        .factura h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .factura p {
            margin-bottom: 10px;
        }

        .factura ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .factura li {
            margin-bottom: 5px;
        }

        .imprimir-btn {
            background-color: #1F618D;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
            display: block;
            margin-top: 15px;
        }

        .imprimir-btn:hover {
            background-color: #3498DB;
        }
        img{
            max-height: 100px;
            margin-right: 0;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 10px 0;
        }
        .forma {
            background-color: #0993b5;
            color: #fff;
            display: flex;
            align-items: center;
            font-family: "Times New Roman", sans-serif;
           
        }
        .f {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            margin-left: auto;
            text-align: right;
        }

        .la {
            margin-right: 15px;
        }

        .aa {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 5px;
        }

        @media only screen and (max-width: 900px) {
            .factura {
                width: calc(45% - 20px);
                margin-right: 0;
            }
        }

        @media only screen and (max-width: 600px) {
            .factura {
                width: 90%;
                margin-right: 5%;
                margin-left: 5%;
            }
        }
    </style>
</head>
<body>
<nav class="forma">
        <ul class="f">
            <li class="la"><a class="aa" href="user.php">Inicio</a></li>
            <li><a class="aa" href="#" onclick="confirmarSalida()">Cerrar sesión</a></li>
        </ul>
    </nav>
    <section>
    <?php
$conectatealadba = new mysqli("localhost", "root", "", "proyecto_facturacion");

if ($conectatealadba->connect_error) {
    die("Conexión fallida: " . $conectatealadba->connect_error);
}

$sql_facturas = "SELECT nombre_cliente, GROUP_CONCAT(CONCAT(codigo_factura, ' - ', nombre_producto, ' - ', cantidad, ' - ', precio_unitario) SEPARATOR ', ') as detalle_facturas, SUM(subtotal) as total_compras
        FROM semi_factura
        GROUP BY nombre_cliente
        ORDER BY nombre_cliente";

$result_facturas = mysqli_query($conectatealadba, $sql_facturas);

if (!$result_facturas) {
    die("Error en la consulta de facturas: " . mysqli_error($conectatealadba));
}

// Verificar si hay facturas disponibles
if (mysqli_num_rows($result_facturas) > 0) {
    while ($row_factura = mysqli_fetch_assoc($result_facturas)) {
        echo "<div class='factura'>";
        echo "<h3>Cliente: " . $row_factura["nombre_cliente"] . "</h3>";
        echo "<p>Detalle de Facturas:</p>";
        echo "<ul>";

        $detalles_facturas = explode(", ", $row_factura["detalle_facturas"]);
        $subtotal_factura = 0;

        // detalle de factura
        foreach ($detalles_facturas as $detalle_factura) {
            list($codigo_factura, $nombre_producto, $cantidad, $precio_unitario) = explode(" - ", $detalle_factura);
            $subtotal_linea = $cantidad * $precio_unitario;
            $subtotal_factura += $subtotal_linea;
            echo "<br>";
            echo "<li>-Factura: $codigo_factura</li>";
            echo "<li>-Producto: $nombre_producto</li>";
            echo "<li>-Cantidad: $cantidad</li>";
            echo "<li>-Precio Unitario: RD$" . number_format(floatval($precio_unitario), 2, ',', '.') . "</li>";
            echo "<li>-Subtotal: RD$" . number_format($subtotal_linea, 2, ',', '.') . "</li>";
            echo "<hr>";
        }

        echo "</ul>";
        echo "<hr>";
        echo "<p>Total Compras: RD$" . number_format($row_factura["total_compras"], 2, ',', '.') . "</p>";
        echo "<a class='imprimir-btn' href='imprimir_factura.php?cliente=" . $row_factura["nombre_cliente"] . "'>Imprimir</a>";
        echo "<a class='imprimir-btn' href='editar_factura.php?cliente=" . $row_factura["nombre_cliente"] . "'>Editar Factura</a>";
        echo "</div>";
    }
} else {
    // Mensaje cuando no hay facturas
    echo "<div style='text-align: center; color: red; margin: 0 auto;'>";
    echo "<p>No hay facturas disponibles.</p>";
    echo "</div>";
    

}
?>

    </section>
    <script>
        window.onload = function () {
            window.scrollTo(0, document.body.scrollHeight);
        }

        function imprimirFacturas(nombreCliente) {
            alert("Imprimiendo facturas para el cliente: " + nombreCliente);
        }
        function eliminarFacturas(nombreCliente) {
            if (confirm("¿Seguro que desea eliminar las facturas para el cliente " + nombreCliente + "?")) {
                alert("Eliminando facturas para el cliente: " + nombreCliente);
            }
        }
        function confirmarSalida() {
            // Mostrar un mensaje de confirmación
            var respuesta = confirm("¿Estás seguro de que quieres salir de la página?");

            // Si el usuario hace clic en "Aceptar", redirigir a la página user.php
            if (respuesta) {
                window.location.href = 'index.php';
            }
        }
    </script>
    <?php
    $conectatealadba->close();
    ?>
</body>
</html>

