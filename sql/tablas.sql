CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Vehiculo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NOT NULL,
    tipo ENUM('Coche', 'Moto', 'Camión', 'Furgoneta', 'Otro') DEFAULT 'Coche',
    precio DECIMAL(8,2) CHECK (precio >= 0 AND precio <= 999999.99),
    descripcion TEXT,
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);