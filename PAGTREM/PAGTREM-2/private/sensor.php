<?php
session_start();

// Conexão com o banco (ajuste credenciais se necessário)
$servername = "localhost";
$username = "root";  
$password = "root";  // Ajuste se sua senha for diferente
$dbname = "trem_facil";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Redirecionamentos (mantido do original)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect_page'])) {
    $page = $_POST['redirect_page'];
    switch ($page) {
        case 'sensores':
            header('Location: sensor.php');
            exit();
        case 'trens':
            header('Location: ../public/trens.php');
            exit();
        case 'estacoes':
            header('Location: ../public/estacoes.php');
            exit();
        case 'perfil':
            header('Location: pefil_adm.php');
            exit();
        default:
            header('Location: index.php');
            exit();
    }
}

// Adicionar sensor (inserir no banco) - Melhorado com validação e tratamento de duplicatas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sensor'])) {
    $nome = trim($_POST['nome'] ?? '');
    $localizacao = trim($_POST['localizacao'] ?? '');
    
    if (empty($nome) || empty($localizacao)) {
        echo "<script>alert('Nome e localização são obrigatórios!');</script>";
    } else {
        // Verificar se o nome já existe (para evitar duplicatas, já que é UNIQUE)
        $stmt_check = $conn->prepare("SELECT id_sensor FROM sensor WHERE nome = ?");
        $stmt_check->bind_param("s", $nome);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            echo "<script>alert('Sensor com este nome já existe!');</script>";
        } else {
            // Inserir
            $stmt = $conn->prepare("INSERT INTO sensor (nome, status, localizacao, ultima_atualizacao_texto, ultima_atualizacao_valor, ultima_atualizacao_unidade) VALUES (?, 'ATIVO', ?, 'AGORA', '0', 'KM/H')");
            $stmt->bind_param("ss", $nome, $localizacao);
            if ($stmt->execute()) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Erro ao adicionar sensor: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
}

