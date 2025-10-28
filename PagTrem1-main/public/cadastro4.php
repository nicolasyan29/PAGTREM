<?php
session_start();
include '../config/db.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $foto = $_FILES['foto'];

    if ($foto['error'] != 0) {
        $error_message = "Por favor, selecione uma foto.";
    } else {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            $error_message = "O arquivo não é uma imagem.";
        } elseif ($foto["size"] > 5000000) {
            $error_message = "O arquivo é muito grande.";
        } elseif (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            $error_message = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        } else {
            if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                // Insert user data
                $stmt = $conn->prepare("INSERT INTO usuarios (username, senha, cargo, nome, nascimento, localizacao, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $_SESSION['cadastro_username'], $_SESSION['cadastro_senha'], $_SESSION['cadastro_cargo'], $_SESSION['cadastro_nome'], $_SESSION['cadastro_nascimento'], $_SESSION['cadastro_localizacao'], $target_file);
                if ($stmt->execute()) {
                    $success_message = "Foto enviada com sucesso! Cadastro concluído.";
                    // Set session for login
                    $_SESSION['user_id'] = $conn->insert_id;
                    $_SESSION['username'] = $_SESSION['cadastro_username'];
                    // Clear cadastro session
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
        <h1>Cadastro</h1>
    </div>
    <div>
        <img src="../img/icone.png" alt="Icone" width="200" height="205">
    </div>
    <div>
        <h2>Selecione uma foto de perfil uniformizado.</h2>
        <?php if ($success_message): ?>
            <div style="color: green;"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div style="color: red;"><?php echo $error_message; ?></div>
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
