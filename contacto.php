<?php

$user = "InformatikAlmi";
$password = "Almi12345";
$bbdd = "192.168.0.152/ORCLCDB"; //Conexión a BBDD Sofia
//$bbdd = "192.168.0.136/ORCLCDB"; //Conexión a BBDD Oier
//$bbdd = "10.94.20.122/ORCLCDB"; //Conexión Sofia


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
    <link rel="stylesheet" href="css/contacto.css">
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>

<body class="indice">
    <?php include 'menu.php'; ?>
    
    <div class="top">
        <h1>Ponte en <b>Contacto</b></h1>
        <p>Estamos listos para llevar a tu empresa al siguiente nivel.</p>
        <p>¡Hablemos! Estaremos encantados de resolver tus dudas.</p>
    </div>
    <div class="center">
        <div class="mensaje">
            <h2>Envíanos un Mensaje</h2>
            <form action="" method="post">
                <div class="form">
                    <div class="line">
                        <div>
                            <label for="nombre">Nombre Completo</label>
                            <input id="nombre" name="nombre" type="text" placeholder="Nombre y Apellido">
                        </div>
                        <div>
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" id="correo" placeholder="tu@correo.com">
                        </div>
                    </div>
                    <div>
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto">
                    </div>
                    <div>
                        <label for="mensaje">Mensaje</label>
                        <textarea name="mensaje" id="mensaje" cols="30" rows="6" placeholder="Cuentanos los detalles"></textarea>
                    </div>
                </div>
                
                <button type="button">Enviar Solicitud</button>
            </form>
        </div>
        <div class="info">
            <div>
                <h2>Información</h2>
                <hr>
                <div>
                    <!--img-->
                    <div>
                        <h3>Oficina Central</h3>
                        <p>Agirre Lehendakariaren Etorb., 29, piso 1, Deusto</p>
                    </div>
                </div>
                <div>
                    <!--img-->
                    <div>
                        <h3>Llámanos</h3>
                        <p>+34 692 78 45 67</p>
                    </div>
                </div>
                <div>
                    <!--img-->
                    <div>
                        <h3>Email</h3>
                        <p>sayoalmi4@gamil.com</p>
                    </div>
                </div>
                <hr>
                <div>
                    <!--img-->
                    <!--img-->
                    <!--img-->
                </div>

            </div>
            <!--google maps frame-->
        </div>
    </div>
    


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