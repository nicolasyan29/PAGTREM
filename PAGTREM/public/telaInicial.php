<?php
header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">

    <title>PagTrem Funcionários</title>
    <link rel="stylesheet" href="../style/combined.css">

</head>
<body>
    <div class="container" onclick="iniciarApp()">
        <img src="../imagens/iconetrem.png" alt="Ícone do trem">
        <h1>PagTrem</h1>
        <h2>Funcionários</h2>
        <p>Clique em qualquer lugar na tela para iniciar</p>
    </div>

    <script>
        function iniciarApp() {
            window.location.href = "login.php";
        }
    </script>
</body>
</html>
