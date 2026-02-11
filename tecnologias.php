<?php 
include_once 'bbdd.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();

$filtro_id = null;

if (isset($_GET['nombre'])) {
    $nombre_buscado = $_GET['nombre'];
    $sql_busca_id = "SELECT ID_CATEGORIA FROM CATEGORIAS WHERE UPPER(NOMBRE_CATEGORIA) LIKE '%' || UPPER(:nom) || '%'";
    $stmt_busca = oci_parse($conexion, $sql_busca_id);
    oci_bind_by_name($stmt_busca, ":nom", $nombre_buscado);
    oci_execute($stmt_busca);
    
    if ($row = oci_fetch_assoc($stmt_busca)) {
        $filtro_id = $row['ID_CATEGORIA'];
    }
} 
elseif (isset($_GET['categoria'])) {
    $filtro_id = $_GET['categoria'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnología</title>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="css/menu.css">  
    <link rel="stylesheet" href="css/tecnologias.css">
</head>

<body class="tecnologia">

    <?php include 'menu.php'; ?>
    

    <header class="titulo-tecnologia">
        <h1>CATÁLOGO SAYO</h1>
        <p class="texto-abajo">Hardware de alto rendimiento</p>
    </header>

    <main class="categorias-productos">
        <?php

        if ($filtro_id) {
            $sql_cat = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA = :id";
            $stmt_cat = oci_parse($conexion, $sql_cat);
            oci_bind_by_name($stmt_cat, ":id", $filtro_id);
        } else {
            $sql_cat = "SELECT * FROM CATEGORIAS ORDER BY ID_CATEGORIA ASC";
            $stmt_cat = oci_parse($conexion, $sql_cat);
        }
        
        oci_execute($stmt_cat);

        while ($cat = oci_fetch_assoc($stmt_cat)) {
            $id_cat = $cat['ID_CATEGORIA'];
            $nombre_cat = $cat['NOMBRE_CATEGORIA'];

            $ancla = strtolower(str_replace(['á','é','í','ó','ú',' '], ['a','e','i','o','u',''], $nombre_cat));

            echo "<section id='$ancla'>"; 

            echo "<h2 class='titulo-seccion'>" . strtoupper($nombre_cat) . "</h2>";

            $sql_prod = "SELECT * FROM PRODUCTOS WHERE id_categoria = :id";
            $stmt_prod = oci_parse($conexion, $sql_prod);
            oci_bind_by_name($stmt_prod, ":id", $id_cat);
            oci_execute($stmt_prod);

            echo "<div class='3-columnas'>";

            $hay_productos = false;
            while ($prod = oci_fetch_assoc($stmt_prod)) {
                $hay_productos = true;
                $img = !empty($prod['IMAGEN']) ? $prod['IMAGEN'] : 'images/sin_imagen.png';
                
                echo "
                <article class='tarjeta-producto'>
                    <div class='img-contenido'>
                        <img src='$img' alt='Producto'>
                    </div>
                    <div class='contenido-tecnologia'>
                        <h3>{$prod['TITULO']}</h3>
                        <p class='resumen'>{$prod['RESUMEN']}</p>
                        <a href='ver_producto.php?id={$prod['ID_PRODUCTO']}' class='ver-mas'>Ver más ></a>
                    </div>
                </article>
                ";
            }
            
            echo "</div>";

            if (!$hay_productos) {
                echo "<p class='texto-proximamente'>Próximamente...</p>";
            }

            echo "</section>"; 
        }
        ?>
    </main>
    
    <div class="espaciador-final"></div>

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