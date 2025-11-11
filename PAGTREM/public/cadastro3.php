<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style/cadastro3.css">
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
            <label for="localizacao">Sua localização:</label>
            <select id="localizacao" name="localizacao" required>
                <option value="" disabled selected>Clique aqui</option>
                <option value="sp">São Paulo</option>
                <option value="rj">Rio de Janeiro</option>
                <option value="mg">Minas Gerais</option>
                <option value="rs">Rio Grande do Sul</option>
                <option value="outros">Outros</option>
            </select>

            <!-- Indicadores -->
            <div class="dots">
                <span class="dot active"></span>
                <span class="dot active"></span>
                <span class="dot active"></span>
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
