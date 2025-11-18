<?php
$titulo = "Relatórios e análises";
$icone = "🚆";
$cards = [
    "A linha 4 está sendo feita pelos novos trens em menos de 1 hora da primeira a última parada",
    "Cada viagem do começo ao fim está gastando 200 R$ em combustível",
    "Trens estão economizando 50 R$ a mais comparado ao ano passado"
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/combined.css">
</head>
<body>
    <div class="app">
        <header class="topbar">
            <span class="icon"><?php echo $icone; ?></span>
            <h1><?php echo $titulo; ?></h1>
        </header>

        <main class="content">
            <?php foreach ($cards as $texto): ?>
                <section class="card">
                    <p><?php echo $texto; ?></p>
                </section>
            <?php endforeach; ?>
        </main>

        <nav class="bottom-nav">
            <button class="nav-btn" aria-label="Início">
                <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                    <path fill="currentColor" d="M12 3l9 8h-3v9h-5v-6H11v6H6v-9H3z"/>
                </svg>
            </button>
            <button class="nav-btn active" aria-label="Status">
                <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/>
                    <circle cx="12" cy="12" r="3" fill="currentColor"/>
                </svg>
            </button>
            <button class="nav-btn" aria-label="Início 2">
                <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true">
                    <path fill="currentColor" d="M4 10l8-6 8 6v10a2 2 0 0 1-2 2h-4v-6H10v6H6a2 2 0 0 1-2-2V10z"/>
                </svg>
            </button>
        </nav>
    </div>
</body>
</html>
