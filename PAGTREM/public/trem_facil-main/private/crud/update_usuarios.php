<?php
include '../../public/db.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../lista_usuarios.php");
    exit();
}

$id = (int)$_GET['id'];
$errors = [];
$data = [
  'nome_completo' => '',
  'cpf' => '',
  'cep' => '',
  'email' => '',
  'telefone' => '',
  'nome_usuario' => '', // Caso queira usar
];

// POST: salvar alterações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $data['nome_completo'] = trim($_POST['nome_completo'] ?? '');
    $data['cpf'] = trim($_POST['cpf'] ?? '');
    $data['cep'] = trim($_POST['cep'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['telefone'] = trim($_POST['telefone'] ?? '');
    
    // Validações
    if (!$data['nome_completo']) $errors[] = "Nome completo é obrigatório.";
    if (!$data['cpf'] || !preg_match('/^\d{11}$/', $data['cpf'])) $errors[] = "CPF inválido.";
    if (!$data['cep'] || !preg_match('/^\d{8}$/', $data['cep'])) $errors[] = "CEP inválido.";
    if (!$data['email'] || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido.";
    if (!$data['telefone'] || !preg_match('/^\d{10,11}$/', $data['telefone'])) $errors[] = "Telefone inválido.";
    
    // Evitar duplicidade em outros usuários
    if (!$errors) {
        $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE (cpf = ? OR email = ? OR telefone = ?) AND id_usuario != ?");
        $stmt->bind_param("sssi", $data['cpf'], $data['email'], $data['telefone'], $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "CPF, email ou telefone já cadastrados para outro usuário.";
        }
        $stmt->close();
    }
    
    // Atualizar dados
    if (!$errors) {
        $stmt = $conn->prepare("UPDATE usuario SET nome_completo=?, cpf=?, cep=?, email=?, telefone=? WHERE id_usuario=?");
        $stmt->bind_param("sssssi", $data['nome_completo'], $data['cpf'], $data['cep'], $data['email'], $data['telefone'], $id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: ../lista_usuarios.php?msg=Usuário atualizado com sucesso");
            exit();
        } else {
            $errors[] = "Erro ao atualizar usuário: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    // GET: carregar dados atuais do usuário para preencher o formulário
    $stmt = $conn->prepare("SELECT nome_completo, cpf, cep, email, telefone FROM usuario WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome_completo, $cpf, $cep, $email, $telefone);
    if ($stmt->fetch()) {
        $data = compact('nome_completo', 'cpf', 'cep', 'email', 'telefone');
    } else {
        $stmt->close();
        header("Location: ../lista_usuarios.php?msg=Usuário não encontrado");
        exit();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar Usuário - Trem Fácil</title>
<style>
  /* Reutilize seu estilo baseado em cadastrar_user.php, adaptando cores, fontes, responsividade etc. */
  @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
  body {
    margin: 0; background: #000; color: white; font-family: 'Montserrat', sans-serif;
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
  form input[type=text], form input[type=email], form input[type=tel] {
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
</style>
</head>
<body>

<div class="container" role="main" aria-label="Editar usuário">
  <h1>Editar Usuário</h1>

  <?php if ($errors): ?>
    <div class="errors" role="alert" aria-live="assertive">
      <?php echo implode('<br>', $errors); ?>
    </div>
  <?php endif; ?>

  <form method="post" novalidate>
    <input type="text" name="nome_completo" placeholder="Nome completo" required autofocus value="<?php echo htmlspecialchars($data['nome_completo']); ?>" />
    <input type="text" name="cpf" placeholder="CPF (apenas números)" maxlength="11" pattern="\d{11}" value="<?php echo htmlspecialchars($data['cpf']); ?>" required />
    <input type="text" name="cep" placeholder="CEP (apenas números)" maxlength="8" pattern="\d{8}" value="<?php echo htmlspecialchars($data['cep']); ?>" required />
    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($data['email']); ?>" required />
    <input type="tel" name="telefone" placeholder="Telefone (apenas números)" maxlength="11" pattern="\d{10,11}" value="<?php echo htmlspecialchars($data['telefone']); ?>" required />
    <button type="submit">ATUALIZAR</button>
  </form>
</div>

</body>
</html>
