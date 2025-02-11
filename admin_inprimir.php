<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$usuario_atendio = $_SESSION['username'];
?>
<?php
// Conexión a la base de datos
$conectar_a_la_dba = new mysqli("localhost", "root", "", "prueba_f");

if ($conectar_a_la_dba->connect_error) {
    die("Error de conexión a la base de datos: " . $conectar_a_la_dba->connect_error);
}

// Resto del código aquí ...

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Mercado</title>
    <style>
        body {
            font-family: Courier New, monospace;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 200px;
        }

        .info p {
            margin: 5px 0;
        }

        .info p b {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 20px;
            float: right;
        }

        .total p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            clear: both;
        }

        .footer p {
            margin: 5px 0;
        }
        .btn-imprimir{
    background-color: #154360;
    color: white;
    height: 30px;
    border-radius:20px;
}
    </style>
</head>
<body>
    <div class="container" id="factura-container">
        <div class="header">
            <img src="logo.png" alt="Logo de la Empresa">
            <h1>Factura </h1>
        </div>
        <div class="info">
            <p><b>Fecha:</b> <?php echo date("d/m/Y"); ?></p>
            <p><b>Usuario (Cajero/a):</b> <?php echo $usuario_atendio; ?></p>
            <p><b>Datos de la Empresa:</b></p>
            <p><b>Nombre:</b> Invioce Master</p>
            <p><b>Dirección:</b> Calle Principal, la cuaba.</p>
            <p><b>Teléfono:</b> 829-686-6494</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar los productos asociados al último factura_id
                $sql_productos_factura = "SELECT nombre_producto, cantidad, subtotal FROM facturas_permanentes WHERE factura_id = (SELECT MAX(factura_id) FROM facturas_permanentes)";
                $result_productos_factura = mysqli_query($conectar_a_la_dba, $sql_productos_factura);
                if (!$result_productos_factura) {
                    die("Error en la consulta de productos: " . mysqli_error($conectar_a_la_dba));
                }
                while ($row = mysqli_fetch_assoc($result_productos_factura)) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre_producto"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>$" . number_format($row["subtotal"], 2) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="total">
            <?php
            // Consultar el subtotal, ITBIS y total de la última factura
            $sql_suma_total = "SELECT SUM(subtotal) AS suma_total, SUM(itbis) AS suma_itbis FROM facturas_permanentes WHERE factura_id = (SELECT MAX(factura_id) FROM facturas_permanentes)";
            $result_suma_total = $conectar_a_la_dba->query($sql_suma_total);
            if ($result_suma_total === false) {
                echo "Error al ejecutar la consulta: " . $conectar_a_la_dba->error;
            } else {
                $row_total = $result_suma_total->fetch_assoc();
                $suma_total = $row_total['suma_total'];
                $itbis_total = $row_total['suma_itbis'];
                $totalapagar = $suma_total + $itbis_total;
                echo "<p><b>Subtotal:</b> $" . number_format($suma_total, 2) . "</p>";
                echo "<p><b>ITBIS:</b> $" . number_format($itbis_total, 2) . "</p>";
                echo "<p><b>Total a pagar:</b> $" . number_format($totalapagar, 2) . "</p>";
            }
            ?>
        </div>
        <div class="footer">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
<button class="btn-imprimir" onclick="imprimirFactura()">Imprimir Factura</button>
<script>
    function imprimirFactura() {
        // Obtener el contenedor de la factura
        const facturaContainer = document.getElementById('factura-container');

        // Ocultar el botón de imprimir
        document.querySelector('.btn-imprimir').style.display = 'none';

        // Configurar opciones para el PDF
        const options = {
            filename: 'factura.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 3 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        // Capturar solo el contenedor de la factura
        html2pdf().from(facturaContainer).set(options).toPdf().get('pdf').then(function(pdf) {
            // Mostrar la factura en una nueva ventana o pestaña del navegador
            const pdfData = pdf.output('blob');
            const blobURL = URL.createObjectURL(pdfData);
            const newWindow = window.open(blobURL, '_blank');

            // Redireccionar a admin_facturar.php después de que se abra el PDF en una nueva ventana
            newWindow.onload = function() {
                window.location.href = 'admin_facturar.php';
            };

            // Mostrar el botón de imprimir nuevamente después de 1 segundo
            setTimeout(function() {
                document.querySelector('.btn-imprimir').style.display = 'block';
            }, 1000);
        });
    }
</script>

</body>
</html>
