<?php
session_start();
include_once 'bbdd.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sostenibilidad</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/proyectos.css">
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>
<body class="cuerpo-proyectos">



    <?php include 'menu.php'; ?>

    
    
    <section class="primera-parte-sos">
        <h1>Ámbito de la Empresa</h1>
        
        <div class="contenido-ambitos">
            <div class="imagen-ambitos">
                <img src="images/Sostenibilidad.png" alt="Sostenibilidad">
            </div>
            
            <div class="textos-ambitos">
                <div class="bloque-texto">
                    <h2>Sector</h2>
                    <p>Operamos en el sector tecnológico minorista y nos especializamos en el hardware de alto rendimiento y equipos personalizados.</p>
                </div>
                
                <div class="bloque-texto">
                    <h2>Actividad</h2>
                    <p>Nos dedicamos a la venta de componentes(tarjeta gráfica, procesadores,almacenamiento), periféricos. También damos servicio en nuestro taller para montar o arreglar ordenadores.</p>
                </div>
                
                <div class="bloque-texto">
                    <h2>Alcance</h2>
                    <p>Tenemos un modelo híbrido. Tenemos una tienda física que funciona como punto de venta y taller. También nos complementamos con una tienda online que nos permite hacer envíos nacionales.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="tabla-interesados">
        <h1>StakeHolders</h1>
        <div class="contenedor-tabla">
            <table>
                <tr>
                    <td>Stakeholder</td>
                    <td>Quiénes son</td>
                    <td>Sus Intereses y Expectativas</td>
                </tr>
                <tr>
                    <td>Clientes</td>
                    <td>Gamers, Profesionales, estudiantes</td>
                    <td>Calidad/precio, durabilidad, garantías, Productos Sostenibles</td>
                </tr>
                <tr>
                    <td>Proveedores</td>
                    <td>Marcas (Nvidia, AMD, Corsair, Intel, Logitech, MSI)</td>
                    <td>Cumplimientos de pago, compras grandes</td>
                </tr>
                <tr>
                    <td>Empleados</td>
                    <td>Técnicos de montaje, atención al cliente</td>
                    <td>Condiciones laborales justas, Seguridad en el taller</td>
                </tr>
                <tr>
                    <td>Medio Ambiente</td>
                    <td>El entorno local y global</td>
                    <td>Reducción de emisiones de CO2 en transportes, no tirar piezas a la basura normal</td>
                </tr>
                <tr>
                    <td>Administración</td>
                    <td>Gobierno</td>
                    <td>Cumplir la norma de RAEE y pago de impuestos.</td>
                </tr>
            </table>
        </div>
    </section>

    <section class="seccion-sostenibilidad">
        <h1>Indicadores de Sostenibilidad</h1>
        
        <div class="contenedor-carrusel">
            <div class="carrusel-deslizador">
                
                <div class="carrusel-elemento activo" style="background-image: url('images/carrusel1.png');">
                    <div class="carrusel-contenido">
                        <div class="carrusel-titulo">Eco-cajas</div>
                        <div class="carrusel-descripcion">
                            <strong>ODS 12:</strong> Producción y consumo responsable.<br><br>
                            <strong>Acción:</strong> Reutilización de las cajas recibidas para nuestros almacenes y envíos.<br><br>
                            <strong>Impacto:</strong> Creemos que podremos reutilizar cajas para 150 pedidos mensuales con material reciclado ahorrando más de 150 euros anuales.<br><br>
                            <strong>Normativa:</strong> Cumplimos el Cumplimiento de la directiva Europea.<br><br>
                            <strong>Meta:</strong> Lograr que el 75% de los envíos sean de cajas reutilizadas.
                        </div>
                    </div>
                </div>

                <div class="carrusel-elemento" style="background-image: url('images/carrusel2.png');">
                    <div class="carrusel-contenido">
                        <div class="carrusel-titulo">Componentes Verdes</div>
                        <div class="carrusel-descripcion">
                            <strong>Acción:</strong> Hacer un punto de recogida de componentes viejos para que no acaben en la basura convencional.<br><br>
                            <strong>Impacto:</strong> Evitar que acaben más de 200 kg de residuos electrónicos en el vertedero y dándoles una nueva vida.<br><br>
                            <strong>Normativa:</strong> Cumplimiento de la Directiva Europea de Envases.<br><br>
                            <strong>Meta:</strong> Reacondicionar el 40% de los componentes recogidos.
                        </div>
                    </div>
                </div>

                <div class="carrusel-elemento" style="background-image: url('images/carrusel3.png');">
                    <div class="carrusel-contenido">
                        <div class="carrusel-titulo">Componentes Rescatados</div>
                        <div class="carrusel-descripcion">
                            <strong>Acción:</strong> Sustituir la iluminación que tenemos por luces LED y usar regletas con auto apagado.<br><br>
                            <strong>Impacto:</strong> Dejaremos de emitir más de 1000 kg de CO2 a la atmósfera y ahorraremos más de 250 euros en la luz anual.<br><br>
                            <strong>Normativa:</strong> Cumplimiento de la Directiva Europea de Eficiencia Energética.<br><br>
                            <strong>Meta:</strong> Reducir un 15% el consumo eléctrico.
                        </div>
                    </div>
                </div>

            </div>

            <div class="carrusel-controles">
                <button class="btn-anterior">&#10094;</button>
                <button class="btn-siguiente">&#10095;</button>
            </div>
        </div>
    </section>

    <section class="seccion-economia-circular">
        <h1>Economía Circular</h1>
        
        <div class="contenido-economia">
            <div class="video-economia">
                <video controls>
                    <source src="videos/videoSos.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
            </div>
            
            <div class="texto-economia">
                <div class="bloque-texto">
                    <h2>Darle una segunda vida</h2>
                    <ul class="lista-economia">
                        <li>Ya que muchas personas cambian de gráfica cada cierto tiempo, te damos la opción de traer tu tarjeta vieja.</li>
                        <li>Si nos traes tu antigua gráfica, tu próxima compra te saldrá hasta <strong>100 euros más barata</strong> para que puedas ahorrar.</li>
                        <li>Nosotros nos encargamos de probar exhaustivamente la tarjeta gráfica recibida.</li>
                        <li>Una vez verificada, la reacondicionamos para venderla como componente de <strong>segunda mano</strong> y darle una nueva vida útil.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script src="js/proyectos.js"></script>
</body>
</html>