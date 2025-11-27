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
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat Suporte</title>
<link rel="stylesheet" href="../style/combined.css">
</head>
<body>
<div class="phone">
    <div class="chat-container">
        <div class="chat-header">
            <div class="logo"></div>
            <h1>CHAT</h1>
        </div>
        <div class="chat-body">
            <div class="msg support">Converse com nosso suporte</div>
            <div class="msg user">Tudo bem!</div>
            <div class="msg support">O que precisa?</div>
            <div class="msg user">Arrumar um prolema!</div>
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Type a message...">
            <button>😊</button>
        </div>
        <div class="chat-footer">
            <button class="nav-btn">←</button>
            <button class="home-btn">🏠</button>
            <button class="nav-btn">→</button>
        </div>
    </div>
</div>
</body>
</html>