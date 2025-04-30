<?php 
include 'header.php';

$mensaje = '';
$tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // En un sistema real, aquí procesaríamos el envío del formulario
    // Por ejemplo, enviando un email o guardando en base de datos
    $mensaje = "Su mensaje ha sido enviado correctamente. Nos pondremos en contacto con usted lo antes posible.";
    $tipo = "success";
}
?>

<div class="container">
    <h2>Contacto</h2>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo $tipo; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    
    <div class="contact-info">
        <div class="contact-details">
            <h3>Información de Contacto</h3>
            <p><strong>Dirección:</strong> Av. Hospital 1234, Ciudad</p>
            <p><strong>Teléfono:</strong> (011) 4567-8900</p>
            <p><strong>Email:</strong> contacto@hospital.com</p>
            <p><strong>Horario de atención:</strong></p>
            <ul>
                <li>Lunes a Viernes: 8:00 - 20:00</li>
                <li>Sábados: 8:00 - 14:00</li>
                <li>Domingos: Solo emergencias</li>
            </ul>
        </div>
        
        <div class="contact-form">
            <h3>Envíenos un mensaje</h3>
            <form method="POST" action="contacto.php">
                <div class="form-group">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="asunto">Asunto *</label>
                    <input type="text" id="asunto" name="asunto" required>
                </div>
                
                <div class="form-group">
                    <label for="mensaje">Mensaje *</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn">Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
    }
    
    .contact-details, .contact-form {
        flex: 1;
        min-width: 300px;
    }
    
    .contact-details ul {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 1.5rem;
    }
    
    .contact-details ul li {
        margin-bottom: 0.5rem;
        padding-left: 1.5rem;
        position: relative;
    }
    
    .contact-details ul li:before {
        content: "•";
        position: absolute;
        left: 0;
        color: #0066cc;
    }
    
    textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        resize: vertical;
    }
</style>

<?php include 'footer.php'; ?>