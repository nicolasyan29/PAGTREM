<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style/cadastro1.css">
</head>
<body>

    <div class="container">
        <div class="icon-top">
            <img src="icone-trem.png" alt="Ícone Trem">
        </div>

        <h1>Cadastro</h1>

        <form action="#" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite aqui..." required>

            <label for="data">Data de nascimento:</label>
            <input type="text" id="data" name="data" placeholder="dd / mm / aaaa" required>

            <div class="dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>

            <div class="nav-buttons">
                <button type="button" class="btn-nav">&#8592;</button>
                <button type="button" class="btn-home">&#8962;</button>
                <button type="submit" class="btn-nav">&#8594;</button>
            </div>
        </form>
    </div>

</body>
</html>
