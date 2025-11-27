<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $local = trim($_POST["local"]);

    if (strlen($local) < 2) {
        $erro = "Localização inválida!";
    }
    else {
        
        $_SESSION["local"] = $local;

        
        $_SESSION["foto"] = null;

        header("Location: menu.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Parte 2</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>

    <form method="POST">
        <input type="text" name="local" placeholder="Localização" required><br>
        <button type="submit">Finalizar Cadastro</button>
    </form>

    <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

</body>
</html>
