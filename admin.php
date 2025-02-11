<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <style>
        body {
            font-family: "Times New Roman", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #EAEDED;
            position: fixed;
            width: 100VW;
            height: 100%;
        }

     

        section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px;
        }
        header {
            background-color: #001e44;
            color: #fff;
            padding: 15px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }
        header h1 {
            margin: 0;
        }

        header img {
            max-height: 100px;
            margin-right: 10px;
        }
        nav {
            background-color: #0993b5;
            color: #fff;
           
            width: 300;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;

        }
        ul{
            text-align: right;
        }

        a{
            text-decoration: none;
        }
        .feature {
            width: 100%; 
             margin: 0 auto;
            max-width: 200px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50%;
        }
        footer {
            background-color: #001e44;
            color: #fff;
            padding: 15px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .feature:hover {
            transform: scale(1.05);
        }

        .feature img {
            max-width: 300px;
            max-height: 100px;
            margin-bottom: 10px;
        }

        .color2 {color: #0b3048;}

        @media only screen and (max-width: 700px) {
    section {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .feature {
        max-width: 200px;
        margin-top:7px;
        margin-right: 10px;
    }
}
.feature.usuario a,
.feature.producto a,
.feature.inv a {
    color: black;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
}

.feature.usuario a:hover,
.feature.producto a:hover,
.feature.inv a:hover {
    color: blue;
}
    </style>
</head>
<body>
<header>
        <img src="logo.png" alt="Logo de la empresa">
        <h1>Panel de Administrador</h1>
    </header>
    <nav>
        <ul>
            <li><a href="login.php"></a></li>
            <li><a href="vicion_m.php">Misión y Vición</a></li>
            <li><a href="historia.php">Historia</a></li>
            <li><a href="#" onclick="confirmarSalida()" >Cerrar Seción</a></li>
        </ul>
    </nav>
    <section>
    <a href="usuario.php">
        <div class="feature usuario color2">
            <img src="ss1.png" alt="icono1">
           <p>USUARIO</p>
        </div>
        </a>
        <a href="formulario.php">
        <div class="feature producto color2">
            <img src="ss2.jfif" alt="icono2">
            <p>REGISTRO FT</p>
        </div>
        </a>
        <a href="inventario.php">
        <div class="feature inv color2">
            <img src="ss3.png" alt="icono3">
            <p>INVENTARIO</p>
        </div>
        </a>
        <a href="admin_facturar.php">
        <div class="feature inv color2">
            <img src="ss4.png" alt="icono4">
            <p>FACTURAR</p>
        </div>
        </a>
    </section>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> INVOICE MASTER</p>
    </footer>
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