<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PagTrem</title>
    <link rel="stylesheet" href="../style/login.css">
</head>
<body>
    <div class="container">

        
        <div class="icone-topo">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" viewBox="0 0 24 24">
                <path d="M12 2c4.97 0 9 1.79 9 4v10c0 2.21-4.03 4-9 4s-9-1.79-9-4V6c0-2.21 4.03-4 9-4zm0 2c-3.87 0-7 .9-7 2s3.13 2 7 2 7-.9 7-2-3.13-2-7-2z"/>
            </svg>
        </div>

        
        <h2>Login</h2>

        
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" placeholder="Digite aqui...">

        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" placeholder="Digite aqui...">

        
        <a href="redefinir_senha.php" class="link-esqueci">Esqueceu sua senha?</a>

        
        <div class="lembrar">
            <label class="switch">
                <input type="checkbox" id="lembrar">
                <span class="slider"></span>
            </label>
            <span>Lembrar senha</span>
        </div>

        
        <button type="submit">Fazer login</button>

    </div>

</body>
</html>
