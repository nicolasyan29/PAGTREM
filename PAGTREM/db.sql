CREATE DATABASE login_db;

USE login_db;

CREATE TABLE usuarios (
        pk INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR (120) NOT NULL UNIQUE,
        senha VARCHAR (255) NOT NULL,
        cargo ENUM ('adm', 'func') NOT NULL,
        nome VARCHAR (255),
        nascimento DATE,
        localizacao VARCHAR (100),
        foto VARCHAR (255)
    );

INSERT INTO usuarios (username, senha, cargo, nome) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'adm', 'Administrador');

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO categories (name) VALUES ('Monotrilhos'), ('De passageiros'), ('Trens militarizados');

CREATE TABLE sensors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    status ENUM('ativo', 'inativo', 'manutenção') DEFAULT 'ativo',
    location VARCHAR(255),
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO sensors (name, status, location) VALUES
('Sensor Temperatura Linha Norte', 'ativo', 'Estação Central'),
('Sensor Velocidade Trem 1', 'manutenção', 'Linha Sul'),
('Sensor Pressão Monotrilho', 'ativo', 'Jardim das Flores');

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    type VARCHAR(50) DEFAULT 'info', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO notifications (message, type) VALUES
('Informamos que um trem apresentou falha técnica na Linha Norte, próximo ao bairro Jardim das Flores. A equipe de manutenção já foi acionada e está atuando para resolver o problema o mais rápido possível.', 'warning');

