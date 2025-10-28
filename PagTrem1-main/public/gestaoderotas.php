<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/routes_functions.php';
include '../config/db.php';

createRoutesTable();

$routes = getRoutes();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_route'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        if (addRoute($name, $description, $status)) {
            $message = 'Rota adicionada com sucesso!';
            $routes = getRoutes(); 
        } else {
            $message = 'Erro ao adicionar rota.';
        }
    } elseif (isset($_POST['update_route'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        if (updateRoute($id, $name, $description, $status)) {
            $message = 'Rota atualizada com sucesso!';
            $routes = getRoutes(); 
        } else {
            $message = 'Erro ao atualizar rota.';
        }
    } elseif (isset($_POST['delete_route'])) {
        $id = $_POST['id'];
        if (deleteRoute($id)) {
            $message = 'Rota deletada com sucesso!';
            $routes = getRoutes(); 
        } else {
            $message = 'Erro ao deletar rota.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Rotas</title>
    <link rel="stylesheet" href="../style/gestaoderotas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="mobile-mockup">
        <div class="camera-notch"></div>
        <div class="mobile-screen">
            <div class="container">
                <div class="logo">
                    <img src="../img/icone pagtrem-Photoroom.png" alt="Logo">
                </div>
                <div class="content">
                    <h1>Gestão de Rotas</h1>
                    <?php if ($message): ?>
                        <p style="color: green;"><?php echo $message; ?></p>
                    <?php endif; ?>
                    <div class="buttons">
                        <button class="btn" onclick="showSection('add')">Adicionar Rota</button>
                        <button class="btn" onclick="showSection('list')">Ver Rotas</button>
                        <button class="btn" onclick="showSection('info')">Informações</button>
                    </div>
                    <div id="add" class="section" style="display: none;">
                        <h2>Adicionar Nova Rota</h2>
                        <form method="POST">
                            <input type="text" name="name" placeholder="Nome da Rota" required>
                            <textarea name="description" placeholder="Descrição"></textarea>
                            <select name="status">
                                <option value="active">Ativa</option>
                                <option value="inactive">Inativa</option>
                            </select>
                            <button type="submit" name="add_route">Adicionar</button>
                        </form>
                    </div>
                    <div id="list" class="section" style="display: none;">
                        <h2>Lista de Rotas</h2>
                        <?php if (empty($routes)): ?>
                            <p>Nenhuma rota encontrada.</p>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($routes as $route): ?>
                                    <li>
                                        <strong><?php echo $route['name']; ?></strong> - <?php echo $route['status']; ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="id" value="<?php echo $route['id']; ?>">
                                            <input type="text" name="name" value="<?php echo $route['name']; ?>" required>
                                            <textarea name="description"><?php echo $route['description']; ?></textarea>
                                            <select name="status">
                                                <option value="active" <?php if ($route['status'] == 'active') echo 'selected'; ?>>Ativa</option>
                                                <option value="inactive" <?php if ($route['status'] == 'inactive') echo 'selected'; ?>>Inativa</option>
                                            </select>
                                            <button type="submit" name="update_route">Atualizar</button>
                                            <button type="submit" name="delete_route" onclick="return confirm('Tem certeza?')">Deletar</button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div id="info" class="section" style="display: none;">
                        <h2>Informações</h2>
                        <p>Esta é a página de gestão de rotas. Use os botões para adicionar, ver ou gerenciar rotas.</p>
                    </div>
                </div>
                <div class="footer-navigation">
                    <i class="fas fa-arrow-left"></i>
                    <i class="fas fa-home"></i>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
        <div class="mobile-button"></div>
    </div>
    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>
