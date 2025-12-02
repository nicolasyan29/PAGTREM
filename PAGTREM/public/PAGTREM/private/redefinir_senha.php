<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    
<a href="login.php"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>

<div class="img_carinha_redefinir">
    <img src="../assets/icons/cara_confuso.png" alt="icone carinha" width="200" height="300">
</div>

<div class="text_redefinir">
    <strong><h1>REDEFINIR SENHA</h1></strong>
</div>

<form id="redefinir">
    <div>
        <p class="sub1">Digite sua nova senha:</p>
        <input type="password" class="caixa_redefinir" id="nova_senha">
        <br><br>
        <p class="sub2">Digite sua nova senha novamente:</p>
        <input type="password" class="caixa_redefinir" id="confirmar_senha">
    </div>
    <br><br>
    <div class="final_redefinir">
        <button class="caixa_verde_redefinir"><strong><p class="centralizar_redefinir">CONFIRMAR</p></strong></button>
    </div>
</form>


</body>
</html>