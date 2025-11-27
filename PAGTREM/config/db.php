<?php
// Arquivo: config/db.php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "login_db";

try {
    // Cria uma nova instância PDO para conexão
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    
    // Define o modo de erro para lançar exceções para debug mais fácil
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Define o modo de fetch padrão como array associativo (coluna => valor)
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    
} catch (PDOException $e) {
    // Tratamento de erro seguro
    error_log("Connection failed: " . $e->getMessage());
    die("Erro na conexão com o banco de dados. Tente novamente mais tarde.");
}
?>