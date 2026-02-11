<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-usuario.php");
    exit;
}

include_once 'bbdd.php';

if (isset($_GET['borrar'])) {
    $id_borrar = $_GET['borrar'];

    $sql_img = "SELECT imagen FROM PRODUCTOS WHERE id_producto = :id";
    $stmt_img = oci_parse($conexion, $sql_img);
    oci_bind_by_name($stmt_img, ":id", $id_borrar);
    oci_execute($stmt_img);
    
    if ($fila = oci_fetch_assoc($stmt_img)) {
        if (!empty($fila['IMAGEN']) && file_exists($fila['IMAGEN'])) {
            unlink($fila['IMAGEN']);
        }
    }

    $sql_galeria = "SELECT imagen FROM IMAGENES_GALERIA WHERE id_producto = :id";
    $stmt_galeria = oci_parse($conexion, $sql_galeria);
    oci_bind_by_name($stmt_galeria, ":id", $id_borrar);
    oci_execute($stmt_galeria);

    while ($fila_g = oci_fetch_assoc($stmt_galeria)) {
        if (!empty($fila_g['IMAGEN']) && file_exists($fila_g['IMAGEN'])) {
            unlink($fila_g['IMAGEN']);
        }
    }

    $sql_del_gal = "DELETE FROM IMAGENES_GALERIA WHERE id_producto = :id";
    $stmt_del_gal = oci_parse($conexion, $sql_del_gal);
    oci_bind_by_name($stmt_del_gal, ":id", $id_borrar);
    oci_execute($stmt_del_gal);

    $sql_del_ped = "DELETE FROM PRODUCTOS_PEDIDOS WHERE ID_PRODUCTOS = :id";
    $stmt_del_ped = oci_parse($conexion, $sql_del_ped);
    oci_bind_by_name($stmt_del_ped, ":id", $id_borrar);
    oci_execute($stmt_del_ped);

    $sql_del = "DELETE FROM PRODUCTOS WHERE id_producto = :id";
    $stmt_del = oci_parse($conexion, $sql_del);
    oci_bind_by_name($stmt_del, ":id", $id_borrar);
    
    if (oci_execute($stmt_del)) {
        header("Location: gestionar_productos.php"); 
        exit;
    } else {
        $e = oci_error($stmt_del);
        echo "<script>alert('Error al eliminar: " . $e['message'] . "');</script>";
    }
}

$categorias = [];
$sql_cat = "SELECT * FROM CATEGORIAS ORDER BY ID_CATEGORIA ASC";
$stmt_cat = oci_parse($conexion, $sql_cat);
oci_execute($stmt_cat);
while ($row = oci_fetch_assoc($stmt_cat)) {
    $categorias[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Productos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/gestion.css">
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>
<body class="gestion">

    <?php include 'menu.php'; ?>

    

    <div class="contenedor-gestion">
        <h1>Gestión de Inventario</h1>

        <div class="menu-filtros">
            <?php foreach ($categorias as $cat): ?>
                <a href="#cat-<?php echo $cat['ID_CATEGORIA']; ?>" class="boton-filtro">
                    <?php echo $cat['NOMBRE_CATEGORIA']; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php foreach ($categorias as $cat): ?>
            
            <?php
            $cat_id = $cat['ID_CATEGORIA'];
            $sql_prod = "SELECT * FROM PRODUCTOS WHERE id_categoria = :id ORDER BY id_producto DESC";
            $stmt_prod = oci_parse($conexion, $sql_prod);
            oci_bind_by_name($stmt_prod, ":id", $cat_id);
            oci_execute($stmt_prod);
            
            $productos_encontrados = [];
            while ($p = oci_fetch_assoc($stmt_prod)) {
                $productos_encontrados[] = $p;
            }
            ?>

            <?php if (count($productos_encontrados) > 0): ?>
                <div id="cat-<?php echo $cat_id; ?>" class="seccion-categoria">
                    <h2 class="titulo-categoria"><?php echo $cat['NOMBRE_CATEGORIA']; ?></h2>
                    
                    <div class="tabla-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>IMG</th>
                                    <th>PRODUCTO</th>
                                    <th>PRECIO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos_encontrados as $prod): ?>
                                    <tr>
                                        <td class="col-img">
                                            <?php $ruta = !empty($prod['IMAGEN']) ? $prod['IMAGEN'] : 'images/sin_imagen.png'; ?>
                                            <img src="<?php echo $ruta; ?>" alt="img">
                                        </td>
                                        <td class="col-titulo"><?php echo $prod['TITULO']; ?></td>
                                        <td class="col-precio"><?php echo $prod['PRECIO']; ?> €</td>
                                        <td class="col-acciones">
                                            <a href="editar_producto.php?id=<?php echo $prod['ID_PRODUCTO']; ?>" class="btn-editar">EDITAR</a>
                                            <a href="gestionar_productos.php?borrar=<?php echo $prod['ID_PRODUCTO']; ?>" class="btn-eliminar" 
                                               onclick="return confirm('¿Eliminar <?php echo $prod['TITULO']; ?>?')">BORRAR</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
        
    </div>

</body>
</html>