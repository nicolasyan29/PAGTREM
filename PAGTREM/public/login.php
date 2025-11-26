<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    
    if ($email === "teste@teste.com" && $senha === "1234") {
        $_SESSION["logado"] = true;
        header("Location: menu.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Login</title><link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <form method="POST">
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Entrar</button>
    </form>

    <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

    <p><a href="cadastro1.php">Ainda não tem conta? Cadastre-se</a></p>
</body>
</html>
