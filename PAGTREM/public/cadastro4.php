<?php
session_start();

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
        $target_dir = "../uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));
        $novo_nome = uniqid('profile_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $novo_nome;

        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            $error_message = "O arquivo não é uma imagem válida.";
        } elseif ($foto["size"] > 5000000) {
            $error_message = "O arquivo é muito grande (máx. 5MB).";
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $error_message = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        } else {
            if (move_uploaded_file($foto["tmp_name"], $target_file)) {

                $senha_hash = password_hash($_SESSION['cadastro_senha'], PASSWORD_BCRYPT);

                $stmt = $conn->prepare(
                    "INSERT INTO usuarios (username, senha, cargo, nome, nascimento, localizacao, foto) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                );

                if ($stmt->execute([
                    $_SESSION['cadastro_username'],
                    $senha_hash,
                    $_SESSION['cadastro_cargo'],
                    $_SESSION['cadastro_nome'],
                    $nascimento_formatado,
                    $_SESSION['cadastro_localizacao'],
                    $novo_nome
                ])) {
                    $_SESSION['user_id'] = $conn->lastInsertId();
                    $_SESSION['username'] = $_SESSION['cadastro_username'];

                    unset(
                        $_SESSION['cadastro_username'],
                        $_SESSION['cadastro_senha'],
                        $_SESSION['cadastro_cargo'],
                        $_SESSION['cadastro_nome'],
                        $_SESSION['cadastro_nascimento'],
                        $_SESSION['cadastro_localizacao']
                    );

                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error_message = "Erro ao salvar usuário no banco!";
                }
            } else {
                $error_message = "Erro ao fazer upload da imagem!";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Foto de Perfil</title>
    <link rel="stylesheet" href="../style/combined.css">
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

        <?php if (!empty($error_message)): ?>
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