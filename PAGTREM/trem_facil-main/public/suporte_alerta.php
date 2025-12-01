<?php
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['redirect_page'])) {
    $onde = $_POST['onde'] ?? '';
    $linha = $_POST['linha'] ?? '';
    $problema = $_POST['problema'] ?? '';
    $emergencia = $_POST['emergencia'] ?? '';
    $mensagem = 'Alerta enviado com sucesso no email!';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect_page'])) {
    $page = $_POST['redirect_page'];
    if ($page === 'sensores') {
        header('Location: ../private/sensor.php'); exit();
    } elseif ($page === 'trens') {
        header('Location: trens.php'); exit();
    } elseif ($page === 'estacoes') {
        header('Location: estacoes.php'); exit();
    } elseif ($page === 'perfil') {
        header('Location: perfil.php'); exit();
    } elseif ($page === 'inicio') {
        header('Location: pagina_inicial.php'); exit();
    } else {
        header('Location: index.php'); exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte e Alertas</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        body {
            background: #000 !important;
            min-height: 100vh;
            color: #fff;
        }
        .suporte-container {
            max-width: 400px;
            margin: 60px auto 0 auto;
            background: #000;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            padding: 32px 28px 24px 28px;
            text-align: center;
        }
        .suporte-container h2 {
            color: #0549b1;
            margin-bottom: 18px;
        }
        .suporte-container label, .suporte-container select, .suporte-container option, .suporte-container form, .suporte-container input, .suporte-container {
            color: #fff;
        }
        .suporte-container label {
            display: block;
            margin: 18px 0 6px 0;
            font-weight: 600;
            text-align: left;
        }
        .suporte-container select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #0549b1;
            margin-bottom: 10px;
            background: #0549b1;
            color: #fff;
        }
        .suporte-container option {
            background: #0549b1;
            color: #fff;
        }
        .caixa_verde_login {
            width: 100%;
            background: #0bbd4c;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 14px 0;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 18px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .caixa_verde_login:hover {
            background: #099c3d;
        }
        .alert-sucesso {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 18px;
        }
        .suporte-icone {
            margin-bottom: 10px;
        }
        @media (max-width: 500px) {
            .suporte-container { padding: 18px 4vw; }
        }
        footer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #000 !important;
            padding: 10px 0 4px 0;
            position: fixed;
            left: 0; right: 0; bottom: 0;
            z-index: 10;
        }
        footer form {
            display: inline;
        }
        footer button {
            background: none;
            border: none;
            padding: 0;
        }
        footer img {
            width: 48px;
            height: 48px;
        }
    </style>
</head>
<body>
    <a href="pagina_inicial.php"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>
    <div class="suporte-container">
        <div class="suporte-icone">
            <img src="../assets/icons/suporte_icone.png" alt="Suporte" width="80" height="80">
        </div>
        <h2>Suporte e Alertas</h2>
        <?php if ($mensagem): ?>
            <div class="alert-sucesso"> <?= $mensagem ?> </div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <label for="onde">Onde</label>
            <select name="onde" id="onde" required>
                <option value="Garuva">Garuva</option>
                <option value="Joinville" selected>Joinville</option>
                <option value="São Paulo">São Paulo</option>
            </select>
            <label for="linha">Linha</label>
            <select name="linha" id="linha" required>
                <option value="Linha 1-Azul">Linha 1 - Azul</option>
                <option value="Linha 8-Diamante" selected>Linha 8 - Diamante</option>
                <option value="Ferrovia Norte-Sul">Ferrovia Norte-Sul</option>
            </select>
            <label for="problema">Problema</label>
            <select name="problema" id="problema" required>
                <option value="Descarrilamento">Descarrilamento</option>
                <option value="Esbarro de trens">Esbarro de trens</option>
                <option value="Falhas no sistema de sinalização">Falhas no sistema de sinalização</option>
                <option value="Tombamento">Tombamento</option>
                <option value="Choque de trens">Choque de trens</option>
            </select>
            <label for="emergencia">Emergência</label>
            <select name="emergencia" id="emergencia" required>
                <option value="Incêndio">Incêndio</option>
                <option value="Problemas elétricos">Problemas elétricos</option>
                <option value="Abalroamento">Abalroamento</option>
                <option value="SOS">SOS</option>
                <option value="Centro de Controle Operacional (CCO)">Centro de Controle Operacional (CCO)</option>
                <option value="Serviços de Emergência">Serviços de Emergência</option>
            </select>
            <input class="caixa_verde_login" type="submit" value="ENVIAR">
        </form>
    </div>
</body>
</html>
