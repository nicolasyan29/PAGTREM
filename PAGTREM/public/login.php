<?php
session_start();


$host = "localhost";
$db   = "pagtrem";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $senha   = trim($_POST["senha"]);

    if ($usuario === "" || $senha === "") {
        $erro = "Preencha todos os campos.";
    } else {
       
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1");
        $stmt->bindValue(":usuario", $usuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user["senha"])) {

            
            if (!empty($_POST["lembrar"])) {
                setcookie("usuario", $usuario, time() + 604800, "/");
            }

           
            $_SESSION["user"] = $usuario;
            header("Location: dashboard.php");
            exit;
        } else {
            $erro = "Usuário ou senha inválidos.";
        }
  
    }
}
?>
