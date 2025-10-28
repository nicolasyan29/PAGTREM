<?php

$title = "Email Não Encontrado";
$message = "E-mail não encontrada, verifique se preencheu os dados corretamente.";
$logoPath = "../img/icone pagtrem-Photoroom.png";
$cssPath = "../style/emailnaoencontrado.css";


session_start();
if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
}


echo '<!DOCTYPE html>';
echo '<html lang="pt-BR">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '    <title>' . htmlspecialchars($title) . '</title>';
echo '    <link rel="stylesheet" href="' . htmlspecialchars($cssPath) . '">';
echo '    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';
echo '</head>';
echo '<body>';
echo '    <div class="container">';
echo '        <div class="logo">';
echo '            <img src="' . htmlspecialchars($logoPath) . '" alt="Logo">';
echo '        </div>';
echo '        <div class="content">';
echo '            <div class="message-icons">';
echo '                <i class="far fa-envelope"></i>';
echo '                <i class="fas fa-times-circle error-icon"></i>';
echo '            </div>';
echo '            <p>' . htmlspecialchars($message) . '</p>';
echo '        </div>';
echo '        <div class="footer-navigation">';
echo '            <i class="fas fa-arrow-left"></i>';
echo '            <i class="fas fa-home"></i>';
echo '            <i class="fas fa-arrow-right"></i>';
echo '        </div>';
echo '    </div>';
echo '</body>';
echo '</html>';
?>
