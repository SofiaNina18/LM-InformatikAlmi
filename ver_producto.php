<?php
include_once 'bbdd.php';

if (!isset($_GET['id'])) {
    header("Location: tecnologia.php");
    exit;
}
$id = $_GET['id'];

// 1. PRODUCTO PRINCIPAL
$sql = "SELECT * FROM PRODUCTOS WHERE id_producto = :id";
$stmt = oci_parse($conexion, $sql);
oci_bind_by_name($stmt, ":id", $id);
oci_execute($stmt);
$producto = oci_fetch_assoc($stmt);

if (!$producto) { echo "Producto no encontrado"; exit; }

// 2. GALERÍA
$sql_gal = "SELECT imagen FROM IMAGENES_GALERIA WHERE id_producto = :id";
$stmt_gal = oci_parse($conexion, $sql_gal);
oci_bind_by_name($stmt_gal, ":id", $id);
oci_execute($stmt_gal);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $producto['TITULO']; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/detalle.css">
</head>
<body class="pag-detalle">

    <?php include 'menu.php'; ?>

    <main class="contenedor-detalle">
        
        <div class="zona-galeria">
            <div class="logo-copilot">
                <img src="images/logo_copilot.png" alt="Copilot+PC" style="width: 150px; display: none;"> 
            </div>

            <div class="marco-principal">
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

        <div class="zona-info">
            <h1 class="titulo-prod"><?php echo $producto['TITULO']; ?></h1>
            <h2 class="subtitulo-prod">Copilot+ PC</h2> <div class="descripcion-completa">
                <?php 
                // AQUÍ ESTÁ LA SOLUCIÓN AL TEXTO CORTADO
                // 1. Cargamos el objeto CLOB
                if (is_object($producto['DESCRIPCION'])) {
                    $texto_completo = $producto['DESCRIPCION']->load();
                } else {
                    $texto_completo = $producto['DESCRIPCION'];
                }
                
                // 2. Convertimos saltos de línea en <br> HTML
                echo nl2br($texto_completo); 
                ?>
            </div>
            
            <div class="zona-precio">
                Precio: <?php echo $producto['PRECIO']; ?> €
            </div>

            <a href="tecnologia.php" class="btn-volver">← Volver</a>
        </div>
    </main>

    <script>
        function cambiarFoto(peque) {
            document.getElementById('imgGrande').src = peque.src;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('activo'));
            peque.classList.add('activo');
        }
    </script>
</body>
</html>