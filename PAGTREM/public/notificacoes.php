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

    <button onclick="window.location.href='menu.php'">Voltar ao Menu</button>
</div>

</body>
</html>
