<?php
session_start();
include '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailOrUsername = trim($_POST['email']);

    if (!empty($emailOrUsername)) {
        $stmt = $conn->prepare("SELECT pk FROM ususarios WHERE username = ?");
        $stmt->bind_param("s", $emailOrUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
           
            $success = "Instruções para redefinir a senha, foram enviadas para o seu e-mail.";
           
        } else {
            $error = "E-mail ou usuário não encontrado.";
        }
        $stmt->close();
    } else {
        $error = "Por favor, preencha o campo.";
    }
}
$conn->close();
?>

<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Redefinir Senha</title>
  <link rel="stylesheet" href="../style/recuperaçãodesenha.css">
</head>
<body>
  <div class="container">
    <div class="icon-top">
      <img src="../img/icone pagtrem-Photoroom.png" alt="">
    </div>
    <h2>Preencha as informações<br>para redefinir sua senha</h2>

    <?php if ($error): ?>
      <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="email">Seu e-mail ou usuário</label>
      <input type="text" id="email" name="email" placeholder="Digite aqui..." required>
      <button type="submit">Enviar</button>
    </form>
    <div class="icon-key">
      <i class="fa fa-user"></i>
      <i class="fa fa-key"></i>
    </div>
    <div class="footer-icons">
      <i class="fa fa-arrow-left"></i>
      <i class="fa fa-home"></i>
      <i class="fa fa-arrow-right"></i>
    </div>
  </div>
  <script src="../script/script.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
