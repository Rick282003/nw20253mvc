-- Tabla: Rutas de Entrega
CREATE TABLE RutasEntrega (
    id_ruta INT AUTO_INCREMENT PRIMARY KEY,
    origen VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    distancia_km DECIMAL(8, 2),
    duracion_min INT
);

-- Caso de uso para Rutas de Entrega
-- Representa rutas de entrega, con información sobre el origen, destino, distancia en kilómetros y duración estimada.
