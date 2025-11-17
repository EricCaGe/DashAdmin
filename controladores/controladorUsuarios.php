<?php
// CONEXIÓN A BASE DE DATOS
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena_";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// MANEJAR ELIMINACIÓN DE CLIENTE
if(isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM clientes WHERE idcliente = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        echo "<script>window.location.href = 'index.php?page=clientes&mensaje=Cliente+eliminado+correctamente';</script>";
        exit();
    } else {
        echo "<script>window.location.href = 'index.php?page=clientes&error=Error+al+eliminar+el+cliente';</script>";
        exit();
    }
}

// MANEJAR GUARDAR/ACTUALIZAR CLIENTE
if($_POST && isset($_POST['nombre'])) {
    $id = $_POST['idCliente'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    
    // VALIDACIONES
    if(empty($nombre) || empty($direccion) || empty($telefono)) {
        echo "<script>window.location.href = 'index.php?page=clientes&error=Nombre,+dirección+y+teléfono+son+obligatorios';</script>";
        exit();
    }
    
    if(empty($id)) {
        // INSERTAR NUEVO CLIENTE
        $stmt = $conexion->prepare("INSERT INTO clientes (nombre, direccion, telefono) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $direccion, $telefono);
    } else {
        // ACTUALIZAR CLIENTE EXISTENTE
        $stmt = $conexion->prepare("UPDATE clientes SET nombre=?, direccion=?, telefono=? WHERE idcliente=?");
        $stmt->bind_param("sssi", $nombre, $direccion, $telefono, $id);
    }
    
    if($stmt->execute()) {
        echo "<script>window.location.href = 'index.php?page=clientes&mensaje=Cliente+guardado+correctamente';</script>";
        exit();
    } else {
        echo "<script>window.location.href = 'index.php?page=clientes&error=Error+al+guardar+el+cliente';</script>";
        exit();
    }
    $stmt->close();
}

// OBTENER TODOS LOS CLIENTES
$sql = "SELECT idcliente, nombre, direccion, telefono FROM clientes ORDER BY idcliente";
$resultado = $conexion->query($sql);
$clientes = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

$conexion->close();

// OBTENER MENSAJES
$mensaje = $_GET['mensaje'] ?? '';
$error = $_GET['error'] ?? '';

// INCLUIR LA VISTA
include 'pages/clientes.php';
?>