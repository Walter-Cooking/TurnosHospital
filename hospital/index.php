<?php include 'header.php'; ?>

<div class="container">
    <h2>Bienvenido al Sistema de Gestión de Turnos del Hospital</h2>
    
    <div class="welcome-content">
        <h4>Nuestro sistema le permite gestionar sus turnos médicos de manera rápida y eficiente, sin necesidad de acercarse físicamente al hospital.</h4>

        <div class="options-container">
            <div class="option-card">
                <h3>Solicitar un Turno</h3>
                <p>Solicite un nuevo turno médico completando un simple formulario con sus datos personales.</p>
                <a href="solicitarTurno.php" class="btn">Solicitar Turno</a>
            </div>
            
            <div class="option-card">
                <h3>Consultar un Turno</h3>
                <p>Verifique el estado de sus turnos existentes ingresando su DNI.</p>
                <a href="consultarTurno.php" class="btn">Consultar Turno</a>
            </div>
            
            <div class="option-card">
                <h3>Contacto</h3>
                <p>¿Tiene alguna duda o problema? Contáctenos y le responderemos a la brevedad.</p>
                <a href="contacto.php" class="btn">Contactar</a>
            </div>
        </div>
        
        <div class="info-section">
            <h3>Horarios de Atención</h3>
            <p>Lunes a Viernes: 8:00 - 20:00</p>
            <p>Sábados: 8:00 - 14:00</p>
            <p>Domingos: Cerrado (Solo emergencias)</p>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>
