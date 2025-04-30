<?php include 'header.php'; ?>
<div class="container">
    <h2>Registro de Paciente</h2>
    <form action="registrarUsuario.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="text" name="dni" placeholder="DNI" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</div>
<?php include 'footer.php'; ?>
