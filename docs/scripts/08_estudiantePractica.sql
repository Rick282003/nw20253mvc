CREATE TABLE incidentes_estudiantiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_nombre VARCHAR(100) NOT NULL,
    fecha_incidente DATE NOT NULL,
    tipo_incidente VARCHAR(100) NOT NULL,
    descripcion TEXT,
    accion_tomada VARCHAR(255),
    estado VARCHAR(20) DEFAULT 'Abierto'
);