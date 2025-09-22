CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    important TINYINT(1) DEFAULT 0
);

INSERT INTO notes (title, content, important) VALUES
('Nota desde Docker', 'Esta aplicación funciona con Docker!', 1),
('Segunda nota', 'Todo está funcionando correctamente.', 0);