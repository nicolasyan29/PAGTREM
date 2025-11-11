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
        <div class="icon-top">
            <img src="icone-trem.png" alt="Ícone Trem">
        </div>

        <h1>Cadastro</h1>

        <div class="profile-upload">
            <label for="foto">
                <div class="profile-icon">
                    <img src="icone-usuario.png" alt="Usuário">
                    <img src="icone-editar.png" class="edit-icon" alt="Editar">
                </div>
            </label>
            <input type="file" id="foto" name="foto" accept="image/*" hidden>
        </div>

        <p>Selecione uma foto de perfil uniformizado.</p>

        <button class="btn-continuar" disabled>Continuar</button>

        <div class="nav-buttons">
            <button type="button" class="btn-nav">&#8592;</button>
            <button type="button" class="btn-home">&#8962;</button>
            <button type="button" class="btn-nav">&#8594;</button>
        </div>
    </div>

    <script>
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
