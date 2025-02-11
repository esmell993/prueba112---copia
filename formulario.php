<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas Permanentes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .invoice-frame {
            border: 1px solid #000;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-sizing: border-box;
            padding-bottom: 50px;
            width: 40%;
            flex-basis: calc(50% - 20px);
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

         th {
            background-color: #f2f2f2;
        }

         tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: black;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        
    </style>
</head>
<body>
<?php include('header.php'); ?>
    <h1>Facturas Realizadas:</h1>
    <div class='container'>
    <?php
    // Conexión a la base de datos
    $conectar_a_la_dba = new mysqli("localhost", "root", "", "prueba_f");

    // Consultar las facturas permanentes
    $sql_facturas = "SELECT DISTINCT factura_id FROM facturas_permanentes";

    $result_facturas = $conectar_a_la_dba->query($sql_facturas);

    if ($result_facturas->num_rows > 0) {
        while ($row = $result_facturas->fetch_assoc()) {
            $factura_id = $row["factura_id"];
            echo "<div class='invoice-frame'>";
            echo "<h2>Factura #" . $factura_id . "</h2>";
            $sql_productos = "SELECT nombre_producto, cantidad, subtotal, itbis, fecha FROM facturas_permanentes WHERE factura_id = $factura_id";
            $result_productos = $conectar_a_la_dba->query($sql_productos);
            if ($result_productos->num_rows > 0) {
                echo "<table class='invoice'>";
                echo "<tr><th>Producto</th><th>Cantidad</th><th>Subtotal</th><th>ITBIS</th><th>Fecha</th></tr>";
                $total_subtotal = 0;
                $total_itbis = 0;
                while ($producto = $result_productos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $producto["nombre_producto"] . "</td>";
                    echo "<td>" . $producto["cantidad"] . "</td>";
                    echo "<td>" . $producto["subtotal"] . "</td>";
                    echo "<td>" . $producto["itbis"] . "</td>";
                    if (!isset($fecha_factura)) {
                        $fecha_factura = $producto["fecha"];
                    }
                    echo "<td>" . $producto["fecha"] . "</td>";
                    echo "</tr>";
                    $total_subtotal += $producto["subtotal"];
                    $total_itbis += $producto["itbis"];
                }
                echo "</table>";
                echo "<p>Total Subtotal: " . $total_subtotal . "</p>";
                echo "<p>Total ITBIS: " . $total_itbis . "</p>";
            } else {
                echo "<p>No hay productos registrados para esta factura.</p>";
            }
            echo "</div>"; // Cierre de invoice-frame
        }
    } else {
        echo "<p>No hay facturas registradas.</p>";
    }
    ?>
    </div>
    <a href="limpiar_tabla.php" class="btn" onclick="return confirmarLimpiar()">Eliminar Facturas</a>

    <script>
        function confirmarLimpiar() {
            return confirm("¿Está seguro de que desea limpiar la tabla de facturas? Esta acción no se puede deshacer.");
        }
    </script>
</body>
</html>
