<?php
session_start();

// Verificar se as sessões anteriores existem
if (!isset($_SESSION['cadastro_localizacao'])) {
    header("Location: cadastro3.php");
    exit();
}

include '../config/db.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        $error_message = "Por favor, selecione uma foto válida.";
    } else {
        $foto = $_FILES['foto'];
        $target_dir = "../uploads/"; // Ajustar caminho relativo
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $original_name = basename($foto["name"]);
        $imageFileType = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $new_name = uniqid('profile_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $new_name;

        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            $error_message = "O arquivo não é uma imagem válida.";
        } elseif ($foto["size"] > 5000000) {
            $error_message = "O arquivo é muito grande (máx. 5MB).";
        } elseif (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            $error_message = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        } else {
            if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                // Inserir dados do usuário
                $stmt = $conn->prepare("INSERT INTO usuarios (username, senha, cargo, nome, nascimento, localizacao, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $_SESSION['cadastro_username'], $_SESSION['cadastro_senha'], $_SESSION['cadastro_cargo'], $_SESSION['cadastro_nome'], $_SESSION['cadastro_nascimento'], $_SESSION['cadastro_localizacao'], $target_file);
                if ($stmt->execute()) {
                    $success_message = "Foto enviada com sucesso! Cadastro concluído.";
                    // Definir sessão para login
                    $_SESSION['user_id'] = $conn->insert_id;
                    $_SESSION['username'] = $_SESSION['cadastro_username'];
                    // Limpar sessões de cadastro
                    unset($_SESSION['cadastro_username'], $_SESSION['cadastro_senha'], $_SESSION['cadastro_cargo'], $_SESSION['cadastro_nome'], $_SESSION['cadastro_nascimento'], $_SESSION['cadastro_localizacao']);
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error_message = "Erro ao salvar dados: " . $conn->error;
                }
                $stmt->close();
            } else {
                $error_message = "Erro ao fazer upload da foto.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Foto de Perfil</title>
    <link rel="stylesheet" href="../style/cadastro4.css">
</head>
<body>
    <div>
        <img src="../img/unnamed.png" alt="Logo" width="420" height="250">
    </div>
    <div>
        <h1>Cadastro - Etapa 4</h1>
    </div>
    <div>
        <img src="../img/icone.png" alt="Icone" width="200" height="205">
    </div>
    <div>
        <h2>Selecione uma foto de perfil.</h2>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="foto">Foto de perfil:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>
            <div class="nav">
                <a href="cadastro3.php" style="text-decoration: none; padding: 10px; background-color: #ccc;">Voltar</a>
                <input type="submit" value="Concluir Cadastro">
            </div>
        </form>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
