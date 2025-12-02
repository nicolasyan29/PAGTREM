<?php

include '../public/db.php';
session_start();

$errors = [];
$step = 1;
$data = $_SESSION['usuario_form'] ?? [
  'nome_completo' => '',
  'cpf' => '',
  'cep' => '',
  'email' => '',
  'telefone' => '',
  'senha' => '',
  'confirmar_senha' => '',
  'nome_usuario' => '',
  'tipo_usuario' => 2
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $step = isset($_POST['step']) ? (int)$_POST['step'] : 1;

  if ($step === 1) {
    $data['nome_completo'] = trim($_POST['nome_completo'] ?? '');
    $data['cpf'] = trim($_POST['cpf'] ?? '');
    $data['cep'] = trim($_POST['cep'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');

    if (!$data['nome_completo']) $errors[] = "Nome completo é obrigatório.";
    if (!$data['cpf'] || !preg_match('/^\d{11}$/', $data['cpf'])) $errors[] = "CPF deve conter 11 números.";
    if (!$data['cep'] || !preg_match('/^\d{8}$/', $data['cep'])) $errors[] = "CEP deve conter 8 números.";
    if (!$data['email'] || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido.";

    if (!$errors) {
      $_SESSION['usuario_form'] = $data;
      $step = 2;
    }
  } else {
    $data['telefone'] = trim($_POST['telefone'] ?? '');
    $data['senha'] = $_POST['senha'] ?? '';
    $data['confirmar_senha'] = $_POST['confirmar_senha'] ?? '';
    $data['nome_usuario'] = trim($_POST['nome_usuario'] ?? '');

    if (!$data['telefone'] || !preg_match('/^\d{10,11}$/', $data['telefone'])) $errors[] = "Telefone deve conter 10 ou 11 números.";
    if (!$data['nome_usuario']) $errors[] = "Nome de usuário é obrigatório.";
    if (strlen($data['senha']) < 6) $errors[] = "Senha deve ter no mínimo 6 caracteres.";
    if ($data['senha'] !== $data['confirmar_senha']) $errors[] = "As senhas não conferem.";

    if (!$errors) {
      $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE email = ? OR cpf = ? OR telefone = ?");
      $stmt->bind_param("sss", $data['email'], $data['cpf'], $data['telefone']);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $errors[] = "Usuário com email, CPF ou telefone já cadastrado.";
      }
      $stmt->close();
    }

    if (!$errors) {
      $senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT);
      $stmt = $conn->prepare("INSERT INTO usuario (nome_completo, email, telefone, cep, cpf, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssi", $data['nome_completo'], $data['email'], $data['telefone'], $data['cep'], $data['cpf'], $senha_hash, $data['tipo_usuario']);
      if ($stmt->execute()) {
        unset($_SESSION['usuario_form']);
        header("Location: lista_usuarios.php?msg=Usuário cadastrado com sucesso");
        exit();
      } else {
        $errors[] = "Erro ao cadastrar: " . $stmt->error;
      }
      $stmt->close();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Cadastrar Usuário - Trem Fácil</title>
<style>
  body {
    margin: 0; background: #000; color: white; font-family: Arial, sans-serif;
    display: flex; justify-content: center; align-items: flex-start; min-height: 100vh;
    padding: 20px 10px; box-sizing: border-box;
  }
  .container {
    max-width: 360px; width: 100%;
    background: #111; text-align: center;
    border-radius: 25px; padding: 30px 25px 60px;
    margin-top: 20px;
    box-shadow: 0 2px 9px rgba(11, 87, 218, 0.3);
  }
  h1 {
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: white;
  }
  .icon-user {
    font-size: 5rem;
    color: #006400; /* Verde escuro */
    margin-bottom: 20px;
  }
  form input[type=text], form input[type=email], form input[type=tel], form input[type=password] {
    width: 100%;
    border-radius: 28px;
    border: 1px solid #0B57DA;
    padding: 15px 20px;
    margin: 12px 0;
    font-size: 1.15rem;
    text-align: center;
    font-weight: 500;
    color: white;
    background-color: #222;
    outline: none;
    box-sizing: border-box;
  }
  form input::placeholder {
    color: #777;
  }
  button {
    width: 100%;
    padding: 15px;
    background: #0B57DA;
    border: none;
    border-radius: 28px;
    color: white;
    font-size: 1.35rem;
    font-weight: 800;
    margin-top: 18px;
    cursor: pointer;
    user-select: none;
    transition: background-color 0.3s ease;
    box-sizing: border-box;
  }
  button:hover {
    background: #0943b0;
  }
  .errors {
    background: #e74c3c; border-radius: 15px; color: white;
    padding: 12px 15px; margin-bottom: 15px;
    font-weight: 600; text-align: left;
  }
  .page-indicator {
    margin-top: 22px;
  }
  .page-indicator span {
    display: inline-block;
    width: 14px; height: 14px;
    margin: 0 8px;
    border-radius: 50%;
    background-color: #333;
  }
  .page-indicator span.active {
    background-color: #0B57DA;
  }
  footer {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: 80px;
    background: #000;
    border-top: 1px solid #0B57DA;
    display: flex;
    justify-content: space-around;
    align-items: center;
    user-select: none;
  }
  footer form {display: inline;}
  footer button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
  }
  footer img {
    width: 60px;
    height: 60px;
  }

  /* Responsividade adicional */
  @media (max-width: 480px) {
    .container {
      padding: 20px 15px 40px;
      margin-top: 10px;
    }
    h1 {
      font-size: 2rem;
    }
    .icon-user {
      font-size: 4rem;
    }
    form input[type=text], form input[type=email], form input[type=tel], form input[type=password] {
      padding: 12px 15px;
      font-size: 1rem;
    }
    button {
      padding: 12px;
      font-size: 1.2rem;
    }
  }
</style>
</head>
<body>
<div class="container" role="main" aria-label="Cadastrar usuário">

  <div class="icon-user">&#128100;</div>
  <h1>Novo Usuário</h1>

  <?php if ($errors): ?>
    <div class="errors" role="alert" aria-live="assertive">
      <?php echo implode('<br>', $errors); ?>
    </div>
  <?php endif; ?>

  <form method="post" novalidate>
    <input type="hidden" name="step" value="<?php echo $step; ?>" />
    
    <?php if ($step === 1): ?>
      <input type="text" name="nome_completo" placeholder="Nome completo" required autofocus value="<?php echo htmlspecialchars($data['nome_completo']); ?>" />
      <input type="text" name="cpf" placeholder="CPF (apenas números)" maxlength="11" pattern="\d{11}" value="<?php echo htmlspecialchars($data['cpf']); ?>" required />
      <input type="text" name="cep" id="cep" placeholder="CEP (apenas números)" maxlength="8" pattern="\d{8}" value="<?php echo htmlspecialchars($data['cep']); ?>" required />
      <div id="cep-result" style="background:#111;border-radius:12px;padding:12px 18px;margin:8px 0 0;display:none;color:white;text-align:left;font-size:0.98rem"></div>
      <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($data['email']); ?>" required />
      <button type="submit">PRÓXIMO</button>
    <?php else: ?>
      <input type="tel" name="telefone" placeholder="Telefone (apenas números)" maxlength="11" pattern="\d{10,11}" value="<?php echo htmlspecialchars($data['telefone']); ?>" required autofocus />
      <input type="password" name="senha" placeholder="Senha (min 6 caracteres)" minlength="6" required />
      <input type="password" name="confirmar_senha" placeholder="Confirmar senha" minlength="6" required />
      <input type="text" name="nome_usuario" placeholder="Nome de Usuário" value="<?php echo htmlspecialchars($data['nome_usuario']); ?>" required />
      <button type="submit">REGISTRAR</button>
    <?php endif; ?>
  </form>

  <div class="page-indicator">
    <span class="<?php echo $step === 1 ? 'active' : ''; ?>"></span>
    <span class="<?php echo $step === 2 ? 'active' : ''; ?>"></span>
  </div>

</div>

<script>
// Consulta ViaCEP ao sair do campo CEP
const cepInput = document.getElementById('cep');
const cepResult = document.getElementById('cep-result');
if (cepInput && cepResult) {
  cepInput.addEventListener('blur', function() {
    const cep = cepInput.value.replace(/\D/g, '');
    if (cep.length === 8) {
      cepResult.textContent = 'Buscando endereço...';
      cepResult.style.display = 'block';
      fetch('https://viacep.com.br/ws/' + cep + '/json/')
        .then(r => r.json())
        .then(data => {
          if (data.erro) {
            cepResult.textContent = 'CEP não encontrado.';
          } else {
            cepResult.innerHTML =
              '<strong>Logradouro:</strong> ' + (data.logradouro || '-') + '<br>' +
              '<strong>Bairro:</strong> ' + (data.bairro || '-') + '<br>' +
              '<strong>Cidade:</strong> ' + (data.localidade || '-') + '<br>' +
              '<strong>UF:</strong> ' + (data.uf || '-') + '<br>' +
              '<strong>DDD:</strong> ' + (data.ddd || '-');
          }
        })
        .catch(() => {
          cepResult.textContent = 'Erro ao consultar o CEP.';
        });
    } else {
      cepResult.style.display = 'none';
      cepResult.textContent = '';
    }
  });
}
</script>

</body>
</html>
