    <?php
    session_start();
    session_unset();   // Borra todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: index.php");  // Redirige al usuario a la página principal
    exit();
    ?>
