<?php
header('Content-Type: text/html; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cep'])) {
    $cep = preg_replace('/\D/', '', $_POST['cep']);
    $api_url = "https://viacep.com.br/ws/{$cep}/json/";
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Accept: application/json\r\nUser-Agent: PHP\r\n',
            'timeout' => 10
        ]
    ]);
    $response = file_get_contents($api_url, false, $context);
    if ($response === false) {
        $data = ['error' => 'Erro na requisição HTTP'];
    } else {
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = ['error' => 'Erro ao decodificar JSON: ' . json_last_error_msg()];
        }
    }
} else {
    $data = null;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta CEP - Trem Fácil</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: #000;
            font-family: Arial, sans-serif;
            color: white;
            padding: 15px;
            padding-bottom: 110px;
        }
        .header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .btn-voltar {
            background-color: transparent;
            border: none;
            cursor: pointer;
            display: flex; 
            align-items: center;
            background-image: url('../../assets/icons/seta_esquerda.png');
            background-size: contain;
            background-repeat: no-repeat;
            width: 30px; height: 30px;
        }
        .titulo-principal { background-color: #0B57DA; padding: 8px 18px; border-radius: 25px; font-weight: bold; font-size: 19px; color: white; }
        .linha-azul { height: 2px; background-color: #0B57DA; margin-bottom: 15px; border-radius: 2px; }
        .form-cep { background: #111; border-radius: 12px; padding: 18px; max-width: 400px; margin: 0 auto 18px; box-shadow: 0 2px 9px rgba(11,87,218,0.2); }
        .form-cep label { display: block; margin-bottom: 8px; font-weight: 600; color: #0B57DA; }
        .form-cep input[type="text"] {
            width: 100%; background: #222; color: #fff; border: 2px solid #0B57DA; border-radius: 8px; padding: 10px; font-size: 16px; margin-bottom: 12px; outline: none;
        }
        .form-cep button {
            background: #0B57DA; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; width: 100%; cursor: pointer; font-size: 16px;
        }
        .cep-result { background: #111; border-radius: 12px; padding: 18px; max-width: 400px; margin: 0 auto 18px; box-shadow: 0 2px 9px rgba(11,87,218,0.2); }
        .cep-result h3 { color: #0B57DA; margin-bottom: 10px; }
        .cep-result p { margin-bottom: 6px; }
        .cep-error { color: #e74c3c; text-align: center; margin-bottom: 12px; }
        footer {
            position: fixed; bottom: 0; left: 0; width: 100%; height: 80px; background-color: black; border-top: 1px solid #0B57DA; display: flex; justify-content: space-evenly; align-items: center; user-select: none;
        }
        footer button { border: none; background: none; cursor: pointer; }
        footer img { width: 60px; height: 60px; }
        @media(min-width:600px){ .titulo-principal{ font-size:20px } }
    </style>
</head>
<body>
    <header class="header">
        <button class="btn-voltar" title="Voltar" onclick="window.location.href='../pagina_inicial.php';"></button>
        <div class="titulo-principal">CONSULTA CEP</div>
    </header>
    <div class="linha-azul"></div>
    <main>
        <form class="form-cep" method="post" autocomplete="off">
            <label for="cep">Digite o CEP:</label>
            <input type="text" name="cep" id="cep" maxlength="9" pattern="\d{5}-?\d{3}" placeholder="Ex: 01001-000" required value="<?= htmlspecialchars($_POST['cep'] ?? '') ?>">
            <button type="submit">Buscar</button>
        </form>
        <?php if ($data): ?>
            <?php if (isset($data['error']) || isset($data['erro'])): ?>
                <div class="cep-error">
                    <?= isset($data['error']) ? htmlspecialchars($data['error']) : 'CEP não encontrado.' ?>
                </div>
            <?php else: ?>
                <div class="cep-result">
                    <h3>Resultado:</h3>
                    <p><strong>CEP:</strong> <?= htmlspecialchars($data['cep']) ?></p>
                    <p><strong>Logradouro:</strong> <?= htmlspecialchars($data['logradouro']) ?></p>
                    <p><strong>Bairro:</strong> <?= htmlspecialchars($data['bairro']) ?></p>
                    <p><strong>Cidade:</strong> <?= htmlspecialchars($data['localidade']) ?></p>
                    <p><strong>UF:</strong> <?= htmlspecialchars($data['uf']) ?></p>
                    <p><strong>DDD:</strong> <?= htmlspecialchars($data['ddd']) ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
    <footer>
        <form action="../private/sensor.php" method="get">
            <button type="submit" title="Sensores">
                <img src="../../assets/icons/tela_sensor_icon.png" alt="botão para tela sensores">
            </button>
        </form>
        <form action="../trens.php" method="get">
            <button type="submit" title="Trens">
                <img src="../../assets/icons/tela_tren_icon.png" alt="botão para tela trens">
            </button>
        </form>
        <form action="../estacoes.php" method="get">
            <button type="submit" title="Estações">
                <img src="../../assets/icons/tela_estacao_icon.png" alt="botão para tela estações">
            </button>
        </form>
        <form action="../perfil.php" method="get">
            <button type="submit" title="Perfil">
                <img src="../../assets/icons/tela_perfil_icon.png" alt="botão para tela perfil">
            </button>
        </form>
    </footer>
</body>
</html>
