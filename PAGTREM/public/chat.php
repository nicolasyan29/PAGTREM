<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $user = $_SESSION['username'];
    $stmt = $conn->prepare("INSERT INTO messages (user, message, timestamp) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $user, $message);
    $stmt->execute();
    $stmt->close();
}


$sql = "SELECT user, message, timestamp FROM messages ORDER BY timestamp ASC";
$result = $conn->query($sql);
$messages = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Support</title>
    <link rel="stylesheet" href="../style/chat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="chat-container">
        <header class="chat-header">
            <div class="header-icon">
                <i class="fas fa-train"></i>
            </div>
            <h1 class="chat-title">CHAT</h1>
        </header>
        <main class="chat-main">
            <?php foreach ($messages as $msg): ?>
                <div class="message <?php echo ($msg['user'] == $_SESSION['username']) ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($msg['message']); ?></p>
                </div>
            <?php endforeach; ?>
        </main>
        <footer class="chat-footer">
            <form method="POST" action="">
                <div class="input-container">
                    <input type="text" name="message" id="message-input" placeholder="Type a message..." required>
                    <i class="far fa-smile smiley-icon"></i>
                </div>
                <button type="submit" class="nav-icon"><i class="fas fa-paper-plane"></i></button>
            </form>
            <nav class="footer-nav">
                <a href="#" class="nav-icon"><i class="fas fa-arrow-left"></i></a>
                <a href="#" class="nav-icon"><i class="fas fa-home"></i></a>
                <a href="#" class="nav-icon"><i class="fas fa-arrow-right"></i></a>
            </nav>
        </footer>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
