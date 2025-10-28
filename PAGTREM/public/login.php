<?php
session_start();
include '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['senha'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Preencha todos os campos.";
    } else {
        $stmt = $conn->prepare("SELECT pk, username, senha FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['senha'])) {
                $_SESSION['user_id'] = $row['pk'];
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Usuário ou senha inválidos.";
            }
        } else {
            $error = "Usuário ou senha inválidos.";
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
    <title>Login</title>
    <link rel="stylesheet" href="../style/login.css">
</head>
<body>
    <div id="login">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div id="mensagemErro"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="usuario">Usuário:</label><br>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>" required><br>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" required><br><br>
            <button type="submit">Entrar</button>
        </form>
        <p><a href="recuperaçãodesenha.php">Esqueceu a senha?</a></p>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
