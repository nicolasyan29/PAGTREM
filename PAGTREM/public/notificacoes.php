<?php
$titulo = "Notificações";
$icone = "🚆"; 
$mensagem = "Informamos que um trem apresentou falha técnica na Linha Norte, próximo ao bairro Jardim das Flores. A equipe de manutenção já foi acionada e está atuando para resolver o problema o mais rápido possível.";
$alerta = "Comunicado importante!";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <div class="container">
        <header>
            <span class="icone"><?php echo $icone; ?></span>
            <h1><?php echo $titulo; ?></h1>
        </header>
        <div class="box">
            <p><?php echo $mensagem; ?></p>
            <strong><?php echo $alerta; ?></strong>
        </div>
    </div>
</body>
</html>
