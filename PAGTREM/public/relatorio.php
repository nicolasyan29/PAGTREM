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
    <title>Relatórios</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    

<div class="container">
    <h2>Relatórios</h2>

    <button onclick="window.location.href='notificacoes.php'">Ir para Notificações</button>
    <p><a href="gestaoderotas.php">Voltar à Gestão de Rotas</a></p>
</div>

</body>
</html>
