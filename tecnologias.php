<?php 
// 1. Conexión y Sesión
include_once 'bbdd.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();
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

<body class="pag-tecnologia">

    <?php include 'menu.php'; ?>

    <header class="cabecera-tech">
        <h1>CATÁLOGO SAYO</h1>
        <p style="color: #aaa;">Hardware de alto rendimiento</p>
    </header>

    <main class="contenedor-principal">
        <?php
        // 1. OBTENER CATEGORÍAS
        $sql_cat = "SELECT * FROM CATEGORIAS ORDER BY id_categoria ASC";
        $stmt_cat = oci_parse($conexion, $sql_cat);
        oci_execute($stmt_cat);

        while ($cat = oci_fetch_assoc($stmt_cat)) {
            $id_cat = $cat['ID_CATEGORIA'];
            $nombre_cat = $cat['NOMBRE_CATEGORIA'];

            // ID para el ancla
            $ancla = strtolower(str_replace(['á','é','í','ó','ú',' '], ['a','e','i','o','u',''], $nombre_cat));
            if(strpos($ancla, 'grafica') !== false) $ancla = 'grafica';

            echo "<section id='$ancla'>"; // Sección contenedora

            // --- LÓGICA DE TÍTULOS PERSONALIZADOS ---
            $titulo_bonito = $nombre_cat;
            if ($nombre_cat == 'Portátil') $titulo_bonito = "Nuestros Portátiles";
            elseif ($nombre_cat == 'Consola') $titulo_bonito = "Nuestras Consolas";
            elseif ($nombre_cat == 'Tarjeta Gráfica') $titulo_bonito = "Tarjetas Gráficas";
            elseif ($nombre_cat == 'Placa Base') $titulo_bonito = "Placas Base";
            elseif ($nombre_cat == 'Escritorio') $titulo_bonito = "Escritorios Gaming";
            elseif ($nombre_cat == 'Monitor') $titulo_bonito = "Monitores";

            // IMPRIMIMOS EL TÍTULO
            echo "<h2 class='titulo-seccion'>$titulo_bonito</h2>";

            // 2. OBTENER PRODUCTOS
            $sql_prod = "SELECT * FROM PRODUCTOS WHERE id_categoria = :id";
            $stmt_prod = oci_parse($conexion, $sql_prod);
            oci_bind_by_name($stmt_prod, ":id", $id_cat);
            oci_execute($stmt_prod);

            // ABRIMOS LA REJILLA (GRID)
            echo "<div class='grid-3-columnas'>";

            $hay_productos = false;
            while ($prod = oci_fetch_assoc($stmt_prod)) {
                $hay_productos = true;
                // Si no hay imagen en BD, ponemos una por defecto
                $img = $prod['IMAGEN'] ? $prod['IMAGEN'] : 'images/sin_imagen.png';
                
                echo "
                <article class='tarjeta-producto'>
                    <div class='img-wrap'>
                        <img src='$img' alt='Producto'>
                    </div>
                    <div class='contenido-tarjeta'>
                        <h3>{$prod['TITULO']}</h3>
                        <p class='resumen'>{$prod['RESUMEN']}</p>
                        <a href='ver_producto.php?id={$prod['ID_PRODUCTO']}' class='btn-ver-mas'>Ver más ></a>
                    </div>
                </article>
                ";
            }
            
            // CIERRE DE REJILLA
            echo "</div>";

            if (!$hay_productos) {
                echo "<p style='color: #666; margin-top:10px;'>Próximamente...</p>";
            }

            echo "</section>"; // Fin sección
        }
        ?>
    </main>
    
    <div style="height: 100px;"></div>

    <footer>
        <div class="footer-interior" style="text-align: center; padding: 20px; color: #fff;">
             <a href="index.php" style="color:#00e5ff; text-decoration:none; font-weight:bold; font-size: 1.5rem;">SAYO</a>
        </div>
    </footer>

</body>
</html>