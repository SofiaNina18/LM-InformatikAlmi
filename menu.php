<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="menu">
    <div class="logo">
        <a href="index.php"><img src="images/logo.png" id="logo" alt="SAYO"></a>
    </div>
    <nav class="contenido">
        <ul class="lista">
            <li><a href="servicios.php">Servicios</a></li>
            
            <li class="lista-abajo">
                <a href="tecnologias.php" class="boton">Tecnología ▾</a>
                <div class="menu-tecnologia">
                    <a href="tecnologias.php#portatil">Portátiles</a>
                    <a href="tecnologias.php#consola">Consolas</a>
                    <a href="tecnologias.php#grafica">Gráficas</a>
                    <a href="tecnologias.php#placabase">Placas Base</a>
                    <a href="tecnologias.php#escritorio">Escritorios</a>
                    <a href="tecnologias.php#monitor">Monitores</a>
                </div>
            </li>

            <li><a href="proyectos.php">Proyectos</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            
            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="cerrar-sesion.php" class="iniciar cerrar">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="iniciar-usuario.php" class="iniciar">Iniciar Sesion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>