<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contatos</title>
  <link rel="stylesheet" href="../style/contatos.css">
  <script>
    function logClick() {
      <?php
      $click_log = "Link clicked: " . date('Y-m-d H:i:s') . " - IP: $ip";
      error_log($click_log);
      ?>
    }
  </script>
</head>

<body>
  <a href="../public/chat.html">
    <div class="logo">
      <img src="../img/unnamed.png" alt="Logo" width="420" height="250">
    </div>
    <div class="info">
      <h1>Contatos</h1>
      <p>Clique para conversar com o suporte</p>
    </div>
  </a>
</body>

</html>
