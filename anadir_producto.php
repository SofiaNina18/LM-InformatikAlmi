<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-usuario.php");
    exit;
}

include_once 'bbdd.php';

$mensaje = "";
$error = "";

$sql_lista_cat = "SELECT * FROM CATEGORIAS ORDER BY ID_CATEGORIA ASC";
$stmt_lista_cat = oci_parse($conexion, $sql_lista_cat);
oci_execute($stmt_lista_cat);

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
                VALUES (:cat, :tit, :res, :descrip, :prec, :img) 
                RETURNING id_producto INTO :id_nuevo";

        $stmt = oci_parse($conexion, $sql);

        oci_bind_by_name($stmt, ":cat", $categoria);
        oci_bind_by_name($stmt, ":tit", $titulo);
        oci_bind_by_name($stmt, ":res", $resumen);
        oci_bind_by_name($stmt, ":descrip", $descripcion);
        oci_bind_by_name($stmt, ":prec", $precio);
        oci_bind_by_name($stmt, ":img", $carpeta_destino);

        $id_nuevo_producto = 0;
        oci_bind_by_name($stmt, ":id_nuevo", $id_nuevo_producto, -1, OCI_B_INT);

        if (oci_execute($stmt)) {
            if (!empty($_FILES['galeria']['name'][0])) {
                $total_fotos = count($_FILES['galeria']['name']);
                for ($i = 0; $i < $total_fotos; $i++) {
                    $nom_gal = $_FILES['galeria']['name'][$i];
                    $tmp_gal = $_FILES['galeria']['tmp_name'][$i];

                    if ($nom_gal) {
                        $dest_gal = "images/" . basename($nom_gal);
                        move_uploaded_file($tmp_gal, $dest_gal);

                        $sql_gal = "INSERT INTO IMAGENES_GALERIA (id_producto, imagen) VALUES (:id_prod, :img_path)";
                        $stmt_gal = oci_parse($conexion, $sql_gal);
                        oci_bind_by_name($stmt_gal, ":id_prod", $id_nuevo_producto);
                        oci_bind_by_name($stmt_gal, ":img_path", $dest_gal);
                        oci_execute($stmt_gal);
                    }
                }
            }
            $mensaje = "Producto y galería añadidos";
        } else {
            $e = oci_error($stmt);
            $error = "Error al guardar en BD: " . $e['message'];
        }
    } else {
        $error = "Error al subir la imagen principal.";
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
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>

<body class="añadir">

    <?php include 'menu.php'; ?>

    <div class="administracion">
        <h1>Añadir Nuevo Producto</h1>

        <?php if ($mensaje): ?>
            <div class="alerta exito"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
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
                    <option value="" disabled selected>Selecciona una categoría</option>
                    
                    <?php 
                    while ($cat = oci_fetch_assoc($stmt_lista_cat)): 
                        $id_c = $cat['ID_CATEGORIA'];
                        $nombre_c = $cat['NOMBRE_CATEGORIA'];
                    ?>
                        <option value="<?php echo $id_c; ?>">
                            <?php echo $nombre_c; ?>
                        </option>
                    <?php endwhile; ?>
                    
                </select>
            </div>

            <div class="relleno">
                <label>Precio (€):</label>
                <input type="number" name="precio" step="0.01" required placeholder="1500.00">
            </div>

            <div class="relleno">
                <label>Imagen Principal (Portada):</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <div class="seccion-galeria">
                <label>Galería de Imágenes Adicionales:</label> <br>
                <input type="file" name="galeria[]" multiple accept="image/*">
            </div>

            <div class="relleno-texto">
                <label>Resumen: </label>
                <input type="text" name="resumen" required placeholder="Ej: Es un producto potente con...">
            </div>

            <div class="relleno-texto">
                <label>Descripción:</label>
                <p class="nota">Usa &lt;br&gt; para saltos de línea y • para puntos.</p>
                <textarea name="descripcion" rows="8" required placeholder="• Procesador... <br> • Pantalla..."></textarea>
            </div>

            <button type="submit" class="guardar">GUARDAR PRODUCTO</button>

        </form>
    </div>
</body>

</html>