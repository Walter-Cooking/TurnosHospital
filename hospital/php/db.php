<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";       // Cambia esto según tu configuración
$password = "";           // Cambia esto según tu configuración
$dbname = "hospital_turnos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>