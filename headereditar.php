<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: "Times New Roman", sans-serif;
        }

        header {
            background-color: #001e44;
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column; 
            align-items: center;
        }

        header h1 {
            margin: 10px 0;
        }

        header img {
            max-height: 80px;
            margin-right: 0;
        }

        .forma {
            background-color: #0993b5;
            color: #fff;
            display: flex;
            align-items: center;
           
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
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
        }

        @media screen and (min-width: 600px) {
            header {
                flex-direction: row;
                justify-content: space-between;
            }

            header h1 {
                margin: 0;
            }

            header img {
                max-height: 100px;
                margin-right: 20px;

            }
            .f {
                display: flex;
                margin-right: 0;
                text-align: center;
            }
            .tem{
            margin-right:10px;    
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo de la empresa"> 
        <h1 class="tem"> Edictar Producto</h1>
    </header>

    <nav class="forma">
        <ul class="f">
        <li class="la"><a class="aa" href="inventario.php">Inventario</a></li>
            <li class="la"><a class="aa" href="admin.php">Inicio</a></li>
            <li><a class="aa" href="#" onclick="confirmarSalida()">Cerrar sesión</a></li>
        </ul>
    </nav>
    <script>
         function confirmarSalida() {
            var respuesta = confirm("¿Estás seguro de que quieres salir de la página?");
            if (respuesta) {
                window.location.href = 'index.php';
            }
        }
    </script>
</body>
</html>
