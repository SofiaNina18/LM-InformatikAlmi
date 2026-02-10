<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

include_once 'bbdd.php';

$mostrar_registro = false; 
$campo_error = "";         
$mensaje_error = "";       

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion']) && $_POST['accion'] == 'login') {
        $usuario_form = $_POST['usuario'];
        $password_form = $_POST['password'];
        
        $sql = "SELECT * FROM PROVEEDORES WHERE USUARIO = :u AND CONTRASEÑA = :p";
        $stmt = oci_parse($conexion, $sql);
        oci_bind_by_name($stmt, ":u", $usuario_form);
        oci_bind_by_name($stmt, ":p", $password_form);
        oci_execute($stmt);

        if ($fila = oci_fetch_assoc($stmt)) {
            $_SESSION['usuario'] = $fila['USUARIO']; 
            header("Location: index.php"); 
            exit;
        } else {
            $mensaje_error = "Usuario o contraseña incorrectos.";
            $campo_error = "login_general";
        }
    }

    if (isset($_POST['accion']) && $_POST['accion'] == 'registro') {
        $mostrar_registro = true; 

        $u = $_POST['usuario_reg'];
        $p = $_POST['password_reg'];
        $nif = $_POST['nif'];
        $emp = $_POST['empresa'];
        $dir = $_POST['direccion'];
        $pais = $_POST['pais'];
        $prov = $_POST['provincia'];
        $ciu = $_POST['ciudad'];
        
        $tel = trim($_POST['telefono']);
        
        if (strpos($tel, '+') !== 0) {
            $tel = "+34 " . $tel;
        }
        
        if (strlen($tel) < 9) {
            $campo_error = "telefono";
            $mensaje_error = "El número de teléfono es demasiado corto.";
        } 
        else {
            $sql = "INSERT INTO PROVEEDORES (USUARIO, CONTRASEÑA, NIF, NOMBRE_EMPRESA, DIRECCION, PAIS, PROVINCIA, CIUDAD, TELEFONO) 
                    VALUES (:u, :p, :nif, :emp, :dir, :pais, :prov, :ciu, :tel)";
            
            $stmt = oci_parse($conexion, $sql);
            oci_bind_by_name($stmt, ":u", $u);
            oci_bind_by_name($stmt, ":p", $p);
            oci_bind_by_name($stmt, ":nif", $nif);
            oci_bind_by_name($stmt, ":emp", $emp);
            oci_bind_by_name($stmt, ":dir", $dir);
            oci_bind_by_name($stmt, ":pais", $pais);
            oci_bind_by_name($stmt, ":prov", $prov);
            oci_bind_by_name($stmt, ":ciu", $ciu);
            oci_bind_by_name($stmt, ":tel", $tel);

            if (@oci_execute($stmt)) {
                $_SESSION['usuario'] = $u;
                header("Location: index.php");
                exit;
            } else {
                $e = oci_error($stmt);
                
                if ($e['code'] == 1) { 
                    if (strpos($e['message'], 'UK_PROVEEDOR_USUARIO') !== false) {
                        $campo_error = "usuario_reg";
                        $mensaje_error = "Usuario ya está ocupado.";
                    } elseif (strpos($e['message'], 'UK_PROVEEDOR_NIF') !== false) {
                        $campo_error = "nif";
                        $mensaje_error = "Este NIF ya está registrado en el sistema.";
                    } else {
                        $campo_error = "general";
                        $mensaje_error = "Datos duplicados (Usuario o NIF).";
                    }
                } else {
                    $campo_error = "general";
                    $mensaje_error = "Error: " . $e['message'];
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Proveedores</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/iniciar-usuario.css"> 
    <link rel="shortcut icon" href="images/logSayo.ico" type="image/x-icon">
</head>
<body class="iniciar-sesion">

    <?php include 'menu.php'; ?>

    <div class="formulario-iniciar-sesion <?php echo ($mostrar_registro) ? 'activar-registro' : ''; ?>" id="contenedor">
        
        <div class="ambos-formularios caja-registro">
            <form action="iniciar-usuario.php" method="POST" id="formRegistro">
                <h1>Crear Cuenta</h1>
                <span>Datos de la empresa proveedora</span>
                
                <div class="meter-datos">
                    <input type="text" name="usuario_reg" placeholder="Usuario" required 
                           value="<?php echo isset($_POST['usuario_reg']) ? htmlspecialchars($_POST['usuario_reg']) : ''; ?>" />
                    
                    <input type="password" name="password_reg" placeholder="Contraseña" required />
                    
                    <input type="text" name="empresa" placeholder="Nombre Empresa" required 
                           value="<?php echo isset($_POST['empresa']) ? htmlspecialchars($_POST['empresa']) : ''; ?>"/>
                           
                    <input type="text" name="nif" placeholder="NIF / CIF" required 
                           value="<?php echo isset($_POST['nif']) ? htmlspecialchars($_POST['nif']) : ''; ?>"/>
                    
                    <input type="text" name="telefono" placeholder="Teléfono (+34...)"
                           value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>"/>
                           
                    <input type="text" name="pais" placeholder="País" 
                           value="<?php echo isset($_POST['pais']) ? htmlspecialchars($_POST['pais']) : ''; ?>"/>
                    
                    <input type="text" name="provincia" placeholder="Provincia" 
                           value="<?php echo isset($_POST['provincia']) ? htmlspecialchars($_POST['provincia']) : ''; ?>"/>
                           
                    <input type="text" name="ciudad" placeholder="Ciudad" 
                           value="<?php echo isset($_POST['ciudad']) ? htmlspecialchars($_POST['ciudad']) : ''; ?>"/>
                    
                    <input type="text" name="direccion" placeholder="Dirección Completa" class="ancho-completo" 
                           value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>"/>
                </div>

                <input type="hidden" name="accion" value="registro">
                
                <button type="submit">REGISTRARSE</button>
            </form>
        </div>

        <div class="ambos-formularios caja-login">
            <form action="iniciar-usuario.php" method="POST">
                <h1>Iniciar Sesión</h1>
                <span>Acceso Proveedores</span>
                
                <div class="espacio"></div>

                <?php if($campo_error == 'login_general'): ?>
                    <p class="error-texto"><?php echo $mensaje_error; ?></p>
                <?php endif; ?>

                <input type="text" name="usuario" placeholder="Usuario" required />
                <input type="password" name="password" placeholder="Contraseña" required />
                <input type="hidden" name="accion" value="login">
                
                <div class="espacio"></div> 

                <button type="submit">ENTRAR</button>
            </form>
        </div>

        <div class="crear-cuenta">
            <div class="capa-deslizante">
                <div class="texto-crear-cuenta texto-izquierdo">
                    <h1>¡Bienvenido!</h1>
                    <p>Si ya tienes cuenta, inicia sesión para gestionar tus productos.</p>
                    <button class="transparente" id="irALogin">Ir a Iniciar Sesión</button>
                </div>
                <div class="texto-crear-cuenta texto-derecho">
                    <h1>¡Únete a SAYO!</h1>
                    <p>¿Nuevo proveedor? Regístrate aquí para empezar a vender.</p>
                    <button class="transparente" id="irARegistro">Crear Cuenta</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/iniciar-registrarse.js"></script>

    <?php if ($mostrar_registro && !empty($campo_error) && !empty($mensaje_error)): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputFallo = document.querySelector('input[name="<?php echo $campo_error; ?>"]');
            
            if (inputFallo) {
                inputFallo.setCustomValidity("<?php echo $mensaje_error; ?>");
                inputFallo.reportValidity();
                
                inputFallo.addEventListener('input', function() {
                    this.setCustomValidity('');
                });
            } else {
                alert("<?php echo $mensaje_error; ?>");
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>