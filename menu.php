<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'bbdd.php';
$pagina_actual = basename($_SERVER['PHP_SELF']);

$sql_menu = "SELECT * FROM CATEGORIAS ORDER BY ID_CATEGORIA ASC";
$stmt_menu = oci_parse($conexion, $sql_menu);
oci_execute($stmt_menu);
?>

<header class="menu">
    <div class="logo">
        <a href="index.php"><img src="images/logo.png" id="logo" alt="SAYO"></a>
    </div>
    <nav class="contenido">
        <ul class="lista">
            <li><a href="servicios.php" class="<?php echo ($pagina_actual == 'servicios.php') ? 'activar-menu' : ''; ?>">Servicios</a></li>

            <li class="lista-abajo">
                <a href="tecnologias.php" class="<?php echo ($pagina_actual == 'tecnologias.php') ? 'boton' : ''; ?>">Tecnología ▾</a>
                <div class="menu-tecnologia">
                    <?php
                    while ($cat = oci_fetch_assoc($stmt_menu)):
                        $nombre_cat = $cat['NOMBRE_CATEGORIA'];
                        $id_cat = $cat['ID_CATEGORIA'];
                    ?>
                        <a href="tecnologias.php?categoria=<?php echo $id_cat; ?>">
                            <?php echo $nombre_cat; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </li>

            <li><a href="proyectos.php" class="<?php echo ($pagina_actual == 'proyectos.php') ? 'activar-menu' : ''; ?>">Proyectos</a></li>
            <li><a href="contacto.php" class="<?php echo ($pagina_actual == 'contacto.php') ? 'activar-menu' : ''; ?>">Contacto</a></li>

            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="anadir_producto.php">Añadir Producto</a></li>
                <li><a href="gestionar_productos.php">Gestionar Productos</a></li>
                <li><a href="cerrar-sesion.php" class="iniciar cerrar">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="iniciar-usuario.php" class="iniciar">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>