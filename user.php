

<style>
           body {
            background-color: #D7DBDD ; 
            background-size: cover; 
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            background-attachment: fixed;
            align-items: center;
            justify-content: center; 
        }
        .cua1{
            width: 80%;
            border: #001e44 solid 1px;
            background-color: #fff;
            margin-top: 2%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .cua2{
            width: 80%;
            border: #001e44 solid 1px;
            background-color: #fff;
            margin-top: 2%;
            height: 370px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        input[type="button"] {
            background-color: #001e44;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="button"]:hover {
            background-color: #2980B9;
        }

        h3 {
            text-align: center;
            color: #333;
        }

        .fact {
            max-width: 980px;
            border: 2px solid #333;
            border-radius: 5px;
            padding: 10px;
            max-height: 200px;
            overflow:auto scroll;
            background-color: #F8F9F9;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        input[type="text"],input[type="number"] {
            width: 25%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        input[type="button"][value="Comprar"] {
            margin: 20px auto;
            display: block;
            background-color: #001e44;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="button"][value="Comprar"]:hover {
            background-color: #2980B9;
        }
        div{
            width: 80%;
        }

    .total-value {
        font-weight: bold;
    }
    .text{
        color: #4caf50;
        background-color: #ccc;
    }
    nav {
     display: flex;
     align-items: center;
     justify-content: space-between;
    }
    .cerrar{
        margin-left: 50px;
            display: block;
            background-color: #001e44;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 5px;
    }
    .botones{
        display: flex;
    }
    a{
        text-decoration: none;
    }
@media only screen and (max-width: 768px)  {
    input[type="text"],input[type="number"] {
            width: 150px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
    .cua1{
        max-width: 800px;
    }
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #406E8E;
    color:#D7DBDD;
}

/* CSS DE LA TABLA */
tr:first-child {
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

td:nth-child(4) {
    text-align: right;
}
article{
    margin: 10px;

}
.boton{
    background-color: #154360;
    color: white;
    height: 30px;
    border-radius:20px;
}
    </style>

 <?php
$conectar_a_la_dba = new mysqli("localhost", "root", "", "prueba_f");

if ($_POST) {
    $variable_codigo = $_POST['input_codigo'];
    $variable_cantidad = $_POST['input_cantidad'];

    // Consultar la cantidad disponible del producto en la base de datos
    $consulta_cantidad_disponible = "SELECT cantidad FROM productos WHERE codigo_producto = '$variable_codigo'";
    $resultado_cantidad_disponible = $conectar_a_la_dba->query($consulta_cantidad_disponible);

    if ($resultado_cantidad_disponible->num_rows > 0) {
        $filaProducto = $resultado_cantidad_disponible->fetch_assoc();
        $cantidad_disponible = $filaProducto['cantidad'];

        // Verificar si hay suficientes unidades disponible
        if ($cantidad_disponible >= $variable_cantidad) {
            // Restar la cantidad vendida del stock disponible
            $nueva_cantidad = $cantidad_disponible - $variable_cantidad;
            $actualizar_stock = "UPDATE productos SET cantidad = '$nueva_cantidad' WHERE codigo_producto = '$variable_codigo'";
            $conectar_a_la_dba->query($actualizar_stock);

            // Continuar con el proceso de facturación
            $instruccion_sql = "SELECT * FROM productos WHERE codigo_producto = '$variable_codigo'";
            $ejecutarconsulta =  $conectar_a_la_dba->query($instruccion_sql);

            if ($ejecutarconsulta->num_rows > 0) {
                $filaProducto = $ejecutarconsulta->fetch_assoc();
                $nombreProducto = $filaProducto['nombre_producto'];
                $precioProducto = $filaProducto['precio'];

                // Calcular el subtotal de la compra y el ITBIS
                $subtotal_cadaproducto = $precioProducto * $variable_cantidad;
                $itbis = $subtotal_cadaproducto * 0.18;

                $instruccion_sql = "INSERT INTO factura_rapida (nombre_producto, cantidad, subtotal, itbis, factura_id) 
                                    VALUES ('$nombreProducto', '$variable_cantidad', '$subtotal_cadaproducto', '$itbis', 1)";
                
                if ($conectar_a_la_dba->query($instruccion_sql) === TRUE) {
                    // Redirigir para evitar la reenviación del formulario
                    header("Location: " . "?timestamp=" . time());
                    exit();
                } else {
                    echo "Error al guardar datos: " . $conectar_a_la_dba->error;
                }
            } else {
                echo "El producto con código $variable_codigo no existe en la base de datos.";
            }
        } else {
            $cantidad_restante = $cantidad_disponible;
            echo "Error: No hay suficientes unidades disponible. Quedan $cantidad_restante unidades del producto.";
        }
    } else {
        echo "El producto con código $variable_codigo no existe en la base de datos.";
    }
}
?>

<?php
// Verificar si se ha enviado una solicitud GET para realizar la facturación
if ($_GET && isset($_GET['facturar'])) {
    // Generar un nuevo factura_id único
    $sql_obtener_max_id = "SELECT MAX(factura_id) AS max_id FROM facturas_permanentes";
    $result_max_id = $conectar_a_la_dba->query($sql_obtener_max_id);
    $row_max_id = $result_max_id->fetch_assoc();
    $nuevo_factura_id = $row_max_id['max_id'] + 1;

    // Insertar los datos de la factura rápida en la tabla facturas_permanentes
    $sql_insertar_factura = "INSERT INTO facturas_permanentes (factura_id, nombre_producto, cantidad, subtotal, itbis) 
                             SELECT ?, nombre_producto, cantidad, subtotal, itbis 
                             FROM factura_rapida";
    
    // Preparar la consulta
    $stmt_insertar_factura = $conectar_a_la_dba->prepare($sql_insertar_factura);

    // Vincular parámetros
    $stmt_insertar_factura->bind_param("i", $nuevo_factura_id);

    // Ejecutar la consulta
    if ($stmt_insertar_factura->execute() === TRUE) {
        echo "La facturación se ha guardado correctamente.";
    } else {
        echo "Error al guardar la facturación: " . $stmt_insertar_factura->error;
    }

    // Cerrar la consulta preparada
    $stmt_insertar_factura->close();

    // Limpiar la tabla factura_rapida
    $sql_limpiar_tabla = "TRUNCATE TABLE factura_rapida";
    if ($conectar_a_la_dba->query($sql_limpiar_tabla) === TRUE) {
        header("Location: admin_inprimir.php");
        exit();
    } else {
        echo "Error al limpiar la tabla: " . $conectar_a_la_dba->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
</head>
<body>
<?php include('headeruser.php'); ?>
<article>
    <form method="post">
        <input type="number" name="input_codigo" id="" required autocomplete="off">
        <input type="number" name="input_cantidad" id="" required autocomplete="off">
        <input type="submit" value="Agregar" class="boton">
    </form>
    
    <section>
            <!-- Mostrar productos a vender -->
            <h3>Productos a vender</h3>
        <div>
        <?php
    // Consultar los productos en la tabla factura_rapida
    $sqlb = "SELECT nombre_producto, cantidad, subtotal FROM factura_rapida";
    $result = mysqli_query($conectar_a_la_dba, $sqlb);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr><th>Producto</th><th>Cantidad</th><th>Subtotal</th></tr>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row["nombre_producto"] . '</td>';
            echo '<td>' . $row["cantidad"] . '</td>';
            echo '<td>' . "RD$" . number_format($row["subtotal"], 2) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p>No hay productos registrados.</p>';
    }

    // Liberar el conjunto de resultados
    mysqli_free_result($result);
?>
        <div>
            <?php
            // Consultar el subtotal, ITBIS y total de la factura
            $sqlsumatotal = "SELECT SUM(subtotal) AS suma_total FROM factura_rapida";
            $result = $conectar_a_la_dba->query($sqlsumatotal);
            if ($result === false) {
                echo "Error al ejecutar la consulta: " . $conectar_a_la_dba->error;
            } else {
                $row = $result->fetch_assoc();
                $suma_total = $row['suma_total'];
                $sqlsumaitbis = "SELECT SUM(itbis) AS suma_itbis FROM factura_rapida";
                $result_itbis = $conectar_a_la_dba->query($sqlsumaitbis);
                $row_itbis = $result_itbis->fetch_assoc();
                $itbis_total = $row_itbis['suma_itbis'];
                $totalapagar = $suma_total + $itbis_total;
                echo "<br>";
             echo "El subtotal general es: RD$ " . number_format($suma_total, 2);
echo "<br>";
echo "ITBIS Total: " . number_format($itbis_total, 2);
echo "<br>";
echo "Total a pagar: RD$ " . number_format($totalapagar, 2);

            }
            ?>
            <form method="get">
                <input type="submit" name="facturar" value="Facturar"class="boton">
            </form>
        </div>

        </div>
    </section>
    </article>
</body>
</html>
