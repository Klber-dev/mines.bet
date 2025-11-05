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
    <link href="./assets/reset.css" rel="stylesheet">
    <link href="./assets/campo_minado.css" rel="stylesheet">
    <title>Campo Minado</title>
</head>

<body>
    <header class="header-container">
        <div class="logo">
            <a href="index.php">
                <img src="./assets/imagens/logo_minecraft.png" alt="Logo Mine">
            </a>
        </div>
        <div class="header-buttons">
            <a href="perfil.php" class="btn-style" id="btn-perfil">Meu Perfil</a>
        </div>
    </header>

    <main>
        <section class="aposta">
            <form class="aposta-form" id="form-jogo">
                <label for="aposta">Valor da aposta:</label>
                <input class="input-style" type="number" id="aposta" placeholder="Insira um valor" name="aposta" required>

                <label for="bombas">Quantia de bombas (3 a 8):</label>
                <input class="input-style" type="number" id="bombas" placeholder="Ex: 3" name="bombas" min="3" max="8" required>

                <button class="btn-button" type="submit">Jogar</button>
            </form>
        </section>

        <section class="campo"></section>
    </main>

    <script src="campo_minado.js"></script>
</body>

</html>