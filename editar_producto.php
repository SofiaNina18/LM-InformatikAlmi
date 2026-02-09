<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-usuario.php");
    exit;
}

include_once 'bbdd.php';

$mensaje = "";
$error = "";
$error_fatal = "";
$producto = null;
$galeria = [];

$sql_cat = "SELECT * FROM CATEGORIAS ORDER BY ID_CATEGORIA ASC";
$stmt_cat = oci_parse($conexion, $sql_cat);
oci_execute($stmt_cat);

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    
    $sql = "SELECT * FROM PRODUCTOS WHERE id_producto = :id";
    $stmt = oci_parse($conexion, $sql);
    oci_bind_by_name($stmt, ":id", $id_producto);
    oci_execute($stmt);
    $producto = oci_fetch_assoc($stmt);

    if (!$producto) {
        $error_fatal = "Error: Producto no encontrado.";
    } else {
        $sql_gal = "SELECT * FROM IMAGENES_GALERIA WHERE id_producto = :id";
        $stmt_gal = oci_parse($conexion, $sql_gal);
        oci_bind_by_name($stmt_gal, ":id", $id_producto);
        oci_execute($stmt_gal);
        while ($fila = oci_fetch_assoc($stmt_gal)) {
            $galeria[] = $fila;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_producto = $_POST['id_producto'];
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    if (!empty($_FILES['imagen']['name'])) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        $carpeta_destino = "images/" . basename($nombre_imagen);
        move_uploaded_file($ruta_temporal, $carpeta_destino);

        $sql = "UPDATE PRODUCTOS SET id_categoria=:cat, titulo=:tit, resumen=:res, descripcion=:descrip, precio=:prec, imagen=:img WHERE id_producto=:id";
        $stmt = oci_parse($conexion, $sql);
        oci_bind_by_name($stmt, ":img", $carpeta_destino);
    } else {
        $sql = "UPDATE PRODUCTOS SET id_categoria=:cat, titulo=:tit, resumen=:res, descripcion=:descrip, precio=:prec WHERE id_producto=:id";
        $stmt = oci_parse($conexion, $sql);
    }

    oci_bind_by_name($stmt, ":cat", $categoria);
    oci_bind_by_name($stmt, ":tit", $titulo);
    oci_bind_by_name($stmt, ":res", $resumen);
    oci_bind_by_name($stmt, ":descrip", $descripcion);
    oci_bind_by_name($stmt, ":prec", $precio);
    oci_bind_by_name($stmt, ":id", $id_producto);
    
    if (!oci_execute($stmt)) {
        $e = oci_error($stmt);
        $error = "Error: " . $e['message'];
    }

    if (isset($_POST['borrar_galeria'])) {
        foreach ($_POST['borrar_galeria'] as $ruta_a_borrar) {
            if (file_exists($ruta_a_borrar)) { unlink($ruta_a_borrar); }
            $sql_del = "DELETE FROM IMAGENES_GALERIA WHERE imagen = :img AND id_producto = :id_prod";
            $stmt_del = oci_parse($conexion, $sql_del);
            oci_bind_by_name($stmt_del, ":img", $ruta_a_borrar);
            oci_bind_by_name($stmt_del, ":id_prod", $id_producto);
            oci_execute($stmt_del);
        }
    }

    if (!empty($_FILES['nuevas_fotos']['name'][0])) {
        $total = count($_FILES['nuevas_fotos']['name']);
        for ($i = 0; $i < $total; $i++) {
            $nom = $_FILES['nuevas_fotos']['name'][$i];
            $tmp = $_FILES['nuevas_fotos']['tmp_name'][$i];
            if ($nom) {
                $dest = "images/" . basename($nom);
                move_uploaded_file($tmp, $dest);
                $sql_ins = "INSERT INTO IMAGENES_GALERIA (id_producto, imagen) VALUES (:id_prod, :img_path)";
                $stmt_ins = oci_parse($conexion, $sql_ins);
                oci_bind_by_name($stmt_ins, ":id_prod", $id_producto);
                oci_bind_by_name($stmt_ins, ":img_path", $dest);
                oci_execute($stmt_ins);
            }
        }
    }

    if (!$error) {
        header("Location: gestionar_productos.php");
        exit;
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
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>
<body class="editar">

    <?php include 'menu.php'; ?>

    <?php if ($error_fatal): ?>
        
        <h2 class="mensaje-fatal"><?php echo $error_fatal; ?></h2>

    <?php elseif ($producto): ?>
        
        <div class="contenedor-editar">
            <h1>Modificar Producto</h1>

            <?php if($error): ?>
                <div class="alerta error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="editar_producto.php?id=<?php echo $producto['ID_PRODUCTO']; ?>" method="POST" enctype="multipart/form-data" class="formulario-editar">
                
                <input type="hidden" name="id_producto" value="<?php echo $producto['ID_PRODUCTO']; ?>">

                <div class="fila">
                    <div class="campo">
                        <label>Título:</label>
                        <input type="text" name="titulo" value="<?php echo $producto['TITULO']; ?>" required>
                    </div>
                    <div class="campo">
                        <label>Categoría:</label>
                        <select name="categoria" required>
                            <?php 
                            while ($cat = oci_fetch_assoc($stmt_cat)) {
                                $id_c = $cat['ID_CATEGORIA'];
                                $nom_c = $cat['NOMBRE_CATEGORIA'];
                                $selected = ($id_c == $producto['ID_CATEGORIA']) ? 'selected' : '';
                                echo "<option value='$id_c' $selected>$nom_c</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="fila">
                    <div class="campo">
                        <label>Precio (€):</label>
                        <input type="number" name="precio" step="0.01" value="<?php echo $producto['PRECIO']; ?>" required>
                    </div>
                    <div class="campo">
                        <label>Imagen Principal:</label>
                        <div class="vista-previa">
                            <?php 
                                $img = $producto['IMAGEN'];
                                if (is_object($img)) { $img = $img->load(); }
                                $ruta = !empty($img) ? $img : 'images/sin_imagen.png';
                            ?>
                            <img src="<?php echo $ruta; ?>" height="60" alt="Previsualización">
                        </div>
                        <input type="file" name="imagen" accept="image/*">
                    </div>
                </div>

                <div class="contenedor-galeria">
                    <label class="titulo-galeria">Galería de Imágenes Extra</label>
                    
                    <div class="fotos-existentes">
                        <?php if (count($galeria) > 0): ?>
                            <?php foreach($galeria as $foto): ?>
                                <div class="galeria-editar">
                                    <img src="<?php echo $foto['IMAGEN']; ?>" alt="Extra">
                                    <label class="eliminar-galeria">
                                        <input type="checkbox" name="borrar_galeria[]" value="<?php echo $foto['IMAGEN']; ?>">
                                        Borrar
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="sin-fotos">No hay imágenes extra.</p>
                        <?php endif; ?>
                    </div>

                    <div class="añadir-fotos">
                        <label>Añadir nuevas fotos (Selección múltiple):</label>
                        <input type="file" name="nuevas_fotos[]" multiple accept="image/*">
                    </div>
                </div>

                <div class="texto-producto">
                    <label>Resumen:</label>
                    <input type="text" name="resumen" value="<?php echo $producto['RESUMEN']; ?>" required>
                </div>

                <div class="texto-producto">
                    <label>Descripción:</label>
                    <textarea name="descripcion" rows="8" required><?php 
                        $desc = $producto['DESCRIPCION'];
                        if (is_object($desc)) { echo $desc->load(); } else { echo $desc; }
                    ?></textarea>
                </div>

                <button type="submit" class="boton-actualizar">GUARDAR CAMBIOS</button>

            </form>
        </div>
    <?php endif; ?>
</body>
</html>