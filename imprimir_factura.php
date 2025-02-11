<?php
date_default_timezone_set('America/La_Paz');
session_start();

$conectatealadba = new mysqli("localhost", "root", "", "proyecto_facturacion");

if ($conectatealadba->connect_error) {
    die("Conexión fallida: " . $conectatealadba->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["cliente"])) {
    $nombre_cliente = $_GET["cliente"];

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión de Facturas</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #808B96;
            margin: 0;
            padding: 0;
        }

        .contenedor-factura {
            margin: 20px auto;
            max-width: 600px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: white;
        }

        .tienda-info {
            text-align: right;
            background-color: #EBF5FB;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease;
        }

        .tienda-info p {
            color: #333;
            font-weight: bold;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            margin: 8px 0;
        }

        .tienda-info p:hover {
            color: #e44d26;
            cursor: pointer;
        }
        h3 {
            color: #333;
        }

        p {
            font-weight: bold;
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        hr {
            border: 1px solid #ccc;
        }

        .imprimir-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-family: 'Arial', sans-serif;
        }

        .imprimir-btn:hover {
            background-color: #45a049;
        }

        .imagen-container {
            text-align: right;
        }

        img {
            max-width: 150px;
            height: auto;
        }
        .factura{
            font-family: Courier New;
        }
        .imghh{
            max-width: 150px;
            height: auto; 
            text-align: left;
        }

        @media screen and (max-width: 600px) {
            .tienda-info {
                text-align: center;
            }
            img{
                width: 40%;
            }
        }
    </style>
</head>

<body>

    <div class='contenedor-factura'>
        <div class='tienda-info'>
            <p>Invoice Master</p>
            <p>6toAinformatica@gmail.com</p>
            <p>La Cuaba</p>
            <p>809-639-8420</p>
            <?php $hora= date("Y-m-d H:i:s");
            echo "<h4>";
            echo "Fecha: ". $hora;
            echo "</h4>";?>
        </div>
        <br>
        <section class='factura'>
            <h3>Cliente: <?php echo $nombre_cliente; ?></h3>
            <p>Detalle de Facturas:</p>
            <ul>
                <?php
                $total_subtotales = 0;
                while ($row_factura_cliente = $result_facturas_cliente->fetch_assoc()) {
                    echo "<li>Factura:| " . $row_factura_cliente["codigo_factura"] . "<br>";
                    echo "Producto:| " . $row_factura_cliente["nombre_producto"] . "<br>";
                    echo "Cantidad:| " . $row_factura_cliente["cantidad"] . "<br>";
                    echo "Precio Unitario:| RD$" . number_format($row_factura_cliente["precio_unitario"], 2, ',', '.') . "<br>";
                    echo "Subtotal:| RD$" . number_format($row_factura_cliente["subtotal"], 2, ',', '.') . "</li>";
                    echo "<hr>";
                    $total_subtotales += $row_factura_cliente["subtotal"];
                }
                ?>
            </ul>
            <p>Total de Subtotales: RD$<?php echo number_format($total_subtotales, 2, ',', '.'); ?></p>
            <button class='imprimir-btn' onclick='imprimirFacturas()'>Imprimir</button>
            <div class="imagen-container">
                <a href="#" onclick="confirmarSalida()">
                    <img src="logo.png" alt="imagen">
                    </a>
                </div>
        </section>
    </div>

    <script>
            function imprimirFacturas() {
        if (confirm('¿Desea imprimir la factura?')) {
            window.print();
            eliminarDatosFactura();
        }
    }
        function eliminarDatosFactura() {
            <?php
            $result_facturas_cliente->data_seek(0);

            while ($row_factura_cliente = $result_facturas_cliente->fetch_assoc()) {
                $codigo_factura = $row_factura_cliente["codigo_factura"];
                $sql_eliminar_factura = "DELETE FROM semi_factura WHERE codigo_factura = ?";
                $stmt_eliminar_factura = $conectatealadba->prepare($sql_eliminar_factura);
                $stmt_eliminar_factura->bind_param("s", $codigo_factura);
                $stmt_eliminar_factura->execute();
            }
            ?>
        }
        function confirmarSalida() {
            // Mostrar un mensaje de confirmación
            var respuesta = confirm("¿Estás seguro de que quieres ir a la facturar?");

            // Si el usuario hace clic en "Aceptar", redirigir a la página user.php
            if (respuesta) {
                window.location.href = 'user.php';
            }
        }
    </script>
</body>

</html>

<?php
} else {
    echo "Parámetros incorrectos.";
}

$stmt_facturas_cliente->close();
$conectatealadba->close();
?>
