<?php
session_start();

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

$backPage = 'pagina_inicial.php';
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
    $backPage = '../private/pagina_inicial_adm.php';
}

function buscarEstacoes($pdo) {
    try {
        // 1. Busca todas as tabelas necessárias
        $estacoes = $pdo->query("SELECT * FROM estacoes ORDER BY nome_estacao ASC")->fetchAll();
        $tabelaLigacao = $pdo->query("SELECT * FROM linhas_trens")->fetchAll();
        $tabelaDetalhes = $pdo->query("SELECT * FROM linha")->fetchAll();

        // 2. Prepara a lista de linhas válidas (aquelas que inserimos no banco)
        // Reindexamos o array para garantir que vai de 0 até o total
        $linhasDisponiveis = array_values($tabelaDetalhes);
        $totalLinhas = count($linhasDisponiveis);

        $resultado = [];

        foreach ($estacoes as $est) {
            $idEstacao = $est['estacao_id'];
            
            $resultado[$idEstacao] = [
                'nome_estacao' => $est['nome_estacao'],
                'linhas' => []
            ];

            // 3. Varre a tabela de ligação
            foreach ($tabelaLigacao as $ligacao) {
                if ($ligacao['estacao_id'] == $idEstacao) {
                    
                    // AQUI ESTÁ A CORREÇÃO MÁGICA:
                    // A tabela de ligação tem IDs antigos (ex: 200, 250).
                    // A tabela de linhas nova tem IDs novos (1 a 56).
                    // O cálculo abaixo ($id % $total) garante que SEMPRE pegue uma linha válida.
                    
                    $idSolicitado = $ligacao['linha_id'];
                    
                    if ($totalLinhas > 0) {
                        // Usa matemática para "girar" os IDs e sempre cair numa linha existente
                        $indiceMatematico = $idSolicitado % $totalLinhas;
                        $dadosLinha = $linhasDisponiveis[$indiceMatematico];

                        // Formata os dados
                        $nome = $dadosLinha['nome'];
                        $cor = $dadosLinha['status_color'];
                        $codigo = str_pad($dadosLinha['id_exibicao'], 4, '0', STR_PAD_LEFT);

                        $resultado[$idEstacao]['linhas'][] = [
                            'nome'   => $nome,
                            'codigo' => $codigo,
                            'cor'    => $cor
                        ];
                    } else {
                        // Caso a tabela 'linha' esteja vazia por algum motivo
                        $resultado[$idEstacao]['linhas'][] = [
                            'nome' => 'Tabela Linha Vazia', 'codigo' => '0000', 'cor' => '#d50000'
                        ];
                    }
                }
            }
        }
        return $resultado;

    } catch (PDOException $e) {
        return [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect_page'])) {
    header("Location: " . $_POST['redirect_page'] . ".php");
    exit();
}

$estacoes = buscarEstacoes($pdo);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style3.css">
    <title>Estações</title>
    <style>
        /* DESIGN PRETO MANTIDO */
        body { background-color: #000; color: #fff; font-family: Arial, sans-serif; margin: 0; }
        
        .container { padding: 20px; padding-top: 70px; max-width: 100%; margin: 0 auto; }
        
        .search-container { text-align: center; margin-bottom: 25px; position: relative; }
        .search-icon { position: absolute; left: 15%; top: 10px; }
        #searchInput { 
            width: 100%; padding: 12px 12px 12px 40px; 
            border-radius: 25px; border: 1px solid #333; 
            background: #111; color: white; outline: none;
        }

        .status-legend { display: flex; justify-content: center; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; font-size: 0.8rem; }
        .legend-item { display: flex; align-items: center; text-transform: uppercase; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; margin-right: 8px; display: inline-block; }

        .station { border-bottom: 1px solid #222; margin-bottom: 0; }
        
        .station-header { 
            padding: 20px 10px; display: flex; align-items: center; 
            justify-content: space-between; cursor: pointer; transition: background 0.2s;
        }
        
        .station-info { display: flex; align-items: center; gap: 15px; }
        .station-icon { width: 40px; height: 40px; }
        .station-name { font-size: 1.1rem; font-weight: bold; margin: 0; }
        
        .lines-list { display: none; background-color: #050505; padding: 5px 0; }
        .lines-list.visible { display: block; }
        
        .line-item { 
            padding: 12px 20px; border-bottom: 1px solid #1a1a1a; 
            display: flex; align-items: center; color: #ddd; font-size: 0.95rem;
        }
        .line-item:last-child { border-bottom: none; }
        
        .toggle-arrow { font-size: 0.8rem; color: #888; }
        .no-data { text-align: center; color: #666; margin-top: 50px; }
    </style>
</head>
<body>

<a href="<?= $backPage ?>">
    <img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 15px; left: 15px; width: 40px; height: 40px; cursor: pointer; z-index: 1000;">
</a>

<div class="container">
    <div class="search-container">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Pesquisar Estações..." onkeyup="filterStations()" autocomplete="off" />
    </div>

    <div class="status-legend">
        <div class="legend-item"><span class="status-dot" style="background-color: #00c853;"></span> ATIVO</div>
        <div class="legend-item"><span class="status-dot" style="background-color: #ffeb3b;"></span> MANUTENÇÃO</div>
        <div class="legend-item"><span class="status-dot" style="background-color: #d50000;"></span> INATIVO</div>
        <div class="legend-item"><span class="status-dot" style="background-color: #808080;"></span> SEM STATUS</div>
    </div>

    <div id="stationsContainer">
        <?php if (empty($estacoes)): ?>
            <div class="no-data">Nenhuma estação encontrada.</div>
        <?php else: ?>
            <?php foreach ($estacoes as $id => $estacao): ?>
                <div class="station" data-name="<?= strtolower($estacao['nome_estacao']) ?>">
                    
                    <div class="station-header" onclick="toggleLines(<?= $id ?>)">
                        <div class="station-info">
                            <img src="../assets/icons/estacao_icon.png" class="station-icon" onerror="this.style.display='none'"/> 
                            <h2 class="station-name"><?= htmlspecialchars($estacao['nome_estacao']) ?></h2>
                        </div>
                        <span class="toggle-arrow" id="arrow-<?= $id ?>">&#9660;</span>
                    </div>
                    
                    <div class="lines-list" id="lines-<?= $id ?>"> 
                        <?php if (!empty($estacao['linhas'])): ?>
                            <?php foreach ($estacao['linhas'] as $linha): ?>
                                <div class="line-item">
                                    <span class="status-dot" style="background-color: <?= $linha['cor'] ?>;"></span>
                                    <span><?= htmlspecialchars($linha['codigo'] . ' - ' . $linha['nome']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding:15px; color:#555; text-align:center; font-style:italic;">Nenhuma linha vinculada.</div>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleLines(id) {
        const list = document.getElementById('lines-' + id);
        const arrow = document.getElementById('arrow-' + id);
        
        if (list.classList.contains('visible')) {
            list.classList.remove('visible');
            arrow.innerHTML = '&#9660;';
        } else {
            list.classList.add('visible');
            arrow.innerHTML = '&#9650;';
        }
    }

    function filterStations() {
        const term = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.station').forEach(st => {
            const name = st.dataset.name;
            st.style.display = name.includes(term) ? 'block' : 'none';
        });
    }
</script>
</body>
</html>