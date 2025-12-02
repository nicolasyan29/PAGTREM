<?php
include 'public/db.php'; 

session_start();

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;

if ($tipo) {
    $_SESSION['tipo_usuario'] = $tipo;
    
    if ($tipo == "1") {
        
        header('Location: cliente_dashboard.php'); 
        exit();
    } elseif ($tipo == "2") {

        header('Location: admin_dashboard.php'); 
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    
    <style>
   
        body {
            background-color: #000000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            color: #ffffff; 
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px; 
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .img_entrada img {
            max-width: 100%;
            height: auto;
            width: auto; 
        }

        .text_entrada h1 {
            font-size: 2.5em;
            margin: 0;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
        }

        .alinhar_entrada {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
        }

        .caixa_azul_entrada {
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            padding: 12px 25px;
            font-size: 1.1em;
            font-family: 'Segoe UI', sans-serif;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease; 
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .caixa_azul_entrada:hover {
            background-color: #0056b3;
            transform: translateY(-2px); 
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.4);
        }

        .caixa_azul_entrada:active {
            transform: translateY(0);
        }

        .caixa_azul_entrada h2 {
            margin: 0;
            font-size: 1em;
        }


        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .text_entrada h1 {
                font-size: 2em;
            }

            .alinhar_entrada {
                gap: 15px;
            }

            .caixa_azul_entrada {
                padding: 10px 18px;
                font-size: 0.9em;
            }

            .img_entrada img {
                max-width: 70%; 
            }
        }

        @media (max-width: 480px) {
            .text_entrada h1 {
                font-size: 1.5em;
            }

            .caixa_azul_entrada {
                padding: 8px 12px;
                font-size: 0.8em;
            }

            .container {
                padding: 10px;
                gap: 20px;
            }
        }

        @media (min-width: 1024px) {
            .alinhar_entrada {
                flex-direction: row;
                justify-content: center;
                gap: 20px;
            }

            .caixa_azul_entrada {
                width: auto;
                min-width: 180px; 
            }

            .container {
                max-width: 600px;
            }
        }
    </style>
</head>
<body>
    <div class="container"> 
        <div class="img_entrada">
            <img src="assets/icons/trem_bala_icon.png" alt="Ícone de Trem Bala"> 
        </div>

        

        <div class="alinhar_entrada">
            <a href="public/login.php" class="caixa_azul_entrada">
                <h2>entrar</h2>
            </a>
        </div>
    </div>
</body>
</html>
