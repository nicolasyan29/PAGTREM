<?php
session_start();

if (!isset($_SESSION['cadastro_localizacao'])) {
    header("Location: cadastro3.php");
    exit();
}

include '../config/db.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Converte a data do formato dd/mm/yyyy para yyyy-mm-dd
    if (isset($_SESSION['cadastro_nascimento'])) {
        $data_original = $_SESSION['cadastro_nascimento'];
        $data_formatada = DateTime::createFromFormat('d/m/Y', $data_original);

        if ($data_formatada) {
            $nascimento_formatado = $data_formatada->format('Y-m-d');
        } else {
            $error_message = "Data de nascimento inválida!";
        }
    }

    if (empty($error_message)) {
        $senha_hash = password_hash($_SESSION['cadastro_senha'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare(
            "INSERT INTO usuarios (username, senha, cargo, nome, nascimento, localizacao) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        if ($stmt->execute([
            $_SESSION['cadastro_username'],
            $senha_hash,
            $_SESSION['cadastro_cargo'],
            $_SESSION['cadastro_nome'],
            $nascimento_formatado,
            $_SESSION['cadastro_localizacao']
        ])) {
            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['username'] = $_SESSION['cadastro_username'];

            unset(
                $_SESSION['cadastro_username'],
                $_SESSION['cadastro_senha'],
                $_SESSION['cadastro_cargo'],
                $_SESSION['cadastro_nome'],
                $_SESSION['cadastro_nascimento'],
                $_SESSION['cadastro_localizacao']
            );

            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Erro ao salvar usuário no banco!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concluir Cadastro</title>
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <div>
        <img src="../img/unnamed.png" alt="Logo" width="420" height="250">
    </div>
    <div>
        <h1>Cadastro - Última Etapa</h1>
    </div>
    <div>
        <h2>Confirme para finalizar seu cadastro</h2>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="nav">
                <a href="cadastro3.php" style="text-decoration: none; padding: 10px; background-color: #ccc;">Voltar</a>
                <input type="submit" value="Finalizar Cadastro">
            </div>
        </form>
    </div>
</body>
</html>
