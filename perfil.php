<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'] ?? "User";
$arquivo = 'usuarios.json';
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];
$usuarioAtual = null;

foreach ($usuarios as $usuario) {
    if ($usuario['id'] === $usuario_id) {
        $usuario_atual = $usuario;
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/perfil.css" rel="stylesheet">
    <title>Perfil</title>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="index.php"><img src="./assets/imagens/logo_minecraft.png" alt="Logo Mine"></a>
            </div>
            <nav>
                <a href="mines.php" class="btn-style">Jogar</a>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <aside class="side-bar">
            <div class="perfil-info">
                <img src="./assets/imagens/perfil-placeholder.png" alt="Foto de Perfil" class="perfil-img">
                <h3 id="usuario-nome">ID: <?= ($usuario_id) ?></h3>
            </div>

            <div class="saldo">
                <span>Saldo: <a id="saldo"><?= number_format($usuario_atual['saldo'], 2, ',', '.') ?> </a></span>
            </div>

            <form class="acoes" method="post" action='saldo.php'>
                <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
                    <p style="color:#c90000; margin-left:20%">Saldo insuficiente</p>
                <?php endif; ?>
                <input type="number" placeholder="Insira o valor" id="valor-transacao" name="valor" required>
                <div class="botoes">
                    <button type="submit" class="btn-style" name="action" value="depositar">Depositar</button>
                    <button type="submit" class="btn-alt" name="action" value="sacar">Sacar</button>
                </div>
            </form>
            <div class="logout-btn">
                <form method="post" action="usuario_logout.php" onsubmit="return confirm('Está certo disso?');">
                    <button type="submit" class="btn-style" name="action" value="logout">Log-out</button>
                    <button type="submit" class="btn-style" name="action" value="excluir">Excluir conta</button>
                </form>
            </div>
        </aside>

        <section class="main-content">

            <div class="historico">
                <div id="historico">
                    <label>Historico de Transacoes:</label>
                </div>
                <?php
                if (!empty($usuario_atual['historico'])) {
                    foreach ($usuario_atual['historico'] as $item) {
                        if (stripos($item, 'deposito') !== false) $cor = 'green';
                        if (stripos($item, 'sacou') !== false) $cor = 'red';
                        echo '<li style="color:' . $cor . ';">' . ($item) . '</li>';
                    }
                } else {
                    echo '<li>Nenhuma transação ainda</li>';
                }
                ?>
            </div>
        </section>
    </div>
</body>

</html>