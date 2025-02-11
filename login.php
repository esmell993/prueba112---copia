<?php
include "index.html";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE nombre = ? AND contraseña = ?";
    $conn = new mysqli("localhost", "root", "", "prueba_f");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tipo_usuario = $row['tipo_user'];

        $_SESSION['username'] = $username;
        $_SESSION['tipo_user'] = $tipo_usuario;

        if (strtoupper($tipo_usuario) == 'ADMIN') {
            header("Location: admin.php");
            exit();
        } else {
            header("Location: user.php");
            exit();
        }
    } else {
        echo "<p style='color: red;'>Autenticación fallida. Inténtalo de nuevo.</p>";
    }

    $stmt->close();
}
?>