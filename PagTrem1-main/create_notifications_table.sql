CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    type VARCHAR(50) DEFAULT 'info', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO notifications (message, type) VALUES
('Informamos que um trem apresentou falha técnica na Linha Norte, próximo ao bairro Jardim das Flores. A equipe de manutenção já foi acionada e está atuando para resolver o problema o mais rápido possível.', 'warning');
