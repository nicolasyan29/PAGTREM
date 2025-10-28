<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


include '../config/db.php';


$sql = "SELECT name FROM categories ORDER BY name";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = htmlspecialchars($row['name']);
    }
} else {
    $categories = ["Monotrilhos", "De passageiros", "Trens militarizados"];
}

// Get user count
$user_count_sql = "SELECT COUNT(*) as total FROM usuarios";
$user_result = $conn->query($user_count_sql);
$user_count = $user_result->fetch_assoc()['total'];

// Get sensor count
$sensor_count_sql = "SELECT COUNT(*) as total FROM sensors";
$sensor_result = $conn->query($sensor_count_sql);
$sensor_count = $sensor_result->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard.css">
</head>
<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <header class="header">
            <div class="logo">
                <img src="../img/icone pagtrem-Photoroom.png" alt="Trem Icone">
            </div>
            <h1>Dashboard</h1>
        </header>
        <main class="main-content">
            <div class="stats">
                <div class="stat">Total Usuários: <?php echo $user_count; ?></div>
                <div class="stat">Total Sensores: <?php echo $sensor_count; ?></div>
            </div>
            <h2>Categorias de Trens</h2>
            <?php foreach ($categories as $category): ?>
                <button class="button" onclick="alert('Categoria: <?php echo $category; ?>')"><?php echo $category; ?></button>
            <?php endforeach; ?>
        </main>
        <footer class="footer">
            <a href="telaInicial.php" class="nav-icon">&leftarrow;</a>
            <a href="relatorios.php" class="nav-icon">&rightarrow;</a>
        </footer>
    </div>
</body>
</html>
