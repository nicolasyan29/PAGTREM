<?php
$logFile = '../logs/email_access.log';
$logMessage = date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' - IP: ' . $_SERVER['REMOTE_ADDR'] . "\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail Encontrado</title>
    <link rel="stylesheet" href="../style/email.css">
    <script src="../script/script.js"></script>
</head>

<body>
    <div>
        <img src="../img/unnamed.png" alt="" width="420" height="250">
    </div>
    <div>
        <h1>✉✔</h1>
        <h1>E-mail encontrado em nossa base de dados, confira
            sua caixa de e-mail.</h1>
    </div>
</body>

</html>