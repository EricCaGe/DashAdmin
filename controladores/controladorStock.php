<?php
// CONEXIÓN A BASE DE DATOS
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// MANEJAR ELIMINACIÓN DE PRODUCTO
if(isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM producto WHERE idproducto = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: index.php?page=stock&mensaje=Producto+eliminado+correctamente");
        exit();
    } else {
        header("Location: index.php?page=stock&error=Error+al+eliminar+el+producto");
        exit();
    }
}

// MANEJAR GUARDAR/ACTUALIZAR PRODUCTO
if($_POST && isset($_POST['nombre'])) {
    $id = $_POST['idProducto'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $precio = floatval($_POST['precio'] ?? 0);
    
    // VALIDACIONES
    if(empty($nombre) || $cantidad < 0 || $precio <= 0) {
        header("Location: index.php?page=stock&error=Datos+inválidos");
        exit();
    }
    
    if(empty($id)) {
        // INSERTAR NUEVO PRODUCTO - CORREGIDO: "sid" en lugar de "sii"
        $stmt = $conexion->prepare("INSERT INTO producto (nombreproducto, cantidad, precio) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $nombre, $cantidad, $precio);
    } else {
        // ACTUALIZAR PRODUCTO EXISTENTE - CORREGIDO: "sidi" en lugar de "siii"
        $stmt = $conexion->prepare("UPDATE producto SET nombreproducto=?, cantidad=?, precio=? WHERE idproducto=?");
        $stmt->bind_param("sidi", $nombre, $cantidad, $precio, $id);
    }
    
    if($stmt->execute()) {
        header("Location: index.php?page=stock&mensaje=Producto+guardado+correctamente");
        exit();
    } else {
        header("Location: index.php?page=stock&error=Error+al+guardar+el+producto");
        exit();
    }
    $stmt->close();
}

// OBTENER TODOS LOS PRODUCTOS
$sql = "SELECT idproducto, nombreproducto, precio, cantidad FROM producto ORDER BY idproducto";
$resultado = $conexion->query($sql);
$productos = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

$conexion->close();

// OBTENER MENSAJES
$mensaje = $_GET['mensaje'] ?? '';
$error = $_GET['error'] ?? '';

// INCLUIR LA VISTA - RUTA CORREGIDA
include 'pages/stock.php';
?>