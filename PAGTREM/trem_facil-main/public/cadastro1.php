<?php
session_start();

$nome_completo = $cpf = $cep = $email = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome_completo = trim($_POST['nome_completo']);
    $cpf = trim($_POST['cpf']);
    $cep = trim($_POST['cep']);
    $email = trim($_POST['email']);

 
    if (empty($nome_completo)) {
        $errors[] = "Nome completo é obrigatório.";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome_completo)) {
        $errors[] = "Nome deve conter apenas letras e espaços.";
    } elseif (strlen($nome_completo) < 3) {
        $errors[] = "Nome deve ter pelo menos 3 caracteres.";
    }

    $cpf_clean = preg_replace('/\D/', '', $cpf);
    if (empty($cpf)) {
        $errors[] = "CPF é obrigatório.";
    } elseif (strlen($cpf_clean) != 11) {
        $errors[] = "CPF deve ter 11 dígitos.";
    }

  
    $cep_clean = preg_replace('/\D/', '', $cep);
    if (empty($cep)) {
        $errors[] = "CEP é obrigatório.";
    } elseif (strlen($cep_clean) != 8) {
        $errors[] = "CEP deve ter 8 dígitos.";
    }

  
    if (empty($email)) {
        $errors[] = "Email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    if (empty($errors)) {
        $_SESSION['cadastro1'] = [
            'nome_completo' => $nome_completo,
            'cpf' => $cpf_clean,
            'cep' => $cep_clean,
            'email' => $email
        ];

        header("Location: cadastro2.php");
        exit();
    }
}

function validateCPF($cpf)
{
    
    $cpf = preg_replace('/\D/', '', $cpf);

  
    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += $cpf[$i] * (10 - $i);
    }
    $first_digit = ($sum * 10) % 11;
    if ($first_digit == 10) $first_digit = 0;

    $sum = 0;
    for ($i = 0; $i < 10; $i++) {
        $sum += $cpf[$i] * (11 - $i);
    }
    $second_digit = ($sum * 10) % 11;
    if ($second_digit == 10) $second_digit = 0;

    return $cpf[9] == $first_digit && $cpf[10] == $second_digit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Parte 1</title>
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>
<a href="pagina_inicial.php"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>
    <div class="i">
        <img src="../assets/icons/trem_bala_icon.png" alt="Ícone Trem" width="260" height="210" class="">
    </div>
    <br>

    <?php if (!empty($errors)): ?>
        <div style="color: #ff5757; text-align: center; margin: 10px 0;">
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div>
        <form class="margin_cadastro1" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <strong>
                <p class="margin_cadastro1">Nome completo:</p>
            </strong>
            <input type="text"
                class="caixa_cadastro1"
                name="nome_completo"
                value="<?php echo htmlspecialchars($nome_completo); ?>"
                required>

            <strong>
                <p class="margin_cadastro1">CPF:</p>
            </strong>
            <input type="text"
                class="caixa_cadastro1"
                name="cpf"
                value="<?php echo htmlspecialchars($cpf); ?>"
                required
                maxlength="14">

            <strong>
                <p class="margin_cadastro1">CEP:</p>
            </strong>
            <input type="text"
                class="caixa_cadastro1"
                name="cep"
                value="<?php echo htmlspecialchars($cep); ?>"
                required
                maxlength="9">

            <strong>
                <p class="margin_cadastro1">Email:</p>
            </strong>
            <input type="email"
                class="caixa_cadastro1"
                name="email"
                value="<?php echo htmlspecialchars($email); ?>"
                required>

            <br><br>
            <div class="final_cadastro2">
                <a href="cadastro2.php"><button type="submit" class="caixa_verde_cadastro2">
                        <p class="centralizar_cadastro2">PRÓXIMO</p>
                    </button></a>
            </div>
        </form>
    </div>


    <div class="flex_circulo">
        <div class="circulo_esquerda_cadastro2"></div>
        <div class="circulo_direita_cadastro2"></div>
    </div>

    <script>
       
        document.addEventListener('DOMContentLoaded', function() {
            const nomeInput = document.getElementById('nome_completo');
            const cpfInput = document.getElementById('cpf');
            const cepInput = document.getElementById('cep');
            const emailInput = document.getElementById('email');

            nomeInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
                this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
            });

            
            cpfInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length <= 11) {
                    this.value = this.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                }
            });

          
            cepInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length <= 8) {
                    this.value = this.value.replace(/(\d{5})(\d{3})/, '$1-$2');
                }
            });

            
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    alert('Por favor, insira um email válido.');
                    this.focus();
                }
            });
        });
    </script>
</body>

</html>