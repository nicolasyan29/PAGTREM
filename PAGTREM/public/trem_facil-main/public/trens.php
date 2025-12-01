<?php
// --- Conexão ---
$db_host = 'localhost';
$db_name = 'trem_facil';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// --- Lógica de Busca ---
$trens_para_exibir = [];

// 1. Busca as Linhas (Trens)
$sql_linhas = "SELECT id_linha, id_exibicao, nome, status, status_color FROM linha ORDER BY id_exibicao ASC";
$linhas_db = $pdo->query($sql_linhas)->fetchAll();

foreach ($linhas_db as $linha) {
    // 2. Paradas
    $stmt_paradas = $pdo->prepare("SELECT nome, tempo FROM parada WHERE id_linha = ?");
    $stmt_paradas->execute([ $linha['id_linha'] ]);
    $linha['paradas'] = $stmt_paradas->fetchAll();

    // 3. Horários
    $stmt_eh = $pdo->prepare("SELECT id_estacao_horario, nome_estacao FROM estacao_horario WHERE id_linha = ?");
    $stmt_eh->execute([ $linha['id_linha'] ]);
    
    $horarios_agrupados = [];
    foreach ($stmt_eh->fetchAll() as $eh) {
        $stmt_h = $pdo->prepare("SELECT TIME_FORMAT(hora, '%H:%i') as h FROM horario WHERE id_estacao_horario = ? ORDER BY hora ASC");
        $stmt_h->execute([ $eh['id_estacao_horario'] ]);
        $times = $stmt_h->fetchAll(PDO::FETCH_COLUMN);
        if($times) $horarios_agrupados[ $eh['nome_estacao'] ] = $times;
    }
    $linha['horarios'] = $horarios_agrupados;
    $trens_para_exibir[] = $linha;
}

// --- Redirecionamento ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = $_POST['redirect_page'] ?? '';
    $paginas = ['sensores', 'trens', 'estacoes', 'perfil'];
    if(in_array($page, $paginas)) {
        header("Location: $page.php");
        exit;
    }
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trens</title>
    <link rel="stylesheet" href="../style/style3.css">
</head>
<?php
session_start();
$backPage = 'pagina_inicial.php';
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
    $backPage = '../private/pagina_inicial_adm.php';
}
?>
<body>


<div class="container">
    <header>
        <a href="<?= $backPage ?>"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>
    </header>

    <div class="search-container">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Pesquisar Trem..." autocomplete="off">
    </div>

    <div id="trainContainer">
        <?php foreach ($trens_para_exibir as $trem): ?>
            <div class="trem" data-nome="<?= strtolower(htmlspecialchars($trem['nome'])) ?>">
                
                <div class="header-trem">
                    <div class="info-trem">
                        <img src="../assets/icons/trem_icon_lista.png" width="45" height="45" onerror="this.style.display='none'">
                        <div>
                            <div class="titulo-trem"><?= htmlspecialchars($trem['nome']) ?></div>
                            <div class="id-status">
                                <span style="color:#ccc; margin-right:10px;">ID #<?= $trem['id_exibicao'] ?></span>
                                
                                <span class="status-text" style="color: <?= $trem['status_color'] ?>">
                                    <span class="status-dot" style="background-color: <?= $trem['status_color'] ?>"></span>
                                    <?= htmlspecialchars($trem['status']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button class="btn-notify">🔔</button>
                </div>

                <?php if (!empty($trem['paradas'])): ?>
                    <div class="paradas">Status Local:</div>
                    <div class="paradas-list">
                        <?php foreach ($trem['paradas'] as $p): 
                            $isAgora = (strtolower(trim($p['tempo'])) == 'agora');
                            $cor = $isAgora ? '#00c853' : '#ccc';
                        ?>
                            <div class="parada-item">
                                <span><?= htmlspecialchars($p['nome']) ?></span>
                                <span style="color: <?= $cor ?>; font-weight: <?= $isAgora?'bold':'normal' ?>">
                                    <?= htmlspecialchars($p['tempo']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($trem['horarios'])): ?>
                    <div class="horarios-container">
                        <label class="toggle-label" for="t-<?= $trem['id_linha'] ?>">
                            <span>Ver Horários</span>
                            <div class="toggle-switch">
                                <input type="checkbox" id="t-<?= $trem['id_linha'] ?>" onchange="toggleHorario(this)">
                                <span class="slider"></span>
                            </div>
                        </label>
                        <div class="horarios" id="h-<?= $trem['id_linha'] ?>" style="display:none;">
                            <?php foreach ($trem['horarios'] as $est => $horas): ?>
                                <div class="horarios-column">
                                    <strong><?= htmlspecialchars($est) ?></strong>
                                    <div class="horarios-list">
                                        <?php foreach ($horas as $h) echo "<span>$h</span>"; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Pesquisa
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.trem').forEach(t => {
            t.style.display = t.getAttribute('data-nome').includes(term) ? '' : 'none';
        });
    });

   // horarios
    function toggleHorario(checkbox) {
        const id = checkbox.id.replace('t-', 'h-');
        document.getElementById(id).style.display = checkbox.checked ? 'flex' : 'none';
    }
</script>
</body>
</html>
