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
        <div class="jogos-container">
            <a href="campo_minado.php" class="jogo-card">
                <div class="jogo-imagem" style="background-image: url('./assets/imagens/campo-banner.png');"></div>
                <div class="jogo-info">
                    <h3>Campo Minado</h3>
                    <p>Evite as minas, ajuste a dificuldade e vença</p>
                </div>
                
                <a href="jackpot.php" class="jogo-card">
                    <div class="jogo-imagem" style="background-image: url('./assets/imagens/jackpot_banner.png');"></div>
                    <div class="jogo-info">
                        <h3>Jackpot</h3>
                        <p>Tente a sorte e dobre seu saldo no modo roleta</p>
                    </div>
                </a>


            </a>
        </div>

    </div>

</body>

</html>