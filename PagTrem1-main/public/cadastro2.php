<?php
session_start();

$erro = "";
$nome = "";
$nascimento = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $nascimento = trim($_POST["nascimento"]);

    if (empty($nome) || empty($nascimento)) {
        $erro = "Preencha todos os campos!";
    } elseif (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $nascimento)) {
        $erro = "Data de nascimento inválida. Use o formato dd/mm/aaaa.";
    } else {
        $_SESSION['cadastro_nome'] = $nome;
        $_SESSION['cadastro_nascimento'] = $nascimento;
        header("Location: cadastro3.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - PagTrem</title>
    <link rel="stylesheet" href="../style/cadastro2.css">
</head>
<body>
    <div class="container">
        <div class="top-logo">
            <img src="https://img.icons8.com/ios-filled/50/train.png" alt="Trem">
        </div>
        <h2>Cadastro</h2>
        <form id="cadastroForm" method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite aqui..." value="<?php echo htmlspecialchars($nome); ?>" required>
            <label for="nascimento">Data de nascimento:</label>
            <input type="text" id="nascimento" name="nascimento" placeholder="dd / mm / aaaa" value="<?php echo htmlspecialchars($nascimento); ?>" required>
            <div id="mensagemErro" class="erro">
                <?php if (!empty($erro)) echo $erro; ?>
            </div>
            <button type="submit">Próximo</button>
        </form>
        <div class="indicadores">
            <div class="ativo"></div>
            <div></div>
            <div></div>
        </div>
        <div class="navegacao">
            <button>&larr;</button>
            <button>&#8962;</button>
            <button>&rarr;</button>
        </div>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
