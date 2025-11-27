<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "login_db";

try {
    // Cria uma nova instância PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    
    // Define o modo de erro para lançar exceções.
    // Isso facilita a captura de erros de banco de dados no seu código PHP.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Define o modo de fetch padrão como array associativo (coluna => valor).
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Nota: O objeto de conexão PDO agora é chamado $conn, o que é consistente com dashboard.php e monitoramento.php.

} catch (PDOException $e) {
    // Se a conexão falhar, interrompe o script e exibe o erro (apenas para ambiente de desenvolvimento).
    // Em produção, você deve apenas registrar o erro sem exibi-lo.
    error_log("Connection failed: " . $e->getMessage());
    die("Erro na conexão com o banco de dados. Tente novamente mais tarde.");
}
?>