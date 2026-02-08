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
        if (file_exists($fila['IMAGEN'])) {
            unlink($fila['IMAGEN']); 
        }
    }
    $sql_del = "DELETE FROM PRODUCTOS WHERE id_producto = :id";
    $stmt_del = oci_parse($conexion, $sql_del);
    oci_bind_by_name($stmt_del, ":id", $id_borrar);
    
    if (oci_execute($stmt_del)) {
        header("Location: gestionar_productos.php"); 
        exit;
    } else {
        echo "<script>alert('Error al borrar');</script>";
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
    <link rel="stylesheet" href="css/gestion.css"> </head>
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
                        echo "<td class='col-img'><img src='{$prod['IMAGEN']}' alt='Prod'></td>";
                        echo "<td class='col-titulo'>{$prod['TITULO']}</td>";
                        echo "<td class='col-precio'>{$prod['PRECIO']} €</td>";
                        echo "<td class='col-acciones'>
                                <a href='editar_producto.php?id={$prod['ID_PRODUCTO']}' class='editar'>Modificar</a> | 
                                <a href='gestionar_productos.php?borrar={$prod['ID_PRODUCTO']}' class='eliminar' onclick='return confirm(\"¿Estás seguro de querer borrar este producto?\")'>Eliminar</a>
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