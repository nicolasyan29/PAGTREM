-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS login_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE login_db;

-- 1. Tabela USUARIOS (Usuários do sistema)
CREATE TABLE IF NOT EXISTS usuarios (
    pk INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (120) NOT NULL UNIQUE,
    senha VARCHAR (255) NOT NULL,
    cargo ENUM ('adm', 'func') NOT NULL,
    nome VARCHAR (255),
    nascimento DATE,
    localizacao VARCHAR (100),
    foto VARCHAR (255)
);

-- Inserção de usuário ADMIN (senha '1234' hasheada para bcrypt)
INSERT INTO usuarios (username, senha, cargo, nome) VALUES (
    'admin', 
    -- Senha '1234' hasheada:
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'adm', 
    'Administrador'
) ON DUPLICATE KEY UPDATE nome='Administrador';


-- 2. Tabela CATEGORIES (Usado no dashboard para categorização de trens)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO categories (name) VALUES 
('Monotrilhos'), 
('De passageiros'), 
('Trens militarizados');


-- 3. Tabela SENSORS (Usado no monitoramento.php)
CREATE TABLE IF NOT EXISTS sensors (
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


-- 4. Tabela NOTIFICATIONS (Usado no notificacoes.php)
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    type VARCHAR(50) DEFAULT 'info', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO notifications (message, type) VALUES
('Informamos que um trem apresentou falha técnica na Linha Norte, próximo ao bairro Jardim das Flores. A equipe de manutenção já foi acionada e está atuando para resolver o problema o mais rápido possível.', 'warning');


-- 5. Tabela ROUTES (NOVA! Referenciada em dashboard.php para contagem)
CREATE TABLE IF NOT EXISTS routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    start_point VARCHAR(100),
    end_point VARCHAR(100),
    status ENUM('ativa', 'inativa', 'em_manutencao') DEFAULT 'ativa'
);

INSERT INTO routes (name, start_point, end_point) VALUES
('Linha Amarela', 'Estação A', 'Estação Z'),
('Linha Azul', 'Estação 1', 'Estação 9');


-- 6. Tabela MESSAGES (NOVA! Referenciada em chat.php)
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Chave Estrangeira: Garante que a mensagem pertence a um usuário existente
    FOREIGN KEY (user_id) REFERENCES usuarios(pk) ON DELETE CASCADE
);

INSERT INTO messages (user_id, message) VALUES
(1, 'Converse com nosso suporte'),
(1, 'Tudo bem!'),
(1, 'O que precisa?'),
(1, 'Arrumar um problema!');