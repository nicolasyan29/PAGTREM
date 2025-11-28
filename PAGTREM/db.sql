CREATE DATABASE login_sa;

USE login_sa;

CREATE TABLE usuarios (
	pk INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(120) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cargo ENUM('adm','func') NOT NULL
);

INSERT INTO usuarios (username, senha) VALUES ('admin','123');