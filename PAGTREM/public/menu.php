<?php
session_start();

if (!isset($_SESSION["logado"]) && !isset($_SESSION["nome"])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION["nome"] ?? "Usuário";
$foto = $_SESSION["foto"] ?? "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Menu</title><link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <h1>Bem-vindo, <?php echo $nome; ?>!</h1>

    <?php if($foto !== ""): ?>
        <img src="uploads/<?php echo $foto; ?>" width="150">
    <?php endif; ?>

    <p>Menu principal do app</p>
</body>
</html>
