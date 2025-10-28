<?php
session_start();

// Verificar se as sessões anteriores existem
if (!isset($_SESSION['cadastro_username'])) {
    header("Location: cadastro1.php");
    exit();
}

$erro = "";
$nome = $_POST['nome'] ?? "";
$nascimento = $_POST['nascimento'] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $nascimento = trim($_POST["nascimento"]);

    if (empty($nome)) {
        $erro = "Preencha o nome!";
    } elseif (empty($nascimento)) {
        $erro = "Preencha a data de nascimento!";
    } elseif (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $nascimento)) {
        $erro = "Data de nascimento inválida. Use o formato dd/mm/aaaa.";
    } else {
        // Validar se a data é real
        list($dia, $mes, $ano) = explode('/', $nascimento);
        if (!checkdate($mes, $dia, $ano)) {
            $erro = "Data de nascimento inválida.";
        } elseif ($ano > date('Y') || $ano < 1900) {
            $erro = "Ano de nascimento inválido.";
        } else {
            $_SESSION['cadastro_nome'] = $nome;
            $_SESSION['cadastro_nascimento'] = $nascimento;
            header("Location: cadastro3.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Dados Pessoais</title>
    <link rel="stylesheet" href="../style/cadastro2.css">
</head>
<body>
    <div class="container">
        <div class="top-logo">
            <img src="../img/icone pagtrem.png" alt="Trem">
        </div>
        <h2>Cadastro - Etapa 2</h2>
        <form id="cadastroForm" method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite aqui..." value="<?php echo htmlspecialchars($nome); ?>" required>
            <label for="nascimento">Data de nascimento:</label>
            <input type="text" id="nascimento" name="nascimento" placeholder="dd/mm/aaaa" value="<?php echo htmlspecialchars($nascimento); ?>" required maxlength="10">
            <div id="mensagemErro" class="erro">
                <?php if (!empty($erro)) echo htmlspecialchars($erro); ?>
            </div>
            <button type="submit">Próximo</button>
        </form>
        <div class="indicadores">
            <div></div>
            <div class="ativo"></div>
            <div></div>
        </div>
        <div class="navegacao">
            <a href="cadastro1.php">&larr;</a>
            <button type="button" onclick="location.reload()">&#8962;</button>
            <button type="submit" form="cadastroForm">&rarr;</button>
        </div>
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
