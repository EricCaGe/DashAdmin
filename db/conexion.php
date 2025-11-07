<?php
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>