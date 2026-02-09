<?php
$user = "InformatikAlmi";
$password = "Almi12345";
$bbdd = "192.168.0.152/ORCLCDB"; 
//$bbdd = "192.168.0.136/ORCLCDB"; 
//$bbdd = "192.168.1.131/ORCLCDB";

$conexion = oci_connect($user, $password, $bbdd, 'AL32UTF8');

if (!$conexion) {
    $e = oci_error();
    die("Error de conexión a Oracle: " . $e['message']);
}

function cerrarConexion($conn) {
    oci_close($conn);
}
?>