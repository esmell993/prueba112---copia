<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #D5DBDB;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    form {
        max-width: 500px;
        width: 90%;
        background-color: #fff;
        padding: 10px;
        border: 1px solid gray;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        margin-top: 25px;
    }

    nav {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        text-align: center;
        font-size: 14px;
        color: #5D6D7E;
    }

    input,
    select {
        padding: 10px 15px;
        margin: 8px 5px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        max-width:85% ;
        width:85% ;
    }
    div {
        width: calc(50% - 10px); 
    }

    select {
        appearance: none;
        padding: 10px;
        width: 85%;
    }

    input[type="submit"] {
        background-color: #154360;
        color: white;
        border: none;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        width: 85%;
        margin-top: 23px;
    }

    input[type="submit"]:hover {
        background-color: #2471A3;
    }

    a {
        text-align: center;
        margin-top: 15px;
        text-decoration: none;
    }
    h2{
        color: #1F618D;
    }
</style>
</head>
<body>
<?php include('header.php'); ?>
<center>
    <form action="usuario.php" method="post">
        <h2>Formulario de usuario</h2>
        <nav>
            <div>
        <label for="nombre">Nombre*</label>
        <input type="text" name="nombre" required autocomplete="off">
        </div>
        <div>
        <label for="apellidos">Apellidos*</label>
        <input type="text" name="apellidos" required autocomplete="off">
        </div>
        </nav>
        <nav>
            <div>
        <label for="correo">Correo*</label>
        <input type="text" name="correo" required autocomplete="off">
        </div>
        <div>
        <label for="password">Contraseña*</label>
        <input type="password" name="password" required autocomplete="off">
        </div>
        </nav>
        <nav>
        <div>
        <label for="tipo_usuario">Tipo de Usuario*</label>
        <select name="tipo_usuario" required>
        <option value="USUARIO">Usuario (Normal)</option>
            <option value="ADMIN">Administrador</option>
        </select>
        </div>
        <div>
        <label for="numero_tel">Número de Teléfono*</label>
        <input type="text" name="numero_tel" required autocomplete="off">
        </div>
        </nav>
        <nav>
        <div>
        <label for="direccion">Dirección*</label>
        <input type="text" name="direccion" required autocomplete="off">
        </div>
        <div>
            <label for="registrar">    </label>
        <input type="submit" value="Registrar">
        </div>
        </nav>
        </form>
        </center>


    <?php
    if ($_POST) {
        $conn = new mysqli("localhost", "root", "", "proyecto_facturacion");
        $usuario = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $correo = $_POST["correo"];
        $password = $_POST["password"];
        $tipo_usuario = $_POST["tipo_usuario"];
        $numero_tel = $_POST["numero_tel"];
        $direccion = $_POST["direccion"];
       
        $sql = "INSERT INTO usuarios (nombre, apellidos, correo, contraseña, tipo_user, numero_tel, direccion) VALUES ('$usuario', '$apellidos', '$correo', '$password', '$tipo_usuario', '$numero_tel', '$direccion')";

        if ($conn->query($sql) === TRUE) {
            echo "<center>Datos guardados correctamente.</center>";
        } else {
            echo "<center>Error al guardar datos: " . $conn->error."</center>";
        }
    }
    ?>
    <br><br><br><br>
</body>
</html>
