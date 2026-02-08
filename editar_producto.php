<?php
session_start();

// 1. SEGURIDAD
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-usuario.php");
    exit;
}

include_once 'bbdd.php';

$mensaje = "";
$error = "";
$producto = null;

// 2. RECUPERAR DATOS DEL PRODUCTO
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    
    $sql = "SELECT * FROM PRODUCTOS WHERE id_producto = :id";
    $stmt = oci_parse($conexion, $sql);
    oci_bind_by_name($stmt, ":id", $id_producto);
    oci_execute($stmt);
    
    $producto = oci_fetch_assoc($stmt);

    if (!$producto) {
        die("<h2 style='color:white;text-align:center;padding-top:100px;'>Error: Producto no encontrado.</h2>");
    }
}

// 3. GUARDAR CAMBIOS (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_producto = $_POST['id_producto'];
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    
    // Si suben imagen nueva
    if (!empty($_FILES['imagen']['name'])) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        $carpeta_destino = "images/" . basename($nombre_imagen);
        move_uploaded_file($ruta_temporal, $carpeta_destino);

        $sql = "UPDATE PRODUCTOS SET id_categoria=:cat, titulo=:tit, resumen=:res, descripcion=:descrip, precio=:prec, imagen=:img WHERE id_producto=:id";
        $stmt = oci_parse($conexion, $sql);
        oci_bind_by_name($stmt, ":img", $carpeta_destino);
    } else {
        // Si NO suben imagen (Mantenemos la vieja)
        $sql = "UPDATE PRODUCTOS SET id_categoria=:cat, titulo=:tit, resumen=:res, descripcion=:descrip, precio=:prec WHERE id_producto=:id";
        $stmt = oci_parse($conexion, $sql);
    }

    oci_bind_by_name($stmt, ":cat", $categoria);
    oci_bind_by_name($stmt, ":tit", $titulo);
    oci_bind_by_name($stmt, ":res", $resumen);
    oci_bind_by_name($stmt, ":descrip", $descripcion);
    oci_bind_by_name($stmt, ":prec", $precio);
    oci_bind_by_name($stmt, ":id", $id_producto);

    if (oci_execute($stmt)) {
        header("Location: gestionar_productos.php"); 
        exit;
    } else {
        $e = oci_error($stmt);
        $error = "Error al actualizar: " . $e['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/editar.css">
    
    <style>
        /* Aseguramos que se vea todo */
        .formulario-editar input, 
        .formulario-editar select, 
        .formulario-editar textarea,
        .formulario-editar button {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 100%;
        }
        .vista-previa img {
            display: inline-block !important;
            width: auto !important;
        }
        header input, .menu input { display: none !important; }
    </style>
</head>
<body class="editar">

    <?php include 'menu.php'; ?>

    <div class="contenedor-editar">
        <h1>Modificar Producto</h1>

        <?php if($error): ?>
            <div class="alerta error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($producto): ?>
        <form action="editar_producto.php" method="POST" enctype="multipart/form-data" class="formulario-editar">
            
            <input type="hidden" name="id_producto" value="<?php echo $producto['ID_PRODUCTO']; ?>">

            <div class="fila">
                <div class="campo">
                    <label>Título:</label>
                    <input type="text" name="titulo" value="<?php echo $producto['TITULO']; ?>" required>
                </div>

                <div class="campo">
                    <label>Categoría:</label>
                    <select name="categoria" required>
                        <option value="1" <?php if($producto['ID_CATEGORIA'] == 1) echo 'selected'; ?>>Portátil</option>
                        <option value="2" <?php if($producto['ID_CATEGORIA'] == 2) echo 'selected'; ?>>Consola</option>
                        <option value="3" <?php if($producto['ID_CATEGORIA'] == 3) echo 'selected'; ?>>Tarjeta Gráfica</option>
                        <option value="4" <?php if($producto['ID_CATEGORIA'] == 4) echo 'selected'; ?>>Placa Base</option>
                        <option value="5" <?php if($producto['ID_CATEGORIA'] == 5) echo 'selected'; ?>>Escritorio</option>
                        <option value="6" <?php if($producto['ID_CATEGORIA'] == 6) echo 'selected'; ?>>Monitor</option>
                    </select>
                </div>
            </div>

            <div class="fila">
                <div class="campo">
                    <label>Precio (€):</label>
                    <input type="number" name="precio" step="0.01" value="<?php echo $producto['PRECIO']; ?>" required>
                </div>

                <div class="campo">
                    <label>Imagen Actual:</label>
                    <div class="vista-previa">
                        <?php 
                            // Corrección para leer la imagen si es CLOB (raro pero posible)
                            $img = $producto['IMAGEN'];
                            if (is_object($img)) { $img = $img->load(); }
                            $ruta_img = !empty($img) ? $img : 'images/sin_imagen.png';
                        ?>
                        <img src="<?php echo $ruta_img; ?>" height="60">
                        <span>(Sube otra para cambiarla)</span>
                    </div>
                    <input type="file" name="imagen" accept="image/*">
                </div>
            </div>

            <div class="campo ancho-total">
                <label>Resumen:</label>
                <input type="text" name="resumen" value="<?php echo $producto['RESUMEN']; ?>" required>
            </div>

            <div class="campo ancho-total">
                <label>Descripción:</label>
                <textarea name="descripcion" rows="8" required><?php 
                    $desc = $producto['DESCRIPCION'];
                    if (is_object($desc)) { // Si es un objeto de Oracle (CLOB)
                        echo $desc->load(); // Lo leemos
                    } else {
                        echo $desc; // Si es texto normal, lo imprimimos
                    }
                ?></textarea>
            </div>

            <button type="submit" class="boton-actualizar">GUARDAR CAMBIOS</button>

        </form>
        <?php endif; ?>
    </div>

</body>
</html>