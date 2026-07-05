
CREATE DATABASE IF NOT EXISTS bd_ventas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bd_ventas;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apePaterno VARCHAR(100) NOT NULL,
    apeMaterno VARCHAR(100) NOT NULL,
    user VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


INSERT INTO usuarios (nombre, apePaterno, apeMaterno, user, password, estado) VALUES
('Alex', 'Perez', 'Gomez', 'Aperez', SHA2('12345', 256), 1),
('Mia', 'Lopez', 'Diaz', 'mlopez', SHA2('12345', 256), 1);
