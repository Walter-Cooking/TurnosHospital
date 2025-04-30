<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Turnos - Hospital</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="java/script.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul class="nav-left">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="solicitarTurno.php">Solicitar Turno</a></li>
                <li><a href="consultarTurno.php">Consultar Turno</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
            <ul class="nav-right">
                <?php if (isset($_SESSION['nombre'])): ?>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

