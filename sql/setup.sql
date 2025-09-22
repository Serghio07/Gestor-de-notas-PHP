-- Script para crear la base de datos y tabla de notas
-- Mini aplicación de gestión de notas personales

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS notes_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE notes_app;

-- Crear tabla de notas
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    important TINYINT(1) DEFAULT 0,
    INDEX idx_created_at (created_at),
    INDEX idx_important (important)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


INSERT INTO notes (title, content, important) VALUES
('Primera nota', 'Esta es mi primera nota de ejemplo. Puedes editarla o eliminarla cuando quieras.', 0),
('Nota importante', 'Esta es una nota marcada como importante. No olvides revisar estas notas especiales.', 1),
('Ideas para el proyecto', 'Aquí puedo anotar todas las ideas que se me ocurran para mejorar la aplicación de notas.', 0);