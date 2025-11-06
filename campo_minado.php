<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$usuarios = json_decode(file_get_contents('usuarios.json'), true);
$usuario = null;
foreach ($usuarios as $u) {
    if ($u['id'] == $_SESSION['usuario_id']) {
        $usuario = $u;
        break;
    }
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
        <div class="parent">

            <div class="side-bar">
                <div class="lance">
                    <p>Aposta:</p>
                    <input type="number" id="valorAposta" name="valorAposta" placeholder="Digite um valor" required>
                </div>

                <div class="bomb-slider">
                    <p>Quantidade de Bombas: <span id="valor-bombas">3</span></p>
                    <input type="range" min="3" max="8" value="3" id="rangeBombas" name="bombas">
                    <p>Multiplicador: <span id="multiplicador">x1.00</span></p>
                </div>

                <div class="acoes">
                    <button id="btn-apostar" class="btn-action">Apostar</button>
                </div>
            </div>

            <div class="campo-minado">
                <div class="grid campo">
                    <?php for ($i = 0; $i < 9; $i++): ?>
                        <div class="cell" data-index="<?= $i ?>"></div>
                    <?php endfor; ?>
                </div>
                <div id="overlayResultado" class="overlay-resultado hidden">
                    <div class="mensagem"></div>
                </div>
            </div>

            <div class="saldo">
                Saldo atual: R$ <span id="saldo"><?php echo number_format($usuario['saldo'], 2, ',', '.'); ?></span>
            </div>
        </div>
    </main>

    <script src="campo_minado.js"></script>
</body>

</html>