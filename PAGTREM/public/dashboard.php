<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Buscar categorias
$sql = "SELECT name FROM categories ORDER BY name";
$result = $conn->query($sql);
$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = htmlspecialchars($row['name']);
    }
} else {
    $categories = ["Monotrilhos", "De passageiros", "Trens militarizados"];
}

// Contar usuários
$user_count_sql = "SELECT COUNT(*) as total FROM usuarios";
$user_result = $conn->query($user_count_sql);
$user_count = ($user_result) ? $user_result->fetch_assoc()['total'] : 0;

// Contar sensores
$sensor_count_sql = "SELECT COUNT(*) as total FROM sensors";
$sensor_result = $conn->query($sensor_count_sql);
$sensor_count = ($sensor_result) ? $sensor_result->fetch_assoc()['total'] : 0;

// Contar rotas
$route_count_sql = "SELECT COUNT(*) as total FROM routes";
$route_result = $conn->query($route_count_sql);
$route_count = ($route_result) ? $route_result->fetch_assoc()['total'] : 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include 'menu.php'; ?>
        <header class="header">
            <div class="logo">
                <img src="../img/icone pagtrem-Photoroom.png" alt="Ícone Trem">
            </div>
            <h1>Dashboard</h1>
        </header>
        <main class="main-content">
            <div class="stats">
                <div class="stat">
                    <i class="fas fa-users"></i>
                    <span>Total Usuários: <?php echo $user_count; ?></span>
                </div>
                <div class="stat">
                    <i class="fas fa-sensor"></i>
                    <span>Total Sensores: <?php echo $sensor_count; ?></span>
                </div>
                <div class="stat">
                    <i class="fas fa-route"></i>
                    <span>Total Rotas: <?php echo $route_count; ?></span>
                </div>
            </div>
            <h2>Categorias de Trens</h2>
            <div class="categories">
                <?php foreach ($categories as $category): ?>
                    <button class="button" onclick="alert('Categoria: <?php echo $category; ?>')">
                        <i class="fas fa-train"></i> <?php echo $category; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </main>
        <footer class="footer">
            <a href="telainicial.php" class="nav-icon"><i class="fas fa-arrow-left"></i></a>
            <a href="relatorios.php" class="nav-icon"><i class="fas fa-arrow-right"></i></a>
        </footer>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
