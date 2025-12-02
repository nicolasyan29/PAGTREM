<?php

include "db.php";

session_start();

$msg = "";
$errors = [];

if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  $msg = "Você saiu com sucesso.";

  header("Location: ../index.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $login = $_POST["login"] ?? "";
  $senha = $_POST["senha"] ?? "";

  $stmt = $conn->prepare("SELECT id_usuario, nome_completo, senha, tipo_usuario FROM usuario WHERE email=? OR telefone=?");
  $stmt->bind_param("ss", $login, $login);
  $stmt->execute();
  $result = $stmt->get_result();
  $usuario = $result->fetch_assoc();
  $stmt->close();

  $isApi = (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

  if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION["user_id"] = $usuario["id_usuario"];
    $_SESSION["username"] = $usuario["nome_completo"];
    $_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];
    if ($isApi) {
      header('Content-Type: application/json');
      echo json_encode([
        'success' => true,
        'user_id' => $usuario["id_usuario"],
        'username' => $usuario["nome_completo"],
        'tipo_usuario' => $usuario["tipo_usuario"]
      ]);
      exit;
    } else {
      // Permite login para tipo_usuario 1 (funcionário) e 2 (administrador)
      if ($usuario["tipo_usuario"] == 2) {
        header("Location: ../private/pagina_inicial_adm.php");
      } else if ($usuario["tipo_usuario"] == 1) {
        header("Location: pagina_inicial.php");
      } else {
        $errors[] = "Tipo de usuário inválido.";
      }
      exit;
    }
  } else {
    if ($isApi) {
      header('Content-Type: application/json');
      http_response_code(401);
      echo json_encode([
        'success' => false,
        'error' => 'Email/Telefone ou senha incorretos!'
      ]);
      exit;
    } else {
      $errors[] = "Email/Telefone ou senha incorretos!";
    }
  }
}


if (!empty($_SESSION["user_id"])) {
  // Permite acesso para tipo_usuario 1 e 2
  if ($_SESSION["tipo_usuario"] == 2) {
    header("Location: ../private/pagina_inicial_adm.php");
  } else if ($_SESSION["tipo_usuario"] == 1) {
    header("Location: pagina_inicial.php");
  } else {
    // Usuário logado com tipo inválido
    session_unset();
    session_destroy();
    header("Location: login.php?msg=Tipo de usuário inválido");
  }
  exit;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

  <div class="login_icon">
    <img src="../assets/icons/trem_bala_icon.png" alt="icone trem" width="200" height="150">
  </div>

    <div>
      <h3 class="text_volta">Bem vindo </h3>
      <br><br>
      <div class="final_página">
        <form method="post">
          <?php if (!empty($errors)): ?>
            <div class="error">
              <?php foreach ($errors as $error): ?>
                <p style="color:red;"><?= $error ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
          <strong>
            <h2 class="margin">Email ou telefone:</h2>
          </strong>
          <input type="text" class="caixa_login" name="login" required>
          <div><br></div>
          <strong>
            <h2 class="margin">Senha:</h2>
          </strong>
          <input type="password" class="caixa_login" name="senha" required>
          <div><br><br></div>
          <div class="final_página">
            <input type="submit" value="ENTRAR" class="caixa_verde_login">
            <div>
              <div><br><br></div>
             
            </div>
          </div>
        </form>
      </div>
    </div>

</body>

</html>
