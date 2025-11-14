CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    director VARCHAR(100) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    anio_estreno YEAR NOT NULL,
    duracion INT NOT NULL, -- minutos
    sinopsis TEXT,
    clasificacion VARCHAR(10),
    estado VARCHAR(20) DEFAULT 'Disponible'
);