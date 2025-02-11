<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="number" name="input_codigo" id="" required>
        <input type="number" name="input_cantidad" id="" required>
        <input type="submit" value="Agregar">
    </form>
    <?php
    // CONECTAR A LA BASE DE DATOS //
        $conectar_a_la_dba = new mysqli("localhost", "root", "", "basededatos");
    // FIN CONECTAR A LA BASE DE DATOS //
        if ($_POST)
        {
            $variable_codigo = $_POST['input_codigo'];
            $variable_cantidad = $_POST['input_cantidad'];
    
            $instruccion_sql = "SELECT * FROM tablaproductos WHERE codigo_producto = '$variable_codigo'";// CONSULTAR EXISTENCIA DEL PRODUCTO //
            $ejecutarconsulta =  $conectar_a_la_dba->query($instruccion_sql);
            if ($ejecutarconsulta->num_rows > 0) 
            {
                // asociar el valor de la fila correspondiente//
                $filaProducto = $ejecutarconsulta->fetch_assoc();
                // asignar el valor de la tabla productos a las variables correspondientes//
                $nombreProducto = $filaProducto['nombre_producto'];
                $precioProducto = $filaProducto['precio_producto'];
    
                
                // calcular sub-total de cada producto//
                $subtotal_cadaproducto = $precioProducto * $variable_cantidad;

                // INSERTAR DATOS //
                    $instruccion_sql = "INSERT INTO factura_rapida (frnombre_producto, frcantidad_producto, frsubtotal_producto) VALUES ('$nombreProducto', '$variable_cantidad', '$subtotal_cadaproducto')";
                    if ($conectar_a_la_dba->query($instruccion_sql) === TRUE) 
                    {
                        //evitar autoinsercion al darle al submit//
                        header("Location: " . "?timestamp=" . time());
                        exit();
                    } 
                    else 
                    {
                        echo "Error al guardar datos: " . $conectar_a_la_dba->error;
                    }
            // FIN DE INSERTAR DATOS //
            } 
            else 
            {
                echo "El producto con código $variable_codigo no existe en la base de datos.";
            }
        }
    ?>
    <div>
        <?php
           // Consulta SQL para sumar la columna 'precio_producto'//
            $sqlsumatotal = "SELECT SUM(frsubtotal_producto) AS suma_total FROM factura_rapida";
            
            // Ejecutar la consulta //
            $result = $conectar_a_la_dba->query($sqlsumatotal);
            
            // Verificar si la consulta se ejecutó correctamente //
            if ($result === false) {
                echo "Error al ejecutar la consulta: " . $conectar_a_la_dba->error;
            } else {
                // Obtener el resultado de la suma
                $row = $result->fetch_assoc();
                $suma_total = $row['suma_total'];
                $itbis = $suma_total * 0.18;
                $totalapagar = $suma_total + $itbis;
            
                // Mostrar el resultado
                echo "<br>";
                echo "El sutotal general es: $suma_total";
                echo "<br>";
                echo "ITBIS: $itbis";
                echo "<br>";
                echo "Total a pagar $totalapagar";
            }
        ?>
    </div>
    
    <h3>Productos a vender</h3>
    <div>
    <?php
            $sqlb = "SELECT id, frnombre_producto, frcantidad_producto, frsubtotal_producto FROM factura_rapida";
            $result = mysqli_query($conectar_a_la_dba, $sqlb);
        
            while ($row = mysqli_fetch_assoc($result)) {
            echo " Producto: " . $row["frnombre_producto"] ." |"."|  Cantidad: " . $row["frcantidad_producto"] ." |". "| Monto: " . $row["frsubtotal_producto"] .  "<br>";
                echo "<hr>";
            }
        
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conectar_a_la_dba));
            }
        ?>
    </div>
</body>
</html>