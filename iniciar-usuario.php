<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}


include_once 'bbdd.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
   
    $usuario_form = $_POST['usuario'];
    $password_form = $_POST['password'];

   
    $sql = "SELECT * FROM USUARIOS WHERE nombre_usuario = :u AND password = :p";
    $stmt = oci_parse($conexion, $sql);

    oci_bind_by_name($stmt, ":u", $usuario_form);
    oci_bind_by_name($stmt, ":p", $password_form);
    
    oci_execute($stmt);

    if ($fila = oci_fetch_assoc($stmt)) {
        $_SESSION['usuario'] = $fila['NOMBRE_USUARIO']; 
        header("Location: index.php"); 
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/iniciar-usuario.css"> </head>
<body class="iniciar-sesion">

    <?php include 'menu.php'; ?>

    <div class="formulario">

            <?php if(!empty($error)): ?>
                <p class="mensaje-error"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="iniciar-usuario.php" method="POST">
                <div class="rellenar">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" required placeholder="">
                </div>

                <div class="rellenar">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" required placeholder="">
                </div>

                <button type="submit" class="entrar">ENTRAR</button>
            </form>
        </div>

</body>
</html>