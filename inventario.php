<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

       
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #BFC9CA;
        }

        #volver {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        tr {
            background-color: #E5E8E8;
        }
        /* Estilos para los botones de editar y eliminar */
.editar-btn, .eliminar-btn {
    display: inline-block;
    padding: 6px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.eliminar-btn {
    background-color: #f44336;
    margin-left: 5px;
}

/* Estilos para los botones en estado hover */
.editar-btn:hover {
    background-color: green;
}
/* Estilos para los botones en estado hover */
.eliminar-btn:hover {
    background-color: red;
}

/* Estilos para los botones en estado activo */
.eliminar-btn:active {
    background-color: red;
}
/* Estilos para los botones en estado activo */
.editar-btn:active {
    background-color: #3e8e41;
}


        @media only screen and (max-width: 600px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 2px;
            }
        }
        div{
            overflow: auto scroll;
        }

        input,
    select {
        padding: 10px 15px;
        margin: 8px 5px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        max-width:15% ;
        width:15% ;

        }
        input[type="submit"]  
        {
            width:40%;
            background-color: #154360;
        color: white;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>
    <form method="post" enctype="multipart/form-data">
        <h2>Ingrese el nuevo Producto:</h2>
        <nav>
            <input type="number" name="codigo" placeholder="Código" required autocomplete="off">
            <input type="text" name="nombre_producto" placeholder="Nombre del producto" required autocomplete="off">
            <input type="text" name="descripcion" placeholder="Descripción" required autocomplete="off">
            <input type="number" name="cantidad" placeholder="Cantidad" required autocomplete="off">
            <input type="decimal" name="precio" placeholder="Precio" required autocomplete="off">
            <select name="categoria" id="categoria" required autocomplete="off">
                <option hidden disabled selected>Categorías</option>
                <option value="Electrónica">Electrónica</option>
                <option value="Estudio">Estudio</option>
                <option value="Higiene">Higiene</option>
                <option value="Comida">Comida</option>
                <option value="Ropa">Ropa</option>
            </select>
            <input type="date" name="fecha_v" placeholder="Fecha de vencimiento" required autocomplete="off">
        
        <input type="submit" value="Registrar">
    </form>
    <center></center>
    <br><br>
    <?php
$conn = new mysqli("localhost", "root", "", "prueba_f");

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $codigo = $_POST["codigo"];
    $nombre_producto = $_POST["nombre_producto"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $fecha_v = $_POST["fecha_v"];

    $sql = "INSERT INTO productos (codigo_producto, nombre_producto, descripccion, cantidad, precio, categoria, fecha_v)
            VALUES ('$codigo', '$nombre_producto', '$descripcion', '$cantidad', '$precio', '$categoria', '$fecha_v')";

    if ($conn->query($sql) === TRUE) {
        echo "<center>Producto registrado exitosamente!</center>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

    <?php
    $conn = new mysqli("localhost", "root", "", "prueba_f");

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lógica para registrar un nuevo producto...
    }

    $result = $conn->query("SELECT * FROM productos");

    if ($result->num_rows > 0) {
        echo "<div>";
        echo "<table border='1'>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Fecha de entrada</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $categoriaClass = 'categoria-' . strtolower(str_replace(' ', '-', $row['categoria']));

            echo "<tr>
                    <td>{$row['codigo_producto']}</td>
                    <td>{$row['nombre_producto']}</td>
                    <td>{$row['descripccion']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>{$row['precio']}</td>
                    <td class='$categoriaClass'>{$row['categoria']}</td>
                    <td>{$row['fecha_v']}</td>
                    <td><a href='editar.php?id={$row['id']}' class='editar-btn'>Editar</a></td>
                    <td><a href='eliminar.php?id={$row['id']}' class='eliminar-btn'>Eliminar</a></td>

                </tr>";
        }

        echo "</table></div>";
    } else {
        echo "No hay datos en el inventario.";
    }

    $conn->close();
    ?>
</body>
</html>
