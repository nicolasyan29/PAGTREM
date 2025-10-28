<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios e Análises</title>
    <link rel="stylesheet" href="../style/relatorio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include '../public/menu.php'; ?>

            <div class="header">
                <img src="../img/icone pagtrem-Photoroom.png" alt=""></i> Relatórios e análises
            </div>

            <div class="reports-container">
                <div class="report-card">
                    A linha 4 está sendo feita pelos novos trens em menos de 1 hora da primeira à última parada.
                </div>
                <div class="report-card">
                    Cada viagem do começo ao fim está gastando 200 R$ em combustível.
                </div>
                <div class="report-card">
                    Trens estão economizando 50 R$ a mais comparado ao ano passado.
                </div>
            </div>

            <div class="navigation-bar">
                <i class="fas fa-arrow-left navigation-icon"></i>
                <i class="fas fa-home navigation-icon"></i>
                <i class="fas fa-arrow-right navigation-icon"></i>
            </div>
        </div>
    </div>

</body>
</html>