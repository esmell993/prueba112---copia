<?php
$titulo = "Visión:";
$contenido = "
Visualizamos un futuro en el que la facturación sea un proceso ágil y transparente para todas las empresas, sin importar su tamaño o sector. Ofrecemos herramientas intuitivas y personalizadas que simplifican la gestión financiera.";
?>
<?php
$titulo2 = "Misión:";
$contenido2 = "
Nuestra misión es... Queremos ser reconocidos como el sitio tecnológico de confianza que impulsa la prosperidad económica a través de soluciones innovadoras y accesibles, permitiendo a nuestros usuarios enfocarse en lo que realmente importa: hacer crecer sus negocios. Ofreciéndoles un sistema de facturación inteligente y ágil que automatice tareas repetitivas, proporcione análisis detallados y garantice la seguridad de la información financiera.";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #D4E6F1;
        }

        .container {
            position: relative;
            max-width: 100%;
            margin: 20px 5%;
            padding: 20px;
            background-color: #f0f0f0;
            border: 2px solid #333;
            text-align: left;
        }

        .icon {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: 100px;
            background-image: url('vision.jpeg');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            float: left; 
            margin-right: 20px;
        }

        .hh {
            color: #FF0000;
            font-family: 'Times New Roman', serif;
            font-size: 40px;
            margin-top: 0;
        }

        p {
            color: #555;
            font-family: 'Verdana', sans-serif;
            font-size: 18px;
            line-height: 1.5;
        }

        .icon2 {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: 100px;
            background-image: url('mision.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            float: left; 
            margin-right: 20px; 
        }

        @media only screen and (max-width: 600px) {
            .container {
                margin: 20px 5%;
            }
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="icon2"></div>
        <h1 class="hh"><?php echo $titulo2; ?></h1>
        <p><?php echo $contenido2; ?></p>
    </div>
    <br>
    <div class="container">
        <div class="icon"></div>
        <h1 class="hh"><?php echo $titulo; ?></h1>
        <p><?php echo $contenido; ?></p>
    </div>
</body>

</html>
