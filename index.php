<?php

$user = "InformatikAlmi";
$password = "Almi12345";
$bbdd = "192.168.0.152/ORCLCDB"; //Conexión a BBDD Sofia
//$bbdd = "192.168.0.136/ORCLCDB"; //Conexión a BBDD Oier


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
</head>

<body class ="indice">
    <header>    <!--encabezado-->
        <a href="index.php"> <img src="images/logo.png" id="logo" alt="Logo de la web" /> </a>
        <nav>
            <ul>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Tecnología</a></li>
                <li><a href="#">Proyectos</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Proveedores</a></li>
            </ul>
        </nav>
    </header>

    <section class="inicio">
        <section class="titulo-principal">
            <video autoplay muted loop class="video-background">
                <source src="videos/video.mp4" type="video/mp4">
                Tu navegador no soporta el video.
            </video>
            <div class="contenido-titulo">
                <h1>Bienvenido a SAYO</h1>
                <p>Desarrollamos software y aplicaciones a medida para empresas y particulares.</p>
            </div>
        </section>

        <section class="sistema" id="inicio">
            <div class="contenido">
                <?php if ($conexion): ?>
                    <p style="color: green;">● Sistema Conectado a Oracle</p>
                <?php else: ?>
                    <p style="color: red;">○ Sin conexión</p>
                <?php endif; ?>

                <h1>Potencia tu hardware, protege el <span>Planeta</span>.</h1>
                <p>InformatikAlmi es la plataforma líder en configuración de equipos con componentes suministrados bajo criterios de sostenibilidad ASG y economía circular.</p>
                <a href="#" class="boton">Portal de Proveedores</a>
            </div>
           
        </section>
    </section>        
    </main>

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

