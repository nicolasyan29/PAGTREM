<?php
session_start();

// O login.php original não define 'user_id'. Para que esta tela funcione:
// 1. O login.php DEVE ser atualizado para buscar o 'pk' do usuário no DB e definir $_SESSION['user_id'].
// 2. Por enquanto, se 'user_id' não estiver definido, usaremos o ID 1 para o exemplo.
$user_id = $_SESSION['user_id'] ?? 1;

if (!isset($_SESSION['logado']) && $user_id === 1) {
    // Se não está logado E não estamos usando o fallback ID 1, redireciona.
    // NOTE: Se o login.php fosse completo, bastaria checar !isset($_SESSION['user_id'])
    // header("Location: login.php");
    // exit();
}

// Inclui a conexão PDO aprimorada
include '../config/db.php';

$message = "";

// ======================================================
// 1. Lógica de Atualização (POST)
// ======================================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $localizacao = trim($_POST['localizacao']);
    $nascimento = $_POST['nascimento'];
    $foto_name = $_POST['foto_atual']; // Nome da foto atual, se não for alterada

    try {
        // --- Lógica de Upload de Foto ---
        if (isset($_FILES['nova_foto']) && $_FILES['nova_foto']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            
            // Cria a pasta se não existir
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_info = pathinfo($_FILES['nova_foto']['name']);
            $extensao = strtolower($file_info['extension']);
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($extensao, $allowed_ext)) {
                // Cria um nome de arquivo único (ex: user_1_timestamp.jpg)
                $foto_name = 'user_' . $user_id . '_' . time() . '.' . $extensao;
                $upload_path = $upload_dir . $foto_name;

                if (move_uploaded_file($_FILES['nova_foto']['tmp_name'], $upload_path)) {
                    $message = "Foto atualizada com sucesso. ";
                } else {
                    $message .= "Erro ao mover arquivo. ";
                    $foto_name = $_POST['foto_atual']; // Mantém a foto antiga em caso de falha
                }
            } else {
                $message .= "Formato de arquivo não permitido. ";
            }
        }

        // --- Lógica de Atualização de Dados ---
        $sql = "UPDATE usuarios SET nome = ?, nascimento = ?, localizacao = ?, foto = ? WHERE pk = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $nascimento, $localizacao, $foto_name, $user_id]);

        if ($stmt->rowCount()) {
            $message .= "Perfil atualizado com sucesso!";
        } else if (empty($message)) {
            $message = "Nenhuma alteração foi feita.";
        }
        
    } catch (PDOException $e) {
        $message = "Erro ao atualizar perfil: " . $e->getMessage();
        error_log($message);
    }
}

// ======================================================
// 2. Busca de Dados para Exibição
// ======================================================
try {
    $sql = "SELECT nome, username, nascimento, localizacao, foto FROM usuarios WHERE pk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        die("Usuário não encontrado ou ID inválido.");
    }
} catch (PDOException $e) {
    die("Erro ao carregar dados do usuário: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="../style/combined.css">
    <style>
        .back-icon {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 1.5em;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="menu.php" class="back-icon" aria-label="Voltar">⬅️</a>

        <h1>Meu Perfil</h1>
        
        <?php if (!empty($message)): ?>
            <p style="color: green; font-weight: bold;"><?= $message ?></p>
        <?php endif; ?>

        <img 
            src="<?= !empty($usuario['foto']) ? 'uploads/' . htmlspecialchars($usuario['foto']) : '../imagens/perfil_default.png' ?>" 
            alt="Foto de Perfil" 
            class="profile-picture"
        >

        <form method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="foto_atual" value="<?= htmlspecialchars($usuario['foto'] ?? '') ?>">

            <div class="file-upload-wrapper">
                <input type="file" name="nova_foto" accept="image/*" onchange="this.form.submit()">
                <div class="upload-btn">
                    Clique para Mudar Foto
                </div>
            </div>

            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>

            <label>Usuário:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($usuario['username'] ?? '') ?>" readonly style="background-color: #eee;">
            
            <label>Nascimento:</label>
            <input type="date" name="nascimento" value="<?= htmlspecialchars($usuario['nascimento'] ?? '') ?>">

            <label>Localização:</label>
            <input type="text" name="localizacao" value="<?= htmlspecialchars($usuario['localizacao'] ?? '') ?>">

            <button type="submit" name="action" value="update_data">Salvar Alterações</button>
        </form>

    </div>
</body>
</html>