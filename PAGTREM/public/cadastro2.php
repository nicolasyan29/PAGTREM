<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $local = trim($_POST["local"]);
    $foto = $_FILES["foto"];

    if (strlen($local) < 2) {
        $erro = "Localização inválida!";
    }
    elseif ($foto["error"] !== 0) {
        $erro = "Envie uma foto válida!";
    }
    else {
        
        $_SESSION["local"] = $local;

        
        $nomeFoto = "foto_" . time() . ".jpg";
        move_uploaded_file($foto["tmp_name"], "uploads/" . $nomeFoto);

        $_SESSION["foto"] = $nomeFoto;

        header("Location: menu.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Cadastro - Parte 2</title></head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="local" placeholder="Localização" required><br>
        <input type="file" name="foto" accept="image/*" required><br>
        <button type="submit">Finalizar Cadastro</button>
    </form>

    <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
</body>
</html>
