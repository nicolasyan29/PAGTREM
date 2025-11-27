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

    <button onclick="window.location.href='gestaoderotas.php'">Ir para Gestão de Rotas</button>
    <p><a href="menu.php">Voltar ao Menu</a></p>
</div>

</body>
</html>
