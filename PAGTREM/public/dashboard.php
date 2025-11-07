<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Buscar categorias
try {
    $sql = "SELECT name FROM categories ORDER BY name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (empty($categories)) {
        $categories = ["Monotrilhos", "De passageiros", "Trens militarizados"];
    }
} catch (PDOException $e) {
    error_log("Erro ao buscar categorias: " . $e->getMessage());
    $categories = ["Monotrilhos", "De passageiros", "Trens militarizados"];
}

// Contar usuários, sensores e rotas em uma única query otimizada
try {
    $count_sql = "SELECT
        (SELECT COUNT(*) FROM usuarios) as user_count,
        (SELECT COUNT(*) FROM sensors) as sensor_count,
        (SELECT COUNT(*) FROM routes) as route_count";
    $stmt = $conn->prepare($count_sql);
    $stmt->execute();
    $counts = $stmt->fetch();
    $user_count = $counts['user_count'] ?? 0;
    $sensor_count = $counts['sensor_count'] ?? 0;
    $route_count = $counts['route_count'] ?? 0;
} catch (PDOException $e) {
    error_log("Erro ao contar registros: " . $e->getMessage());
    $user_count = $sensor_count = $route_count = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/combined.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
