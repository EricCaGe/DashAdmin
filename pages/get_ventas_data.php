<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener ventas por producto
$sql = "SELECT nombreproducto, SUM(cantidad_vendida) as total_vendido 
        FROM ventas 
        GROUP BY nombreproducto 
        ORDER BY total_vendido DESC 
        LIMIT 6";
$resultado = $conexion->query($sql);

$productos = [];
$ventas = [];

if ($resultado && $resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila['nombreproducto'];
        $ventas[] = $fila['total_vendido'];
    }
} else {
    // Datos de ejemplo si no hay ventas
    $productos = ['Tacos', 'Quesadillas', 'Burritos', 'Bebidas', 'Tortas', 'Postres'];
    $ventas = [45, 30, 20, 25, 15, 10];
}

header('Content-Type: application/json');
echo json_encode([
    'productos' => $productos,
    'ventas' => $ventas
]);
?>