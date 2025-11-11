<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <div class="container">
        <!-- Ícone do topo -->
        <div class="icon-top">
            <img src="icone-trem.png" alt="Ícone Trem">
        </div>

        <!-- Título -->
        <h1>Cadastro</h1>

        <!-- Formulário -->
        <form action="#" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Digite aqui..." required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite aqui..." required>

            <!-- Indicadores -->
            <div class="dots">
                <span class="dot active"></span>
                <span class="dot active"></span>
                <span class="dot"></span>
            </div>

            <!-- Botões de navegação -->
            <div class="nav-buttons">
                <button type="button" class="btn-nav">&#8592;</button>
                <button type="button" class="btn-home">&#8962;</button>
                <button type="submit" class="btn-nav">&#8594;</button>
            </div>
        </form>
    </div>

</body>
</html>
