<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos - PAGTREM</title>
    <link rel="stylesheet" href="../style/contatos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../img/unnamed.png" alt="Logo PAGTREM" width="420" height="250">
        </div>
        <div class="info">
            <h1>Contatos</h1>
            <p>Clique para conversar com o suporte</p>
            <div class="contact-options">
                <a href="chat.php" class="contact-link" onclick="logClick()">
                    <i class="fas fa-comments"></i>
                    <span>Iniciar Chat</span>
                </a>
                <a href="tel:+5511999999999" class="contact-link">
                    <i class="fas fa-phone"></i>
                    <span>Ligar: (11) 99999-9999</span>
                </a>
                <a href="mailto:suporte@pagtremsystem.com" class="contact-link">
                    <i class="fas fa-envelope"></i>
                    <span>Email: suporte@pagtremsystem.com</span>
                </a>
            </div>
        </div>
        <div class="footer-nav">
            <a href="dashboard.php" class="nav-icon"><i class="fas fa-arrow-left"></i></a>
            <a href="dashboard.php" class="nav-icon"><i class="fas fa-home"></i></a>
            <a href="chat.php" class="nav-icon"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    <script src="../script/script.js"></script>
    <script>
        function logClick() {
            // Log do clique no chat
            fetch('log_click.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'chat_clicked', timestamp: new Date().toISOString() })
            });
        }
    </script>
</body>
</html>
