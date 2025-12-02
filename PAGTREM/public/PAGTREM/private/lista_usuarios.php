<?php
include '../public/db.php';
session_start();

$search = $_GET['search'] ?? '';
if ($search) {
    $like = "%$search%";
    $stmt = $conn->prepare("SELECT id_usuario, nome_completo, cpf, telefone, tipo_usuario FROM usuario WHERE nome_completo LIKE ? ORDER BY nome_completo ASC");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id_usuario, nome_completo, cpf, telefone, tipo_usuario FROM usuario ORDER BY nome_completo ASC");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Lista de Usuários - Trem Fácil</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
  body {
    margin: 0; font-family: 'Montserrat', sans-serif;
    background: #000;
    color: white;
    display: flex;
    justify-content: center;
    width: 100%;
  }
  .container {
    width: 100%;
    padding: 10px 15px 100px;
  }
  header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }
  header a.back-btn {
    text-decoration: none;
    color: #0B57DA;
    font-weight: 700;
    font-size: 1.3rem;
  }
  header a.back-btn img {
    width: 40px;
    height: 40px;
  }
  header a.back-btn:hover {
    text-decoration: underline;
  }
  h1 {
    font-size: 1.4rem;
    font-weight: 700;
  }
  form.search-form input[type="search"] {
    width: 100%;
    background: none;
    border: none;
    border-bottom: 2.5px solid #0B57DA;
    color: white;
    font-size: 1.05rem;
    padding: 8px 0;
    margin-bottom: 18px;
    outline: none;
  }
  form.search-form input::placeholder {
    color: #777;
    font-style: italic;
  }
  button.btn-add {
    width: 100%;
    background: #0B57DA;
    border-radius: 30px;
    border: none;
    padding: 14px;
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 12px;
    cursor: pointer;
    user-select: none;
    transition: background-color 0.3s ease;
  }
  button.btn-add:hover {
    background: #0943b0;
  }
  article.user-card {
    background: #111;
    border-radius: 18px;
    padding: 14px 18px;
    margin-bottom: 12px;
  }
  article.user-card strong.nome {
    font-weight: 700;
    font-size: 1.2rem;
    text-transform: uppercase;
    margin-bottom: 6px;
    display: block;
  }
  article.user-card span.cargo {
    color: #0B57DA;
    font-weight: 700;
  }
  article.user-card .dados {
    font-size: 0.9rem;
    margin-bottom: 8px;
  }
  article.user-card .acoes {
    display: flex;
    gap: 12px;
  }
  a.acao-btn {
    background: #0B57DA;
    padding: 4px 12px;
    border-radius: 30px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    font-size: 1rem;
    user-select: none;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s ease;
  }
  a.acao-btn:hover {
    background: #0943b0;
  }
  a.acao-btn.delete {
    background: #e74c3c;
    color: #fff;
  }
  a.acao-btn.delete:hover {
    background: #c0392b;
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
  footer form {
    display: inline;
  }
  footer button {
    border: none;
    background: none;
    cursor: pointer;
  }
  footer img {
    width: 60px;
    height: 60px;
  }
  @media (max-width: 480px) {
    .container {
      padding: 8px 2px 90px;
      max-width: 100vw;
    }
    article.user-card {
      padding: 10px 6px;
      font-size: 0.95rem;
    }
    button.btn-add {
      padding: 10px;
      font-size: 1.1rem;
    }
    footer img {
      width: 44px;
      height: 44px;
    }
    footer {
      height: 60px;
      padding: 0 2px;
    }
  }
</style>
</head>
<body>

<div class="container" role="main" aria-label="Lista de usuários">
  <header>
    <a href="pagina_inicial_adm.php" class="back-btn" aria-label="Voltar"><img src="../assets/icons/seta_esquerda.png" alt="Voltar"></a>
    <h1>Lista de Usuários</h1>
  </header>

  <form class="search-form" method="get" action="">
    <input type="search" name="search" placeholder="Pesquisar Usuários" value="<?php echo htmlspecialchars($search); ?>" aria-label="Pesquisar Usuários" />
  </form>

  <button class="btn-add" onclick="location.href='cadastrar_user.php'">ADICIONAR USUÁRIO</button>

  <?php
    if ($result->num_rows === 0) {
      echo '<p style="color:#777; text-align:center;">Nenhum usuário encontrado.</p>';
    } else {
      while ($user = $result->fetch_assoc()) {
        $cargo_texto = ($user['tipo_usuario'] == 2) ? 'ADMINISTRADOR' : 'FUNCIONÁRIO';
        $cpf_formt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user['cpf']);
  ?>
    <article class="user-card" tabindex="0" aria-label="Usuário <?php echo htmlspecialchars($user['nome_completo']); ?>">
      <strong class="nome"><?php echo htmlspecialchars($user['nome_completo']); ?></strong>
      <div class="dados">
        CARGO: <span class="cargo"><?php echo $cargo_texto; ?></span><br/>
        ID: <?php echo $user['id_usuario']; ?><br/>
        TELEFONE: <?php echo htmlspecialchars($user['telefone']); ?><br/>
        CPF: <?php echo $cpf_formt; ?>
      </div>
      <div class="acoes">
        <a href="crud/update_usuarios.php?id=<?php echo $user['id_usuario']; ?>" class="acao-btn" title="Editar Usuário">&#9998; Editar</a>
        <a href="crud/delete_usuarios.php?id=<?php echo $user['id_usuario']; ?>" class="acao-btn delete" title="Excluir Usuário" onclick="return confirm('Confirma exclusão?');">&#128465; Excluir</a>
      </div>
    </article>
  <?php }} ?>

</div>

<script>
// Torna o footer funcional para alternar entre telas
const forms = document.querySelectorAll('footer form');
forms.forEach(form => {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const page = form.querySelector('input[name="redirect_page"]').value;
    window.location.href = `../public/${page}.php`;
  });
});
</script>

</body>
</html>