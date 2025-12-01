<?php
session_start();

$default_user = [
    'id' => 329,
    'nome' => 'Nome',
    'cargo' => 'Administrador',
    'permissoes' => 'Geral',
    'foto' => 'default-profile.png'
];
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = $default_user;
}
$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['novo_nome'])) {
        $user['nome'] = trim($_POST['novo_nome']) !== '' ? trim($_POST['novo_nome']) : 'Nome';
    }

    // Só altera a foto se houver upload novo
    if (isset($_FILES['nova_foto']) && $_FILES['nova_foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['nova_foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $dir = __DIR__ . '/../uploads';
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            $novo_nome_arquivo = 'uploads/perfil_' . $user['id'] . '.' . $ext;
            move_uploaded_file($_FILES['nova_foto']['tmp_name'], __DIR__ . '/../' . $novo_nome_arquivo);
            $user['foto'] = $novo_nome_arquivo;
        }
    } else {

        if (!isset($user['foto']) || empty($user['foto'])) {
            $user['foto'] = $default_user['foto'];
        }
    }

    $_SESSION['user'] = $user;

    if (!isset($_POST['redirect_page'])) {
        header('Location: perfil.php');
        exit();
    }

    if (isset($_POST['redirect_page'])) {
        $page = $_POST['redirect_page'];
        if ($page === 'sensores') {
            header('Location: sensor.php');
            exit();
        } elseif ($page === 'trens') {
            header('Location: trens.php');
            exit();
        } elseif ($page === 'estacoes') {
            header('Location: estacoes.php');
            exit();
        } elseif ($page === 'perfil') {
            header('Location: perfil.php');
            exit();
        } else {
            header('Location: index.php');
            exit();
        }
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'alterar_conta':
            header('Location: login.php');
            exit;
        case 'remover_conta':
            header('Location: voce_tem_certza.php');
            exit;
        case 'suporte':
            header('Location: suporte_alerta.php');
            exit;
        case 'editar':
            header('Location: cadastro1.php');
            exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Perfil</title>
    <link rel="stylesheet" href="../style/style2.css">
    <style>
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: black;
            border-top: 1px solid #0B57DA;
            display: flex;
            justify-content: space-evenly;
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
    </style>
</head>
<body style="<?php if (!empty($fox_image)) { echo 'background-image: url(\'' . htmlspecialchars($fox_image) . '\'); background-size: cover; background-repeat: no-repeat; background-position: center;'; } ?>">
<?php
$backPage = 'pagina_inicial.php';
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
    $backPage = '../private/pagina_inicial_adm.php';
}
?>
<body onload="loadRandomDogBackground()">
<a href="<?= $backPage ?>"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>
    <div class="wrapper">
        <form method="POST" enctype="multipart/form-data" id="perfilForm" class="perfil-container" action="">
            <div class="foto-container">
                <img id="imagemPerfil" src="<?php echo (strpos($user['foto'], 'uploads/') === 0 ? '../' : '../assets/') . htmlspecialchars($user['foto']); ?>" alt="Foto Perfil" />
                <label for="nova_foto" title="Alterar foto de perfil">
                    <img src="../assets/icons/caneta.png" alt="wordEditar Foto" />
                </label>
                <input type="file" name="nova_foto" id="nova_foto" accept="image/*" onchange="previewImagem(this)" />
            </div>

            <div class="nome-editavel" id="nomeDisplay" onclick="editarNome()" title="Clique para editar nome">
<span id="nomeTexto">ANDRIEL</span>
                <img src="../assets/icons/caneta.png" alt="Editar Nome" class="icone-editar" />
            </div>

            <div class="info-section">
                <div class="info">
                    <b>ID</b>
                    #<?php echo $user['id']; ?>
                </div>
                <div class="info">
                    <b>CARGO</b>
                    <?php echo htmlspecialchars($user['cargo']); ?>
                </div>
                <div class="info">
                    <b>PERMISSÕES</b>
                    <?php echo htmlspecialchars($user['permissoes']); ?>
                </div>
            </div>

            <!-- Botão de Logout -->
            <div style="text-align: center; margin-top: 20px;">
                <a href="../public/login.php?logout=1" onclick="return confirm('Tem certeza que deseja sair?')" style="background-color: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Logout</a>
            </div>

            <input type="hidden" name="novo_nome" id="inputNome" value="<?php echo htmlspecialchars($user['nome']); ?>" />
        </form>
    </div>

<script>
    function previewImagem(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagemPerfil').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    const nomeDisplay = document.getElementById('nomeDisplay');
    const nomeTexto = document.getElementById('nomeTexto');
    const inputNome = document.getElementById('inputNome');

    function editarNome() {
        if (nomeDisplay.querySelector('input')) return;
        const input = document.createElement('input');
        input.type = 'text';
        input.value = nomeTexto.textContent;
        input.maxLength = 50;
        input.autofocus = true;
        input.addEventListener('blur', () => salvarNome(input.value));
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                input.blur();
            }
            if (e.key === 'Escape') {
                cancelarEdicao();
            }
        });
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(input);
        input.focus();
    }

    function salvarNome(valor) {
        if (valor.trim() === '') valor = 'Nome';
        nomeTexto.textContent = valor;
        inputNome.value = valor;
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(nomeTexto);
        const icone = document.createElement('img');
        icone.src = '../assets/icons/caneta.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);
        document.getElementById('perfilForm').submit();
    }

    function cancelarEdicao() {
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(nomeTexto);
        const icone = document.createElement('img');
        icone.src = '../assets/icons/caneta.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);
    }
</script>
</body>
</html>
