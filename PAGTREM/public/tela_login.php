<?php
session_start();

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $senha   = $_POST["senha"];

   
    if ($usuario === "admin" && $senha === "1234") {
        $_SESSION["logado"] = true;
        header("Location: tela_menu.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

    <div class="container">
        <img src="../imagens/iconetrem_preto.png" alt="icone trem preto">

        <h2>Login</h2>

    
        <?php if (!empty($erro)): ?>
            <p style="color:red; text-align:center;"><?= $erro ?></p>
        <?php endif; ?>

        <form method="POST">

            <label>Usuário:</label>
            <input type="text" name="usuario" placeholder="Digite seu usuário" required>

            <label>Senha:</label>
            <input type="password" name="senha" placeholder="Digite sua senha" required>

            <button type="submit">Entrar</button>
        </form>

        <p><a href="tela_cadastro_1.php">Ainda não tem conta? Cadastre-se</a></p>

    </div>

</body>
</html>
