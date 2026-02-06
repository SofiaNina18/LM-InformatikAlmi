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
            <li><a href="index.php">Servicios</a></li>
            <li><a href="tecnologia.php">Tecnología</a></li>
            <li><a href="proyectos.php">Proyectos</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            
            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="#" class="iniciar">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="#" class="iniciar">Iniciar Sesion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>