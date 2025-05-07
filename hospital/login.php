<?php include 'header.php'; ?>
<div class="container">
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_GET['error'])): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?php
            if ($_GET['error'] == 'usuario') {
                echo "⚠️ Usuario no encontrado.";
            } elseif ($_GET['error'] == 'clave') {
                echo "⚠️ Contraseña incorrecta.";
            }
            ?>
        </div>
    <?php endif; ?>

    <form action="validarLogin.php" method="POST">
        <input type="text" name="dni" placeholder="DNI" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
<?php include 'footer.php'; ?>
