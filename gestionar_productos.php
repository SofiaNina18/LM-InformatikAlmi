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

    <div class="tabla-gestion">
        <h1>Modificar / Eliminar Productos</h1>

        <div class="contenido">
            <table>
                <thead>
                    <tr>
                        <th>IMAGEN</th>
                        <th>TÍTULO DEL PRODUCTO</th>
                        <th>PRECIO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM PRODUCTOS ORDER BY id_categoria ASC, id_producto DESC";
                    $stmt = oci_parse($conexion, $sql);
                    oci_execute($stmt);

                    while ($prod = oci_fetch_assoc($stmt)) {
                        echo "<tr>";
                        
                        $ruta = !empty($prod['IMAGEN']) ? $prod['IMAGEN'] : 'images/sin_imagen.png';
                        
                        echo "<td class='col-img'><img src='$ruta' alt='Producto'></td>";
                        echo "<td class='col-titulo'>{$prod['TITULO']}</td>";
                        echo "<td class='col-precio'>{$prod['PRECIO']} €</td>";
                        
                        echo "<td class='col-acciones'>
                                <a href='editar_producto.php?id={$prod['ID_PRODUCTO']}' class='editar-producto'>MODIFICAR</a> | 
                                <a href='gestionar_productos.php?borrar={$prod['ID_PRODUCTO']}' class='eliminar-producto' onclick='return confirm(\"¿Estás seguro de borrar este producto? Se borrará de todos los pedidos y galerías.\")'>ELIMINAR</a>
                              </td>";
                        
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>