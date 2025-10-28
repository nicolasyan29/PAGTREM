<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $senha = trim($_POST['senha']);
    $cargo = $_POST['cargo'];

    if (empty($username) || empty($senha) || empty($cargo)) {
        $error = 'Preencha todos os campos.';
    } elseif (strlen($senha) < 6) {
        $error = 'A senha deve ter pelo menos 6 caracteres.';
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
            <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="cargo">Cargo:</label>
            <select id="cargo" name="cargo" required>
                <option value="adm">Administrador</option>
                <option value="func">Funcionário</option>
            </select>

            <button type="submit">Próximo</button>
        </form>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
