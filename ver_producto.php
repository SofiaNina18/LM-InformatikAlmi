<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'bbdd.php';


if (!isset($_GET['id'])) {
    header("Location: tecnologias.php");
    exit;
}
$id = $_GET['id'];


$sql = "SELECT * FROM PRODUCTOS WHERE id_producto = :id";
$stmt = oci_parse($conexion, $sql);
oci_bind_by_name($stmt, ":id", $id);
oci_execute($stmt);
$producto = oci_fetch_assoc($stmt);

if (!$producto) { echo "Producto no encontrado"; exit; }

$sql_gal = "SELECT imagen FROM IMAGENES_GALERIA WHERE id_producto = :id";
$stmt_gal = oci_parse($conexion, $sql_gal);
oci_bind_by_name($stmt_gal, ":id", $id);
oci_execute($stmt_gal);


$desc_obj = $producto['DESCRIPCION'];
$desc_texto = is_object($desc_obj) ? $desc_obj->load() : $desc_obj;
$desc_html = nl2br($desc_texto);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $producto['TITULO']; ?> - SAYO</title>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/detalle.css">
</head>

<body class="pag-detalle">

    <?php include 'menu.php'; ?>

    <div class="contenedor-producto">
        
        <div class="columna-fotos">
            <div class="marco-grande">
                <img id="imgGrande" src="<?php echo $producto['IMAGEN']; ?>" alt="Producto">
            </div>
            
            <div class="tira-miniaturas">
                <img src="<?php echo $producto['IMAGEN']; ?>" onclick="cambiarFoto(this)" class="thumb activo">
                <?php
                while ($foto = oci_fetch_assoc($stmt_gal)) {
                    $ruta = $foto['IMAGEN'];
                    echo "<img src='$ruta' onclick='cambiarFoto(this)' class='thumb'>";
                }
                ?>
            </div>
        </div>

        <div class="columna-info">
            <h1 class="titulo-prod"><?php echo $producto['TITULO']; ?></h1>
            
            <div class="descripcion-bloque">
                <?php echo $desc_html; ?>
            </div>

            <div class="precio-final">
                <?php echo number_format($producto['PRECIO'], 2, ',', '.'); ?> €
            </div>

            <a href="tecnologias.php" class="btn-volver">← Volver al Catálogo</a>
        </div>

    </div>

    <script>
        function cambiarFoto(peque) {
            let grande = document.getElementById('imgGrande');
            grande.style.opacity = 0;
            setTimeout(() => {
                grande.src = peque.src;
                grande.style.opacity = 1;
            }, 200);
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('activo'));
            peque.classList.add('activo');
        }
    </script>

</body>
</html>