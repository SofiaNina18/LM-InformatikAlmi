<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-usuario.php");
    exit;
}

include_once 'bbdd.php';

$mensaje = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $descripcion = $_POST['descripcion']; 
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria']; 

    $nombre_imagen = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $carpeta_destino = "images/" . basename($nombre_imagen);

    if (move_uploaded_file($ruta_temporal, $carpeta_destino)) {
        
        $sql = "INSERT INTO PRODUCTOS (id_categoria, titulo, resumen, descripcion, precio, imagen) 
                VALUES (:cat, :tit, :res, :descrip, :prec, :img)";
        
        $stmt = oci_parse($conexion, $sql);

        oci_bind_by_name($stmt, ":cat", $categoria);
        oci_bind_by_name($stmt, ":tit", $titulo);
        oci_bind_by_name($stmt, ":res", $resumen);
        oci_bind_by_name($stmt, ":descrip", $descripcion);
        oci_bind_by_name($stmt, ":prec", $precio);
        oci_bind_by_name($stmt, ":img", $carpeta_destino);

        if (oci_execute($stmt)) {
            $mensaje = "¡Producto añadido correctamente!";
        } else {
            $e = oci_error($stmt);
            $error = "Error al guardar en BD: " . $e['message'];
        }
        
    } else {
        $error = "Error al subir la imagen. Verifica permisos de la carpeta 'images'.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/formulario.css"> </head>
<body class="añadir">

    <?php include 'menu.php'; ?>

    <div class="administracion">
        <h1>Añadir Nuevo Producto</h1>

        <?php if($mensaje): ?>
            <div class="alerta exito"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="alerta error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="anadir_producto.php" method="POST" enctype="multipart/form-data" class="formulario">
            
            <div class="relleno">
                <label>Título del Producto:</label>
                <input type="text" name="titulo" required placeholder="Ej: MSI Raider GE78">
            </div>

            <div class="relleno">
                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="1">Portátil</option>
                    <option value="2">Consola</option>
                    <option value="3">Tarjeta Gráfica</option>
                    <option value="4">Placa Base</option>
                    <option value="5">Escritorio</option>
                    <option value="6">Monitor</option>
                </select>
            </div>

            <div class="relleno">
                <label>Precio (€):</label>
                <input type="number" name="precio" step="0.01" required placeholder="1500.00">
            </div>

            <div class="relleno">
                <label>Imagen Principal:</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <div class="relleno-texto">
                <label>Resumen Corto (se ve en la tarjeta):</label>
                <input type="text" name="resumen" required placeholder="Ej: Intel Core i9 / RTX 4080">
            </div>

            <div class="relleno-texto">
                <label>Descripción Detallada:</label>
                <p class="nota">Usa &lt;br&gt; para saltos de línea y • para puntos.</p>
                <textarea name="descripcion" rows="8" required placeholder="• Procesador... <br> • Pantalla..."></textarea>
            </div>

            <button type="submit" class="guardar">GUARDAR PRODUCTO</button>

        </form>
    </div>

</body>
</html>