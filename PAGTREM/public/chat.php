<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO messages (user_id, message, timestamp) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $message);
        $stmt->execute();
        $stmt->close();
        // Redirecionar para evitar reenvio
        header("Location: chat.php");
        exit();
    }
}

$sql = "SELECT m.message, m.timestamp, u.username FROM messages m JOIN usuarios u ON m.user_id = u.pk ORDER BY m.timestamp ASC";
$result = $conn->query($sql);
$messages = ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - PAGTREM</title>
    <link rel="stylesheet" href="../style/chat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="chat-container">
        <header class="chat-header">
            <div class="header-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h1 class="chat-title">CHAT</h1>
        </header>
        <main class="chat-main" id="chat-messages">
            <?php if (empty($messages)): ?>
                <div class="no-messages">
                    <p>Nenhuma mensagem ainda. Comece a conversar!</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="message <?php echo ($msg['username'] === $_SESSION['username']) ? 'sent' : 'received'; ?>">
                        <div class="message-header">
                            <strong><?php echo htmlspecialchars($msg['username']); ?></strong>
                            <span class="timestamp"><?php echo date('d/m H:i', strtotime($msg['timestamp'])); ?></span>
                        </div>
                        <p><?php echo htmlspecialchars($msg['message']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
        <footer class="chat-footer">
            <form method="POST" action="">
                <div class="input-container">
                    <input type="text" name="message" id="message-input" placeholder="Digite uma mensagem..." maxlength="500" required>
                    <i class="far fa-smile smiley-icon"></i>
                </div>
                <button type="submit" class="nav-icon"><i class="fas fa-paper-plane"></i></button>
            </form>
            <nav class="footer-nav">
                <a href="contatos.php" class="nav-icon"><i class="fas fa-arrow-left"></i></a>
                <a href="dashboard.php" class="nav-icon"><i class="fas fa-home"></i></a>
                <a href="notificacoes.php" class="nav-icon"><i class="fas fa-arrow-right"></i></a>
            </nav>
        </footer>
    </div>
    <script src="../script/script.js"></script>
    <script>
        // Rolagem automática para o final do chat
        const chatMain = document.getElementById('chat-messages');
        chatMain.scrollTop = chatMain.scrollHeight;
    </script>
</body>
</html>
