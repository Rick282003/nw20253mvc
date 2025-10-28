CREATE TABLE clientes (
    codigo VARCHAR(10) NOT NULL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(15),
    correo VARCHAR(100),
    estado CHAR(3) DEFAULT 'ACT',
    evaluacion INT CHECK (evaluacion >= 0 AND evaluacion <=100)
)
-- Aqui guardamos los scripts de cada tabla
-- Estos son datos semillas (seed)
INSERT INTO `clientes` (`codigo`, `nombre`, `direccion`, `telefono`, `correo`, `estado`, `evaluacion`) VALUES ('123456', 'Richard Galo', 'Barrio la Benita', '98764345', 'richardgalo2003@gmail.com', 'ACT', 90);