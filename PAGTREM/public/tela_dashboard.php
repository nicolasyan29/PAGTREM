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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>


<div class="container">
    <h2>Dashboard</h2>

    <button onclick="window.location.href='tela_gestao_de_rotas.php'">Ir para Gestão de Rotas</button><br><br>
    <button onclick="window.location.href='tela_menu.php'">Voltar ao Menu</button>
</div>

</body>
</html>
