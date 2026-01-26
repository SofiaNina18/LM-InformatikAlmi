<?php

$user = "InformatikAlmi";
$password = "Almi12345";
$bbdd   = "192.168.0.136/ORCLCDB";

$conexion = oci_connect($user, $password, $bbdd, 'AL32UTF8');

if (!$conexion) {
    $error = oci_error();
    echo "Error: " . $error['message'];
} else {
    echo "<h1>¡Conexión lista!</h1>";
    echo "Ya se puede editar.";
}
?>
