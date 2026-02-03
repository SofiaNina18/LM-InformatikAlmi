<?php

$user = "InformatikAlmi";
$password = "Almi12345";
//$bbdd = "192.168.0.152/ORCLCDB"; //Conexión a BBDD Sofia
//$bbdd = "192.168.0.136/ORCLCDB"; //Conexión a BBDD Oier
$bbdd = "10.94.20.122/ORCLCDB"; //Conexión Sofia


$conexion = oci_connect($user, $password, $bbdd, 'AL32UTF8');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAYO</title>
    <meta name="description" content="página de informática, es una pagina informativa" />
    <meta name="keywords" content="informatica, sostenibilidad" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/menu.css" />
</head>

<body class="indice">
    <?php include 'menu.php'; ?>

    

    <footer>
        <div class="footer-interior">
            <a href="index.php" class="marca">SAYO</a>

            <nav>
                <a href="#">Sobre nosotros</a>
                <a href="#">Condiciones legales</a>
                <a href="#">Contacto</a>
            </nav>
        </div>
    </footer>

</body>

</html>