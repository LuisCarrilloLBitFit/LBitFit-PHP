CREATE DATABASE IF NOT EXISTS clinica_salud_integral;
USE clinica_salud_integral;

-- Tabla users_data (completa con todos los campos requeridos)
CREATE TABLE users_data (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion TEXT,
    sexo ENUM('Hombre', 'Mujer', 'Otro', 'Prefiero no decir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla users_login (completa)
CREATE TABLE users_login (
    idLogin INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT UNIQUE NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla citas (completa)
CREATE TABLE citas (
    idCita INT AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    fecha_cita DATETIME NOT NULL,
    motivo_cita TEXT NOT NULL,
    especialidad ENUM('Medicina General', 'Pediatría', 'Cardiología', 'Dermatología', 'Ginecología') NOT NULL,
    estado ENUM('pendiente', 'completada', 'cancelada') DEFAULT 'pendiente',
    notas TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla noticias (completa)
CREATE TABLE noticias (
    idNoticia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) UNIQUE NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    texto LONGTEXT NOT NULL,
    resumen VARCHAR(500) NOT NULL,
    fecha DATE NOT NULL,
    idUser INT NOT NULL,
    categoria ENUM('General', 'Salud', 'Eventos', 'Novedades') DEFAULT 'General',
    FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar usuario admin por defecto
INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
VALUES ('Admin', 'Sistema', 'admin@clinica.com', '600000000', '1990-01-01', 'Calle Admin 1', 'Hombre');

INSERT INTO users_login (idUser, usuario, password, rol)
VALUES (1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insertar usuario de prueba
INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
VALUES ('Paciente', 'Ejemplo', 'paciente@ejemplo.com', '611111111', '1985-05-15', 'Calle Ejemplo 123', 'Mujer');

INSERT INTO users_login (idUser, usuario, password)
VALUES (2, 'paciente', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insertar noticia de ejemplo
INSERT INTO noticias (titulo, imagen, texto, resumen, fecha, idUser, categoria)
VALUES (
    'Nuevo equipo de diagnóstico por imagen',
    'equipo-diagnostico.jpg',
    'La clínica ha adquirido un nuevo equipo de resonancia magnética de última generación que permitirá diagnósticos más precisos y en menor tiempo. Este equipo representa una inversión de 1.2 millones de euros y está disponible para todos nuestros pacientes a partir de hoy.',
    'Nuevo equipo de resonancia magnética mejora capacidades diagnósticas',
    CURDATE(),
    1,
    'Novedades'
);

-- Insertar cita de ejemplo
INSERT INTO citas (idUser, fecha_cita, motivo_cita, especialidad, estado)
VALUES (
    2,
    DATE_ADD(NOW(), INTERVAL 3 DAY),
    'Dolor en el pecho y mareos ocasionales',
    'Cardiología',
    'pendiente'
);