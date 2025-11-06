<?php
session_start();

// simulação de usuário logado (remova e use seu sistema real)
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario_id'] = 323601;
}

// lê saldo atual do JSON
$usuarios = json_decode(file_get_contents('usuarios.json'), true);
$usuario = null;
foreach ($usuarios as $u) {
    if ($u['id'] == $_SESSION['usuario_id']) {
        $usuario = $u;
        break;
    }
}
if (!$usuario) {
    die("Usuário não encontrado.");
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
        <div class="header-info">
            <p id="saldo">Saldo: R$</p>
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

            <p id="multiplicador">Multiplicador: x1.00</p>
            <button id="btn-sacar" class="btn-button" disabled>Sacar</button>
        </section>

        <section class="campo"></section>
    </main>

    <script src="campo_minado.js"></script>
</body>

</html>