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


    <p>A linha 4 está sendo feita pelos novos trens em menos de 1 hora da primeira à última parada.</p>

    <p>Cada viagem do começo ao fim está gastando R$ 200,00 em combustível.</p>

    <p>Os trens estão economizando R$ 50,00 a mais comparado ao ano passado.</p>

    <br>

    <button onclick="window.location.href='notificacoes.php'">Ir para Notificações</button><br><br>
    <button onclick="window.location.href='gestaoderotas.php'">Voltar à Gestão de Rotas</button>

</div>

</body>
</html>
