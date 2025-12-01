<?php
session_start();

$user = [
    'id' => 329,
    'nome' => 'Nome',
    'cargo' => 'Administrador',
    'permissoes' => 'Geral',
    'foto' => 'default-profile.png'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmar_exclusao'])) {
        header('Location: login.php');
        exit();
    } elseif (isset($_POST['cancelar_exclusao'])) {
        header('Location: perfil.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirmar Exclusão</title>
    <link rel="stylesheet" href="../style/style2.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #000;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .wrapper {
            width: 100%;
            max-width: 400px;
            background: #111;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
            padding: 20px;
            text-align: center;
        }

        .wrapper:hover {
            transform: scale(1.02);
        }

        .confirmacao-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .confirmacao-container p {
            margin-bottom: 30px;
            font-size: 18px;
        }

        .botoes-confirmacao {
            display: flex;
            justify-content: space-around;
        }

        .btn-sim, .btn-nao {
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-sim {
            background: #e63946;
        }

        .btn-sim:hover {
            background: #b2222e;
        }

        .btn-nao {
            background: #0057b7;
        }

        .btn-nao:hover {
            background: #003d82;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="confirmacao-container">
            <h2>Excluir Perfil</h2>
            <p>Tem certeza que deseja excluir seu perfil? Esta ação não pode ser desfeita.</p>
            <form method="POST" action="">
                <div class="botoes-confirmacao">
                    <button type="submit" name="confirmar_exclusao" class="btn-sim">Sim, Excluir</button>
                    <button type="submit" name="cancelar_exclusao" class="btn-nao">Não, Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
