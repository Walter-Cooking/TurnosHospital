<?php include 'header.php'; ?>

<div class="container">
    <h2>Solicitar un Nuevo Turno</h2>
    
    <form id="form-solicitud" action="procesarturno.php" method="POST">
        <div class="section-title">
            <h3>Información Personal</h3>
        </div>
        
        <div class="form-group">
            <label for="nombre">Nombre completo *</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div class="form-group">
            <label for="dni">DNI/Documento *</label>
            <input type="text" id="dni" name="dni" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="section-title">
            <h3>Información del Turno</h3>
        </div>
        
        <div class="form-group">
            <label for="tipo_turno">Tipo de consulta *</label>
            <select id="tipo_turno" name="tipo_turno" required>
                <option value="">Seleccione una opción</option>
                <option value="clinica">Clínica Médica</option>
                <option value="pediatria">Pediatría</option>
                <option value="traumatologia">Traumatología</option>
                <option value="cardiologia">Cardiología</option>
                <option value="dermatologia">Dermatología</option>
                <option value="oftalmologia">Oftalmología</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha">Fecha *</label>
            <input type="date" id="fecha" name="fecha" required>
        </div>
        
        <div class="form-group">
            <label for="hora">Hora *</label>
            <select id="hora" name="hora" required>
                <option value="">Seleccione un horario</option>
                <option value="08:00">08:00</option>
                <option value="08:30">08:30</option>
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
                <option value="18:30">18:30</option>
                <option value="19:00">19:00</option>
            </select>
        </div>
        
        <div id="resultado-disponibilidad"></div>
        
        <div class="form-group">
            <label for="observaciones">Observaciones (opcional)</label>
            <textarea id="observaciones" name="observaciones" rows="3"></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" id="btn-confirmar" class="btn">Confirmar Turno</button>
        </div>
    </form>
</div>

<style>
    textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        font-family: 'Arial', sans-serif;
    }
    
    .section-title {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title h3 {
        color: #444;
        font-size: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .form-actions {
        margin-top: 2rem;
    }
</style>

<?php include 'footer.php'; ?>