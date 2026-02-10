<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/contacto.css">
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>

<body class="contacto">
    <?php include 'menu.php'; ?>

    <div class="menu-contacto">
        <div class="titulo">
            <h1>Ponte en <span>Contacto</span></h1>
            <p>Estamos listos para llevar a tu empresa al siguiente nivel.</p>
        </div>

        <div class="formulario-entero">
            <div class="mensaje">
                <h2>Envíanos un Mensaje</h2>
                <form action="" method="post">
                    <div class="lateral">
                        <div class="arriba-correo">
                            <label>Nombre Completo</label>
                            <input type="text" placeholder="Tu nombre">
                        </div>
                        <div class="arriba-correo">
                            <label>Correo Electrónico</label>
                            <input type="email" placeholder="tu@empresa.com">
                        </div>
                    </div>
                    <div class="correo">
                        <label>Asunto</label>
                        <input type="text" placeholder="Motivo">
                    </div>
                    <div class="correo">
                        <label>Mensaje</label>
                        <textarea rows="5" placeholder="Cuéntanos..."></textarea>
                    </div>
                    <button type="submit" class="enviar">Enviar Solicitud</button>
                </form>
            </div>

            <div class="columna-derecha">
                <div class="formulario-abajo">
                    <h2>Información</h2>
                    <hr class="divisor">

                    <div class="contenido-icono">
                        <div class="circulo">📍</div>
                        <div class="datos">
                            <h3>Oficina Central</h3>
                            <p>Agirre Lehendakariaren Etorb., 29, Deusto, Bilbao</p>
                        </div>
                    </div>

                    <div class="contenido-icono">
                        <div class="circulo">📞</div>
                        <div class="datos">
                            <h3>Llámanos</h3>
                            <p>+34 692 78 45 67</p>
                        </div>
                    </div>

                    <div class="contenido-icono">
                        <div class="circulo">✉️</div>
                        <div class="datos">
                            <h3>Email</h3>
                            <p>sayoalmi4@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="mapa">
                    <iframe width="100%" height="250" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6604.395159329867!2d-2.9515105236064842!3d43.27183007701292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4e503d5d438179%3A0x280c2779aeabb54b!2sAlmi%20Bilbao!5e1!3m2!1ses!2ses!4v1770711185446!5m2!1ses!2ses"></iframe>
                </div>
            </div>
        </div>
    </div>
</body>

</html>