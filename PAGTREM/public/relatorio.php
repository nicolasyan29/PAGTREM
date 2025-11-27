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

    <h2>Relatórios do Sistema</h2>

    <p>
        Nesta seção você pode visualizar, gerar e analisar relatórios sobre o funcionamento
        do sistema PagTrem, incluindo dados de usuários, rotas, viagens realizadas,
        movimentações registradas e desempenho geral.
    </p>

    <p>
        Utilize esta área para acompanhar estatísticas, exportar informações e monitorar
        indicadores importantes para a operação.
    </p>

    <br>

    <button onclick="window.location.href='notificacoes.php'">Ir para Notificações</button>
    <br><br>

    <button onclick="window.location.href='menu.php'">Voltar ao Menu</button>

</div>

</body>
</html>
