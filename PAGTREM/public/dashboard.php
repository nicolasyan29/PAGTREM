<?php
<<<<<<< HEAD
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

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
=======
>>>>>>> be4b6748499511ca8b3106f2f0413802c5011563
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <div class="icon">
                🚆 
            </div>
            <h1>Dashboard</h1>
        </header>

        <main>
            <button class="btn">Monotrilhos</button>
            <button class="btn">De passageiros</button>
        </main>

        <footer>
            <nav>
                <a href="#" class="nav-btn">⬅</a>
                <a href="#" class="nav-btn">🏠</a>
            </nav>
        </footer>
    </div>
</body>
</html>
