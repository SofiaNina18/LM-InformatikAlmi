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
    <link rel="stylesheet" href="css/menu.css" />
</head>

<body class="indice">
    <?php include 'menu.php'; ?>

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
            <div class="contenido-encendido">
                <?php if ($conexion): ?>
                    <p style="color: green;">● Sistema Conectado a Oracle</p>
                <?php else: ?>
                    <p style="color: red;">○ Sin conexión</p>
                <?php endif; ?>

                <h1>Potencia tu hardware, protege el <span>Planeta</span>.</h1>
                <p>InformatikAlmi es la plataforma líder en configuración de equipos con componentes suministrados bajo
                    criterios de sostenibilidad ASG y economía circular.</p>
                <a href="#" class="boton">Portal de Proveedores</a>
            </div>

        </section>
        <section class="primera">
            <div class="foto">
                <img src="images/foto3.png" alt="Hardware de alto rendimiento de SAYO">
            </div>

            <div class="texto">
                <h2>Rendimiento <br> a plena capacidad</h2>

                <p>
                    En <strong>SAYO</strong>, transformamos la potencia en eficiencia. Nuestra plataforma
                    garantiza una gestión fluida de hardware de última generación, seleccionando componentes
                    bajo estrictos criterios de sostenibilidad y economía circular para proteger el planeta
                    mientras potencias tu trabajo.
                </p>

                <h4>CPU | GPU | RAM | Sostenibilidad ASG</h4>
                <p class="pie-texto">Compromiso con el alto rendimiento</p>
            </div>
        </section>

        <section class="segunda">
            <div class="texto">
                <h2>Torres & Monitores</h2>

                <p>
                    La base de una gran experiencia comienza con una estructura sólida y una visualización perfecta.
                    En <strong>SAYO</strong>, ofrecemos torres con flujo de aire optimizado y monitores de alta
                    fidelidad
                    que transforman tu manera de trabajar y jugar.
                </p>

                <h4>Chasis ATX | Paneles IPS | 144Hz</h4>
                <p class="pie-texto">Estética y Funcionalidad</p>
            </div>
        </section>

        <section class="tercera">
            <h2>Productos de soporte</h2>

            <div class="cuadricula-productos">
                <div class="tarjeta-producto">
                    <img src="images/foto4.png" alt="Portátil">
                    <h3>Portátil</h3>
                </div>

                <div class="tarjeta-producto">
                    <img src="images/foto5.png" alt="Consola Portátil">
                    <h3>Consola</h3>
                </div>

                <div class="tarjeta-producto">
                    <img src="images/foto6.png" alt="Tarjeta Gráfica">
                    <h3>Tarjeta gráfica</h3>
                </div>

                <div class="tarjeta-producto">
                    <img src="images/foto7.png" alt="Placa Base">
                    <h3>Placa base</h3>
                </div>

                <div class="tarjeta-producto">
                    <img src="images/foto2.png" alt="Escritorio">
                    <h3>Escritorio</h3>
                </div>

                <div class="tarjeta-producto">
                    <img src="images/foto9.png" alt="Monitor">
                    <h3>Monitor</h3>
                </div>
            </div>
        </section>
    </section>

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