<?php
// Incluir archivo de configuración de base de datos
include 'php/db.php';

// Configurar encabezados para JSON
header('Content-Type: application/json');

// Inicializar respuesta
$respuesta = [
    'disponible' => false,
    'mensaje' => ''
];

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar datos
    $tipo_turno = mysqli_real_escape_string($conn, $_POST['tipo_turno'] ?? '');
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha'] ?? '');
    $hora = mysqli_real_escape_string($conn, $_POST['hora'] ?? '');
    
    // Validar datos
    if (empty($tipo_turno) || empty($fecha) || empty($hora)) {
        $respuesta['mensaje'] = 'Todos los campos son obligatorios';
    } else {
        // Formatear fecha y hora para la base de datos
        $datetime = $fecha . ' ' . $hora . ':00';
        
        // Verificar disponibilidad en la base de datos
        $sql = "SELECT COUNT(*) as total FROM turnos WHERE tipo_turno = ? AND horario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $tipo_turno, $datetime);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        
        // Verificar resultado
        if ($row['total'] == 0) {
            $respuesta['disponible'] = true;
            $respuesta['mensaje'] = 'Horario disponible';
        } else {
            $respuesta['mensaje'] = 'Horario no disponible';
        }
    }
}

// Devolver respuesta como JSON
echo json_encode($respuesta);
?>