// Remover sensor (deletar do banco) - Melhorado com confirmação e tratamento de erro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_sensor'])) {
    $id = (int)$_POST['sensor_id'];
    
    $stmt = $conn->prepare("DELETE FROM sensor WHERE id_sensor = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Sensor não encontrado ou já removido!');</script>";
        }
    } else {
        echo "<script>alert('Erro ao remover sensor: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Buscar sensores do banco - Mantido, mas com verificação de erro
$sensores = [];
$result = $conn->query("SELECT * FROM sensor ORDER BY id_sensor ASC");
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sensores[] = [
                'id' => $row['id_sensor'],
                'nome' => $row['nome'],
                'status' => $row['status'],
                'status_color' => ($row['status'] === 'ATIVO') ? 'green' : 'red',
                'localizacao' => $row['localizacao'],
                'ultima_atualizacao_texto' => $row['ultima_atualizacao_texto'],
                'ultima_atualizacao_valor' => $row['ultima_atualizacao_valor'],
                'ultima_atualizacao_unidade' => $row['ultima_atualizacao_unidade']
            ];
        }
    }
} else {
    echo "<script>alert('Erro ao buscar sensores: " . $conn->error . "');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sensores - Trem Fácil</title>
    <style>
        /* CSS mantido e otimizado para melhor responsividade */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #000;
            font-family: Arial, sans-serif;
            color: white;
            padding: 15px;
            padding-bottom: 80px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-voltar {
            background-color: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            background-image: url('../assets/icons/seta_esquerda.png');
            background-size: contain;
            background-repeat: no-repeat;
            width: 30px;
            height: 30px;
        }

        .titulo-principal {
            background-color: #0B57DA;
            padding: 8px 18px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 19px;
            color: white;
            user-select: none;
        }

        .linha-azul {
            height: 2px;
            background-color: #0B57DA;
            margin-bottom: 15px;
            border-radius: 2px;
        }

        .input-search {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 2px solid #0B57DA;
            color: #999;
            padding: 7px 5px;
            font-size: 15px;
            margin-bottom: 18px;
            outline: none;
        }

        ::placeholder {
            color: #777;
            font-style: italic;
        }

        .btn-primary {
            background-color: #0B57DA;
            color: white;
            padding: 10px 18px;
            border-radius: 25px;
            border: none;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            user-select: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.25s;
        }
        .btn-primary:hover {
            background-color: #0943b0;
        }

        .btn-filter, .btn-trash {
            background-color: transparent;
            border: 2.5px solid white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            color: white;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-filter:hover, .btn-trash:hover {
            background-color: #0B57DA;
            border-color: #0B57DA;
        }

        .btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .sensor-item {
            background-color: #111;
            margin-bottom: 18px;
            padding: 15px 15px 18px;
            border-radius: 12px;
            box-shadow: 0 2px 9px rgba(11, 87, 218, 0.3);
        }

        .sensor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .sensor-name {
            background-color: #0B57DA;
            padding: 8px 22px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 16px;
            color: white;
            user-select: none;
        }

        .sensor-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .status-label {
            user-select: none;
        }

        .status-ativo {
            color: #27ae60;
            font-weight: 700;
        }

        .status-inativo {
            color: #e74c3c;
            font-weight: 700;
        }

        .localizacao {
            color: white;
        }

        .ult-atualizacao {
            font-size: 13px;
        }

        .kmh {
            color: #0B57DA;
            font-weight: 700;
            user-select: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #111;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            color: white;
        }
        .modal-content input, .modal-content button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .modal-content input {
            background: #222;
            border: 1px solid #0B57DA;
            color: white;
        }
        .modal-content button {
            background: #0B57DA;
            border: none;
            cursor: pointer;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: white;
        }

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
<body>
    <header class="header">
        <button class="btn-voltar" title="Voltar" onclick="window.location.href='pagina_inicial_adm.php';"></button>
        <div class="titulo-principal">SENSORES</div>
    </header>

    <div class="linha-azul"></div>

    <input id="searchInput" type="text" class="input-search" placeholder="Pesquisar Sensor" aria-label="Pesquisar Sensor" autocomplete="off" />

    <div class="btn-group">
        <button class="btn-primary" type="button" onclick="openModal()">ADICIONAR SENSOR</button>
        
    </div>

    <div id="sensores-container">
    <?php if (empty($sensores)): ?>
        <p style="text-align: center; color: #777;">Nenhum sensor encontrado. Adicione um novo sensor!</p>
    <?php else: ?>
        <?php foreach($sensores as $sensor): ?>
            <div class="sensor-item">
                <div class="sensor-header">
                    <div class="sensor-name"><?= htmlspecialchars($sensor['nome']) ?></div>
                    <form action="" method="post" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover este sensor?');">
                        <input type="hidden" name="sensor_id" value="<?= $sensor['id'] ?>">
                        <button class="btn-trash" type="submit" name="remove_sensor" title="Excluir Sensor">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" fill="white" viewBox="0 0 24 24"><path d="M3 6h18v2H3V6zm3 14a2 2 0 1 1 4 0H6zm7 0a2 2 0 1 1 4 0h-4zm2-10v8H9v-8H5V8h14v2h-6z"/></svg>
                        </button>
                    </form>
                </div>

                <div class="sensor-details">
                    <div class="status-label">
                        STATUS: 
                        <?php if($sensor['status'] === 'ATIVO'): ?>
                            <span class="status-ativo"><?= htmlspecialchars($sensor['status']) ?></span>
                        <?php else: ?>
                            <span class="status-inativo"><?= htmlspecialchars($sensor['status']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="localizacao">
                        LOCALIZAÇÃO: <?= htmlspecialchars($sensor['localizacao']) ?>
                    </div>
                </div>

                <div class="ult-atualizacao">
                    ÚLTIMA ATUALIZAÇÃO(<?= htmlspecialchars($sensor['ultima_atualizacao_texto']) ?>): 
                    <span class="kmh"><?= htmlspecialchars($sensor['ultima_atualizacao_valor']) ?> <?= htmlspecialchars($sensor['ultima_atualizacao_unidade']) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>

    <div id="addSensorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Adicionar Sensor</h2>
            <form action="" method="post">
                <input type="text" name="nome" placeholder="Nome do Sensor" required>
                <input type="text" name="localizacao" placeholder="Localização" required>
                <button type="submit" name="add_sensor">Adicionar</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addSensorModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addSensorModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('addSensorModal')) {
                closeModal();
            }
        }
    </script>

    <script>
    // Correções: garantir que os elementos e filtros existam antes do uso
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        // Por enquanto consideramos todos os status válidos; se houver UI de filtro, atualize este Set
        const statusFilters = new Set(['ativo', 'inativo']);
        const container = document.getElementById('sensores-container');

        function filterSensores() {
            const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
            const sensores = container ? container.querySelectorAll('.sensor-item') : [];
            let totalVisiveis = 0;

            sensores.forEach(sensor => {
                const nome = (sensor.querySelector('.sensor-name')?.textContent || '').toLowerCase();
                const statusSpan = sensor.querySelector('.status-label span');
                const status = (statusSpan ? statusSpan.textContent : '').toLowerCase();

                const statusValido = status ? statusFilters.has(status) : true;
                const pesquisaValida = nome.includes(query);

                if (statusValido && pesquisaValida) {
                    sensor.style.display = '';
                    totalVisiveis++;
                } else {
                    sensor.style.display = 'none';
                }
            });

            let mensagemNenhum = document.getElementById('mensagem-nenhum');
            if (!mensagemNenhum) {
                mensagemNenhum = document.createElement('p');
                mensagemNenhum.id = 'mensagem-nenhum';
                mensagemNenhum.style.cssText = 'text-align:center; color:#777;';
                mensagemNenhum.textContent = 'Nenhum sensor encontrado.';
                // inserir logo após o container para manter a ordem visual
                if (container && container.parentNode) {
                    container.parentNode.insertBefore(mensagemNenhum, container.nextSibling);
                } else {
                    document.body.appendChild(mensagemNenhum);
                }
            }
            mensagemNenhum.style.display = (totalVisiveis === 0) ? 'block' : 'none';
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterSensores);
        }

        // rodar uma vez ao carregar para ajustar visibilidade inicial
        filterSensores();
    });
    </script>
</body>
</html>

