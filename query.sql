-- Crear base de datos y tablas
CREATE DATABASE IF NOT EXISTS artean CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE artean;

CREATE TABLE equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    estadio VARCHAR(100) NOT NULL
);

CREATE TABLE partidos (
    id_partido INT AUTO_INCREMENT PRIMARY KEY,
    id_local INT NOT NULL,
    id_visitante INT NOT NULL,
    resultado CHAR(1) CHECK (resultado IN ('1','X','2')),
    estadio VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_local) REFERENCES equipos(id_equipo),
    FOREIGN KEY (id_visitante) REFERENCES equipos(id_equipo),
    UNIQUE (id_local, id_visitante)
);

-- Datos de ejemplo
INSERT INTO equipos (nombre, estadio) VALUES
('Athletic Club', 'San Mamés'),
('Real Sociedad', 'Anoeta'),
('Osasuna', 'El Sadar');

INSERT INTO partidos (id_local, id_visitante, resultado, estadio) VALUES
(1, 2, '1', 'San Mamés'),
(3, 1, 'X', 'El Sadar');
