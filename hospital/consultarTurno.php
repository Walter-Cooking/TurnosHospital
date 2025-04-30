<?php 
include 'header.php';
include 'php/db.php';

$mensaje = '';
$turnos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'] ?? '';
    
    if (!empty($dni)) {
        // Buscar al paciente por DNI
        $sql = "SELECT p.id, p.nombre, p.dni, p.email FROM pacientes p WHERE p.dni = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $paciente = $resultado->fetch_assoc();
            
            // Obtener los turnos del paciente
            $sql = "SELECT t.id, t.tipo_turno, t.horario FROM turnos t WHERE t.paciente_id = ? ORDER BY t.horario";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $paciente['id']);
            $stmt->execute();
            $resultado_turnos = $stmt->get_result();
            
            if ($resultado_turnos->num_rows > 0) {
                while ($row = $resultado_turnos->fetch_assoc()) {
                    $turnos[] = $row;
                }
            } else {
                $mensaje = "No se encontraron turnos para el DNI proporcionado.";
            }
        } else {
            $mensaje = "No se encontró ningún paciente con el DNI proporcionado.";
        }
    } else {
        $mensaje = "Por favor, ingrese un DNI válido.";
    }
}
?>

<div class="container">
    <h2>Consultar Turnos</h2>
    
    <form method="POST" action="consultarTurno.php">
        <div class="form-group">
            <label for="dni">Ingrese su DNI/Documento</label>
            <input type="text" id="dni" name="dni" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn">Buscar Turnos</button>
        </div>
    </form>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert <?php echo empty($turnos) ? 'alert-danger' : 'alert-success'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($turnos)): ?>
        <div class="result-section">
            <h3>Turnos encontrados para: <?php echo htmlspecialchars($paciente['nombre']); ?></h3>
            
            <table>
                <thead>
                    <tr>
                        <th>ID de Turno</th>
                        <th>Tipo de Consulta</th>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($turnos as $turno): ?>
                        <tr>
                            <td><?php echo $turno['id']; ?></td>
                            <td>
                                <?php 
                                $tipos = [
                                    'clinica' => 'Clínica Médica',
                                    'pediatria' => 'Pediatría',
                                    'traumatologia' => 'Traumatología',
                                    'cardiologia' => 'Cardiología',
                                    'dermatologia' => 'Dermatología',
                                    'oftalmologia' => 'Oftalmología'
                                ];
                                echo $tipos[$turno['tipo_turno']] ?? $turno['tipo_turno'];
                                ?>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($turno['horario'])); ?></td>
                            <td>
                                <?php
                                $fecha_turno = new DateTime($turno['horario']);
                                $fecha_actual = new DateTime();
                                
                                if ($fecha_turno < $fecha_actual) {
                                    echo "<span class='estado finalizado'>Finalizado</span>";
                                } else {
                                    echo "<span class='estado pendiente'>Pendiente</span>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
    .result-section {
        margin-top: 2rem;
    }
    
    .estado {
        padding: 0.3rem 0.6rem;
        border-radius: 3px;
        font-size: 0.85rem;
        font-weight: bold;
    }
    
    .pendiente {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .finalizado {
        background-color: #d4edda;
        color: #155724;
    }
</style>

<?php include 'footer.php'; ?>