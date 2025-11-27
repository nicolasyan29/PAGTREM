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
    <title>Notificações</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>

<div class="container">

    <h2>Notificações</h2>

    <p>
        Informamos que um trem apresentou falha técnica na Linha Norte, próximo ao bairro
        Jardim das Flores. A equipe de manutenção já foi acionada e está atuando para
        resolver o problema o mais rápido possível.
    </p>

    <br>

    <button onclick="window.location.href='menu.php'">Voltar ao Menu</button>

</div>

</body>
</html>
