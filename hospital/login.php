<?php include 'header.php'; ?>
<div class="container">
    <h2>Iniciar Sesión</h2>
    <form action="validarLogin.php" method="POST">
        <input type="text" name="dni" placeholder="DNI" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
<?php include 'footer.php'; ?>
