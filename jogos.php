<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/jogos.css" rel="stylesheet">
    <link href="./assets/reset.css" rel="stylesheet">
    <title>Jogos</title>
</head>

<body>

    <header class="header-container">
        <div class="logo">
            <a href="index.php"><img src="./assets/imagens/logo_minecraft.png" alt="Logo Mine"></a>
        </div>
        <div class="header-buttons">
            <a href="perfil.php" class="btn-style" id="btn-perfil">Meu Perfil</a>
        </div>
    </header>

    <div class="jogos-container">
        <a href="jackpot.php" class="jogo-link">Jackpot</a>
        <a href="campo_minado.php" class="jogo-link">Campo Minado</a>
    </div>

</body>

</html>