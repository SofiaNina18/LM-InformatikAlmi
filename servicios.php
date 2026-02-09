<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/servicios.css">
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>

<body class="servicios">

    <?php include 'menu.php'; ?>

    <section class="primera-parte">
        <div class="texto">
            <h1>Consigue un PC que <br> vaya contigo</h1>
            <p>No solo configuramos equipos; permitimos que pongas tu propio sello en el diseño y la creación.</p>
            <a href="tecnologias.php" class="boton">Nuevas tecnologias ></a>
        </div>
        <div class="imagen">
            <img src="images/foto1.png" alt="Configuración de PCs Gaming">
        </div>
    </section>

    <section class="servicios-lista">
        <div class="contenido-servicio">
            <div class="servicio">
                <h3>Montaje a medida</h3>
                <p>Configuración personalizada pieza a pieza con compatibilidad garantizada.</p>
            </div>
            <div class="servicio">
                <h3>Optimización ASG</h3>
                <p>Equipos diseñados bajo criterios de sostenibilidad y bajo consumo energético.</p>
            </div>
            <div class="servicio">
                <h3>Soporte Técnico</h3>
                <p>Atención directa y mantenimiento para empresas y particulares.</p>
            </div>
        </div>
    </section>

    <section class="segunda-parte">
        <div class="video-izquierda">
            <video autoplay muted loop playsinline>
                <source src="videos/video1.mp4" type="video/mp4">
                Tu navegador no soporta el video.
            </video>
        </div>
        
        <div class="texto">
            <h2>Ordenadores para juegos <br> prediseñados</h2>
            <p>
                ¡En stock y listo para enviarse! Disponemos de una gran variedad de ordenadores 
                sobremesa gaming prediseñados que puedes comprar hoy mismo para recibirlos de inmediato. 
                Todos nuestros ordenadores están construidos con componentes de alta calidad de las 
                principales marcas del mundo como Intel, AMD, NVIDIA, ASUS y Corsair.
            </p>
            <a href="tecnologias.php" class="boton">Ver más ></a>
        </div>
    </section>

    <section class="tercera-parte">
        <h2>Ordenadores portátiles por sistema operativo</h2>
        
        <div class="contenedor-sistemas">
            <div class="sistema">
                <div class="imagen-circulo">
                    <img src="images/Windows.jpg" alt="Portátil Windows">
                </div>
                <h3>Windows</h3>
            </div>

            <div class="sistema">
                <div class="imagen-circulo">
                    <img src="images/Mac.png" alt="Portátil Mac">
                </div>
                <h3>Mac</h3>
            </div>

            <div class="sistema">
                <div class="imagen-circulo">
                    <img src="images/Google.jpg" alt="Portátil Google">
                </div>
                <h3>Google</h3>
            </div>

            <div class="sistema">
                <div class="imagen-circulo">
                    <img src="images/Linux.png" alt="Portátil Linux">
                </div>
                <h3>Linux</h3>
            </div>
        </div>
    </section>

<section class="cuarta-parte">
        <h2>Atención personalizada</h2>
        
        <div class="atencion">
            <div class="texto">
                <p>
                    En <strong>SAYO</strong>, no hablas con bots. Nuestro equipo de expertos en hardware 
                    te acompaña en cada paso de la configuración. Analizamos tus necesidades reales 
                    —ya sea para renderizado 3D, gaming competitivo o servidores empresariales— 
                    y te proponemos la combinación más eficiente y sostenible.
                </p>
                <ul class="lista-ventajas">
                    <li>✓ Asesoramiento técnico directo</li>
                    <li>✓ Optimización de presupuesto</li>
                    <li>✓ Resolución de dudas en tiempo real</li>
                </ul>
                <a href="contacto.php" class="boton">Hablar con un experto ></a>
            </div>

            <div class="video">
                <video autoplay muted loop playsinline>
                    <source src="videos/atencionPerzonalizada.mp4" type="video/mp4">
                    Tu navegador no soporta el video.
                </video>
            </div>
        </div>
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