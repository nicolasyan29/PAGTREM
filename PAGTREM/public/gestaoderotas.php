<?php
session_start();
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <title>Gestão de Rotas</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>

<div class="container">
    <h2>Gestão de Rotas</h2>

    <button onclick="window.location.href='relatorio.php'">Ir para Relatório</button>
    <p><a href="dashboard.php">Voltar ao Dashboard</a></p>
</div>

</body>
</html>
