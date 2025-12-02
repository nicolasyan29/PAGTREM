<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu sua senha?</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<a href="pagina_inicial.php"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>
    <div class="img_carinha_esqueci">
        <img src="../assets/icons/cara_confuso.png" alt="carinha confuso" width="200" height="300">
    </div>
    <div class="text_esqueci">
        <strong><h2 class="p">Esqueceu sua senha?</h2></strong>
        <p class="p">Enviamos um Código de</p>
        <p class="p">acesso para seu número de</p>
        <p class="p">telefone cadastrado</p>
        <br><br>
        <strong><h3 class="p">Digite o código de</h3></strong>
        <strong><h3 class="p">confirmação</h3></strong>
    </div>
    <br>
    <div class="alinhar">
        <div class="caixa_esqueci">
            <input id="codigo" type="text" maxlength="6" class="centralizar_esqueci" placeholder="----"
                   style="border: none; background: transparent; text-align: center; font-weight: bold; font-size: inherit; width: 100%;">
        </div>
        <br><br>
        <div class="caixa_reeviar">
            <button onclick="reenviarCodigo()" class="centralizar_reenviar" 
        style="background: none; border: none; color: inherit; font: inherit; cursor: pointer;">
        <strong>REENVIAR CÓDIGO</strong>
        </button>
        </div>
    </div>

  
</body>
</html>