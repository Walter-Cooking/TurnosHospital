<?php
include 'php/db.php';

$nombre = $_POST['nombre'];
$dni = $_POST['dni'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO pacientes (nombre, dni, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $dni, $email, $password);

if ($stmt->execute()) {
    header("Location: login.php?registro=ok");
} else {
    echo "Error al registrar: " . $conn->error;
}
?>
