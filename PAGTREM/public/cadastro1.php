<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $nasc = $_POST["nasc"];

    if (strlen($nome) < 3) {
        $erro = "Nome muito curto!";
    } 
    elseif (empty($nasc)) {
        $erro = "Informe sua data de nascimento!";
    } 
    else {
        $_SESSION["nome"] = $nome;
        $_SESSION["nasc"] = $nasc;
        header("Location: cadastro2.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Cadastro - Parte 1</title></head>
<body>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required><br>
        <input type="date" name="nasc" required><br>
        <button type="submit">Continuar</button>
    </form>

    <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
</body>
</html>
