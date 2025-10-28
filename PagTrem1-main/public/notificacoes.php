<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';


$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <link rel="stylesheet" href="../style/notificacoes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="notification-container">
        <header class="notification-header">
            <div class="logo img">
                <img src="../img/icone pagtrem-Photoroom.png" alt="">
            </div>
            <h1 class="notification-title">Notificações</h1>
        </header>
        <main class="notification-main">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="notification-card">
                        <p><?php echo htmlspecialchars($row['message']); ?></p>
                        <div class="arrow-up"></div>
                        <p class="important-communication">Comunicado importante!</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="notification-card">
                    <p>Nenhuma notificação disponível no momento.</p>
                </div>
            <?php endif; ?>
        </main>
        <footer class="notification-footer">
            <nav class="footer-nav">
                <a href="#" class="nav-icon"><i class="fas fa-arrow-left"></i></a>
                <a href="#" class="nav-icon"><i class="fas fa-home"></i></a>
                <a href="#" class="nav-icon"><i class="fas fa-arrow-right"></i></a>
            </nav>
        </footer>
    </div>
</body>
</html>
