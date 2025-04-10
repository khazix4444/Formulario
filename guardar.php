<?php
header('Content-Type: application/json');

// CONFIGURACIÓN DE CONEXIÓN
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "contacto_db";

// CONECTAR
$conexion = new mysqli($host, $usuario, $contrasena, $bd);
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    exit;
}

// VALIDAR EN EL SERVIDOR
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $correo === '' || $mensaje === '') {
    echo json_encode(['success' => false, 'error' => 'Campos vacíos']);
    exit;
}

// INSERTAR
$sql = "INSERT INTO mensajes (nombre, correo, mensaje) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre, $correo, $mensaje);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
}

$stmt->close();
$conexion->close();
?>
