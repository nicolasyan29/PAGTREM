<?php
session_start();

// Limpar sessões de cadastro anteriores
unset($_SESSION['cadastro_username'], $_SESSION['cadastro_senha'], $_SESSION['cadastro_cargo'], $_SESSION['cadastro_nome'], $_SESSION['cadastro_nascimento'], $_SESSION['cadastro_localizacao']);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $cargo = $_POST['cargo'] ?? '';

    if (empty($username) || empty($senha) || empty($cargo)) {
        $error = 'Preencha todos os campos.';
    } elseif (strlen($senha) < 6) {
        $error = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif (!in_array($cargo, ['adm', 'func'])) {
        $error = 'Cargo inválido.';
    } else {
        $_SESSION['cadastro_username'] = $username;
        $_SESSION['cadastro_senha'] = password_hash($senha, PASSWORD_DEFAULT);
        $_SESSION['cadastro_cargo'] = $cargo;
        header("Location: cadastro2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Usuário</title>
    <link rel="stylesheet" href="../style/cadastro1.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro - Etapa 1</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="cargo">Cargo:</label>
            <select id="cargo" name="cargo" required>
                <option value="">Selecione</option>
                <option value="adm" <?php echo (($_POST['cargo'] ?? '') === 'adm') ? 'selected' : ''; ?>>Administrador</option>
                <option value="func" <?php echo (($_POST['cargo'] ?? '') === 'func') ? 'selected' : ''; ?>>Funcionário</option>
            </select>

            <button type="submit">Próximo</button>
        </form>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
