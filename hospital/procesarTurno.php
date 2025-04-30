<?php
include 'php/db.php';
include 'header.php';

// Inicializar variables
$turno_guardado = false;
$mensaje_error = '';
$datos_turno = [];

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre'] ?? '');
    $dni = mysqli_real_escape_string($conn, $_POST['dni'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $tipo_turno = mysqli_real_escape_string($conn, $_POST['tipo_turno'] ?? '');
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha'] ?? '');
    $hora = mysqli_real_escape_string($conn, $_POST['hora'] ?? '');
    $observaciones = mysqli_real_escape_string($conn, $_POST['observaciones'] ?? '');
    
    // Validar datos
    if (empty($nombre) || empty($dni) || empty($email) || empty($tipo_turno) || empty($fecha) || empty($hora)) {
        $mensaje_error = "Todos los campos marcados con * son obligatorios.";
    } else {
        // Formatear fecha y hora para la base de datos
        $datetime = $fecha . ' ' . $hora . ':00';
        
        // Verificar disponibilidad
        $sql_disponibilidad = "SELECT COUNT(*) as total FROM turnos WHERE tipo_turno = ? AND horario = ?";
        $stmt_disponibilidad = $conn->prepare($sql_disponibilidad);
        $stmt_disponibilidad->bind_param("ss", $tipo_turno, $datetime);
        $stmt_disponibilidad->execute();
        $resultado_disponibilidad = $stmt_disponibilidad->get_result();
        $row_disponibilidad = $resultado_disponibilidad->fetch_assoc();
        
        if ($row_disponibilidad['total'] > 0) {
            $mensaje_error = "Lo sentimos, el horario seleccionado ya no está disponible. Por favor, elija otro horario.";
        } else {
            // Iniciar transacción
            $conn->begin_transaction();
            try {
                // Verificar si el paciente ya existe
                $sql_paciente = "SELECT id FROM pacientes WHERE dni = ?";
                $stmt_paciente = $conn->prepare($sql_paciente);
                $stmt_paciente->bind_param("s", $dni);
                $stmt_paciente->execute();
                $resultado_paciente = $stmt_paciente->get_result();
                
                if ($resultado_paciente->num_rows > 0) {
                    // Paciente existente
                    $row_paciente = $resultado_paciente->fetch_assoc();
                    $paciente_id = $row_paciente['id'];
                    
                    // Actualizar datos del paciente
                    $sql_update = "UPDATE pacientes SET nombre = ?, email = ? WHERE id = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("ssi", $nombre, $email, $paciente_id);
                    $stmt_update->execute();
                } else {
                    // Nuevo paciente
                    $sql_insert = "INSERT INTO pacientes (nombre, dni, email) VALUES (?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("sss", $nombre, $dni, $email);
                    $stmt_insert->execute();
                    $paciente_id = $conn->insert_id;
                }
                
                // Insertar el turno
                $sql_turno = "INSERT INTO turnos (paciente_id, tipo_turno, horario) VALUES (?, ?, ?)";
                $stmt_turno = $conn->prepare($sql_turno);
                $stmt_turno->bind_param("iss", $paciente_id, $tipo_turno, $datetime);
                $stmt_turno->execute();
                $turno_id = $conn->insert_id;
                
                // Guardar datos para mostrar en el comprobante
                $datos_turno = [
                    'id' => $turno_id,
                    'nombre' => $nombre,
                    'dni' => $dni,
                    'email' => $email,
                    'tipo_turno' => $tipo_turno,
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'observaciones' => $observaciones
                ];
                
                // Confirmar transacción
                $conn->commit();
                $turno_guardado = true;
                
            } catch (Exception $e) {
                // Revertir transacción en caso de error
                $conn->rollback();
                $mensaje_error = "Ha ocurrido un error al procesar su solicitud. Por favor, inténtelo nuevamente.";
            }
        }
    }
}
?>

<div class="container">
    <?php if ($turno_guardado): ?>
        <div class="alert alert-success">
            ¡Su turno ha sido registrado correctamente!
        </div>
        
        <div class="comprobante">
            <h3>Comprobante de Turno</h3>
            <p><strong>Número de turno:</strong> <?php echo $datos_turno['id']; ?></p>
            <p><strong>Paciente:</strong> <?php echo htmlspecialchars($datos_turno['nombre']); ?></p>
            <p><strong>DNI:</strong> <?php echo htmlspecialchars($datos_turno['dni']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($datos_turno['email']); ?></p>
            <p><strong>Tipo de consulta:</strong> 
                <?php 
                $tipos = [
                    'clinica' => 'Clínica Médica',
                    'pediatria' => 'Pediatría',
                    'traumatologia' => 'Traumatología',
                    'cardiologia' => 'Cardiología',
                    'dermatologia' => 'Dermatología',
                    'oftalmologia' => 'Oftalmología'
                ];
                echo $tipos[$datos_turno['tipo_turno']] ?? $datos_turno['tipo_turno'];
                ?>
            </p>
            <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($datos_turno['fecha'])); ?></p>
            <p><strong>Hora:</strong> <?php echo $datos_turno['hora']; ?></p>
            
            <?php if (!empty($datos_turno['observaciones'])): ?>
                <p><strong>Observaciones:</strong> <?php echo htmlspecialchars($datos_turno['observaciones']); ?></p>
            <?php endif; ?>
            
            <div class="comprobante-info">
                <p><em>Recuerde presentarse 15 minutos antes de su turno con su DNI.</em></p>
                <p><em>Si necesita cancelar o reprogramar su turno, comuníquese con nosotros con al menos 24 horas de anticipación.</em></p>
            </div>
            
            <div class="comprobante-actions">
                <button onclick="window.print()" class="btn">Imprimir Comprobante</button>
                <a href="index.php" class="btn">Volver al Inicio</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <?php echo $mensaje_error; ?>
        </div>
        <p>Ha ocurrido un error al procesar su solicitud. Por favor, <a href="solicitarTurno.php">vuelva a intentarlo</a>.</p>
    <?php endif; ?>
</div>

<style>
    .comprobante-info {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px dashed #ddd;
    }
    
    .comprobante-actions {
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
    }
    
    @media print {
        header, footer, .comprobante-actions, .alert {
            display: none;
        }
        
        body, .container, .comprobante {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        
        .comprobante {
            border: none;
        }
    }
</style>

<?php include 'footer.php'; ?>