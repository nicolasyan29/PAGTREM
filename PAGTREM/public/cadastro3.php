<?php
session_start();

// Verificar se as sessões anteriores existem
if (!isset($_SESSION['cadastro_nome'])) {
    header("Location: cadastro2.php");
    exit();
}

$message = "";
$address = $_POST['address'] ?? "";
$city = $_POST['city'] ?? "";
$state = $_POST['state'] ?? "";
$zip_code = $_POST['zip_code'] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zip_code = trim($_POST['zip_code']);

    if (empty($address) || empty($city) || empty($state) || empty($zip_code)) {
        $message = "Todos os campos são obrigatórios.";
    } elseif (!preg_match("/^\d{5}-\d{3}$/", $zip_code)) {
        $message = "CEP inválido. Use o formato 00000-000.";
    } else {
        $localizacao = $address . ', ' . $city . ', ' . $state . ' - ' . $zip_code;
        $_SESSION['cadastro_localizacao'] = $localizacao;
        header("Location: cadastro4.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Localização</title>
    <link rel="stylesheet" href="../style/cadastro3.css">
</head>
<body>
    <div>
        <img src="../img/unnamed.png" alt="Logo" width="420" height="250">
    </div>
    <div>
        <h1>Cadastro - Etapa 3</h1>
    </div>
    <div>
        <h2>Sua Localização</h2>
        <?php if ($message): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="address">Endereço:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br><br>
            <label for="city">Cidade:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required><br><br>
            <label for="state">Estado:</label>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($state); ?>" required><br><br>
            <label for="zip_code">CEP:</label>
            <input type="text" id="zip_code" name="zip_code" value="<?php echo htmlspecialchars($zip_code); ?>" placeholder="00000-000" required maxlength="9"><br><br>
            <button type="submit">Salvar Localização</button>
        </form>
        <div style="margin-top: 20px;">
            <a href="cadastro2.php" style="text-decoration: none; padding: 10px; background-color: #ccc;">Voltar</a>
        </div>
    </div>
    <div>
        <img src="../img/baradeCarregamento.png" alt="Loading Bar">
    </div>
    <script src="../script/script.js"></script>
</body>
</html>
