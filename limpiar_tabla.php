<?php
// Conexión a la base de datos
$conectar_a_la_dba = new mysqli("localhost", "root", "", "prueba_f");

// Verificar si se ha enviado una solicitud GET para limpiar las facturas
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Consulta SQL para limpiar la tabla de facturas
    $sql_limpiar_facturas = "TRUNCATE TABLE facturas_permanentes";

    // Ejecutar la consulta
    if ($conectar_a_la_dba->query($sql_limpiar_facturas) === TRUE) {
        // Redireccionar a la página principal después de limpiar las facturas
        header("Location: formulario.php");
        exit();
    } else {
        echo "Error al intentar limpiar las facturas: " . $conectar_a_la_dba->error;
    }
}
?>
