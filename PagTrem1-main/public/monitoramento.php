<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$sql = "SELECT id, name, status, location, last_update FROM sensors ORDER BY last_update DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Monitoramento de Manutenções</title>
  <link rel="stylesheet" href="../style/monitoramento.css" />
</head>
<body>
  <div class="container">
    <?php include '../public/menu.php'; ?>
    <header class="header">
        <h1>Monitoramento de Manutenções</h1>
    </header>
    <main class="main-content">
        <h2>Tabela de Sensores</h2>
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th>Localização</th>
                    <th>Última Atualização</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_update']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum sensor encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
  </div>

  <script src="../script/script.js"></script>
</body>
</html>
