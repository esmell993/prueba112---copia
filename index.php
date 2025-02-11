<script>
        window.history.pushState(null, document.title, window.location.href);
        window.addEventListener('popstate', function(event) {
        window.history.pushState(null, document.title, window.location.href);
        });
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
  @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
}

body::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  background: url("randy.jpg"), #000;
  background-position: center;
  background-size: cover;
}

.wrapper {
  width: 400px;
  border-radius: 8px;
  padding: 30px;
  text-align: center;
  border: 1px solid #1F618D;
  background-color: #efefef;
  backdrop-filter: blur(9px);
  -webkit-backdrop-filter: blur(9px);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}

form {
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #001e44;
}

.input-field {
  position: relative;
  border-bottom: 2px solid #ccc;
  margin: 15px 0;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  color: #fff;
  font-size: 16px;
  pointer-events: none;
  transition: 0.15s ease;
  color: #2874A6;
}

.input-field input {
  width: 100%;
  height: 40px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
}

.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 0.8rem;
  top: 10px;
  transform: translateY(-120%);
}

.forget {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 25px 0 35px 0;
  color: #fff;
}

#remember {
  accent-color: #fff;
}

.forget label {
  display: flex;
  align-items: center;
}

.forget label p {
  margin-left: 8px;
}

.wrapper a {
  color: #efefef;
  text-decoration: none;
}

.wrapper a:hover {
  text-decoration: underline;
}

button {
  background:  #001e44;
  color: white;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  border-radius: 3px;
  font-size: 16px;
  border: 2px solid transparent;
  transition: 0.3s ease;
}

button:hover {
  color: #fff;
  border-color: #fff;
  background: #2874A6;
}

.register {
  text-align: center;
  margin-top: 30px;
  color: #fff;
}
img{
  width: 200px;
  height: auto;
}
    </style>

</head>
<body>
<div class="wrapper">
  <img src="logo.png" alt="logo">
    <form action="" method="post">
      <h2>Login...</h2>
        <div class="input-field">
        <input type="text" name="username" required autocomplete="off">
        <label>Ingresa el Usuario:</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" required autocomplete="off">
        <label>Ingresa tu Contraseña:</label>
      </div>
      <button type="submit">Iniciar</button>
      <?php
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

    </form>
  </div>
</body>
</html>