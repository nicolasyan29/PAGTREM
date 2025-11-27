<?php
session_start();


if (!isset($_SESSION["logado"])) {
    header("Location: tela_login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>

<div class="container">
    <h2>Menu Principal</h2>

    <button onclick="window.location.href='tela_dashboard.php'">📊 Ir para Dashboard</button>
    <br><br>

    <button onclick="window.location.href='tela_gestao_de_rotas.php'">🛤️ Gestão de Rotas</button>
    <br><br>

    <button onclick="window.location.href='tela_relatorio.php'">📑 Relatórios</button>
    <br><br>

    <button onclick="window.location.href='tela_notificacoes.php'">🔔 Notificações</button>

     <button onclick="window.location.href='tela_menu.php'">🔔 Notificações</button>
</div>

</body>

</html>
