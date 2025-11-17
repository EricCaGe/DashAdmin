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

// MANEJAR ELIMINACIÓN DE EMPLEADO
if(isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM empleados WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        echo "<script>window.location.href = 'index.php?page=empleados&mensaje=Empleado+eliminado+correctamente';</script>";
        exit();
    } else {
        echo "<script>window.location.href = 'index.php?page=empleados&error=Error+al+eliminar+el+empleado';</script>";
        exit();
    }
}

// MANEJAR GUARDAR/ACTUALIZAR EMPLEADO
if($_POST && isset($_POST['usuario'])) {
    $id = $_POST['idEmpleado'] ?? '';
    $usuario = trim($_POST['usuario'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $ocupacion = trim($_POST['ocupacion'] ?? 'empleado');
    
    // VALIDACIONES
    if(empty($usuario) || empty($correo)) {
        echo "<script>window.location.href = 'index.php?page=empleados&error=Usuario+y+correo+son+obligatorios';</script>";
        exit();
    }
    
    if(empty($id)) {
        // INSERTAR NUEVO EMPLEADO
        if(empty($contrasena)) {
            echo "<script>window.location.href = 'index.php?page=empleados&error=La+contraseña+es+obligatoria+para+nuevos+empleados';</script>";
            exit();
        }
        $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("INSERT INTO empleados (usuario, correo_telefono, contrasena, ocupacion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $usuario, $correo, $hash_contrasena, $ocupacion);
    } else {
        // ACTUALIZAR EMPLEADO EXISTENTE
        if(empty($contrasena)) {
            $stmt = $conexion->prepare("UPDATE empleados SET usuario=?, correo_telefono=?, ocupacion=? WHERE id=?");
            $stmt->bind_param("sssi", $usuario, $correo, $ocupacion, $id);
        } else {
            $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("UPDATE empleados SET usuario=?, correo_telefono=?, contrasena=?, ocupacion=? WHERE id=?");
            $stmt->bind_param("ssssi", $usuario, $correo, $hash_contrasena, $ocupacion, $id);
        }
    }
    
    if($stmt->execute()) {
        echo "<script>window.location.href = 'index.php?page=empleados&mensaje=Empleado+guardado+correctamente';</script>";
        exit();
    } else {
        echo "<script>window.location.href = 'index.php?page=empleados&error=Error+al+guardar+el+empleado';</script>";
        exit();
    }
    $stmt->close();
}

// OBTENER TODOS LOS EMPLEADOS
$sql = "SELECT id, usuario, correo_telefono, ocupacion FROM empleados ORDER BY id";
$resultado = $conexion->query($sql);
$empleados = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

$conexion->close();

// OBTENER MENSAJES
$mensaje = $_GET['mensaje'] ?? '';
$error = $_GET['error'] ?? '';

// INCLUIR LA VISTA
include 'pages/empleados.php';
?>