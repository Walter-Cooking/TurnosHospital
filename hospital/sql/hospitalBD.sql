-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS hospital_turnos;
USE hospital_turnos;

-- Crear tabla de pacientes
CREATE TABLE IF NOT EXISTS pacientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  dni INT NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Crear tabla de turnos
CREATE TABLE IF NOT EXISTS turnos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  paciente_id INT NOT NULL,
  tipo_turno VARCHAR(50) NOT NULL,
  horario DATETIME NOT NULL,
  estado ENUM('pendiente', 'completado', 'cancelado') DEFAULT 'pendiente',
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

-- Crear índices para mejorar el rendimiento de las consultas
CREATE INDEX idx_paciente_dni ON pacientes(dni);
CREATE INDEX idx_turno_horario ON turnos(horario);
CREATE INDEX idx_turno_paciente ON turnos(paciente_id);
CREATE INDEX idx_turno_tipo ON turnos(tipo_turno);

-- Insertar algunos datos de ejemplo (opcional)
INSERT INTO pacientes (nombre, dni, email, password) VALUES
('Juan Pérez', 12345678, 'juan.perez@ejemplo.com','12345678'),
('María García', 87654321, 'maria.garcia@ejemplo.com','87654321'),
('Carlos López', 23456789, 'carlos.lopez@ejemplo.com','23456789');

-- Insertar algunos turnos de ejemplo (opcional)
INSERT INTO turnos (paciente_id, tipo_turno, horario) VALUES
(1, 'clinica', '2025-05-02 09:00:00'),
(2, 'pediatria', '2025-05-02 10:00:00'),
(3, 'traumatologia', '2025-05-03 11:00:00');