<?php
session_start();
include '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrUsername = trim($_POST['email'] ?? '');

    if (empty($emailOrUsername)) {
        $error = "Por favor, preencha o campo.";
    } else {
        // Verificar se é username ou email (assumindo que username é usado)
        $stmt = $conn->prepare("SELECT pk FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $emailOrUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Em um sistema real, enviar email com token de reset
            // Por enquanto, apenas simular sucesso
            $success = "Instruções para redefinir a senha foram enviadas para o seu e-mail.";
        } else {
            $error = "Usuário não encontrado.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="../style/recuperaçãodesenha.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="icon-top">
            <img src="../img/icone pagtrem-Photoroom.png" alt="Ícone">
        </div>
        <h2>Preencha as informações<br>para redefinir sua senha</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Seu usuário</label>
            <input type="text" id="email" name="email" placeholder="Digite aqui..." value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            <button type="submit">Enviar</button>
        </form>
        <div class="icon-key">
            <i class="fas fa-user"></i>
            <i class="fas fa-key"></i>
        </div>
        <div class="footer-icons">
            <a href="login.php"><i class="fas fa-arrow-left"></i></a>
            <a href="telainicial.php"><i class="fas fa-home"></i></a>
            <i class="fas fa-arrow-right"></i>
        </div>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
