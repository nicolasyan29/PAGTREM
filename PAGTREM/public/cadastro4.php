<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style/cadastro4.css">
</head>
<body>

    <div class="container">
        <!-- Ícone do topo -->
        <div class="icon-top">
            <img src="icone-trem.png" alt="Ícone Trem">
        </div>

        <!-- Título -->
        <h1>Cadastro</h1>

        <!-- Área de upload -->
        <div class="profile-upload">
            <label for="foto">
                <div class="profile-icon">
                    <img src="icone-usuario.png" alt="Usuário">
                    <img src="icone-editar.png" class="edit-icon" alt="Editar">
                </div>
            </label>
            <input type="file" id="foto" name="foto" accept="image/*" hidden>
        </div>

        <!-- Texto informativo -->
        <p>Selecione uma foto de perfil uniformizado.</p>

        <!-- Botão de continuar -->
        <button class="btn-continuar" disabled>Continuar</button>

        <!-- Botões de navegação -->
        <div class="nav-buttons">
            <button type="button" class="btn-nav">&#8592;</button>
            <button type="button" class="btn-home">&#8962;</button>
            <button type="button" class="btn-nav">&#8594;</button>
        </div>
    </div>

    <script>
        // Ativa o botão quando uma foto é selecionada
        const fotoInput = document.getElementById("foto");
        const btnContinuar = document.querySelector(".btn-continuar");

        fotoInput.addEventListener("change", () => {
            if (fotoInput.files.length > 0) {
                btnContinuar.disabled = false;
                btnContinuar.classList.add("ativo");
            }
        });
    </script>

</body>
</html>
