<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'] ?? "User";
$arquivo = 'usuarios.json';
$usuarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];
$usuario_atual = null;

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
    <title>Perfil - Mines.bet</title>
    <link href="./assets/perfil.css" rel="stylesheet">
    <link href="./assets/reset.css" rel="stylesheet">
</head>

<body>

    <header class="header-container">
        <div class="logo">
            <a href="index.php"><img src="./assets/imagens/logo_minecraft.png" alt="Logo Mine"></a>
        </div>
        <div class="header-buttons">
            <a href="jogos.php" class="btn-style">Jogar</a>
        </div>
    </header>

    <div class="main-container">

        <aside class="side-bar">
            <div class="perfil-info">
                <img src="./assets/imagens/perfil-placeholder.png" alt="Foto de Perfil" class="perfil-img">
                <p>ID: <?= htmlspecialchars($usuario_id) ?></p>
            </div>

            <div class="saldo">
                <span>Saldo:</span>
                <label id="saldo">
                    <?= isset($usuario_atual['saldo']) ? number_format($usuario_atual['saldo'], 2, ',', '.') : '0,00' ?>
                </label>
            </div>

            <form class="acoes" method="post" action="saldo.php">
                <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
                    <p class="erro-msg">Saldo insuficiente</p>
                <?php endif; ?>
                <?php if (isset($_GET['erro']) && $_GET['erro'] == 2): ?>
                    <p class="erro-msg">Saque nao permitido</p>
                <?php endif; ?>
                <?php if (isset($_GET['erro']) && $_GET['erro'] == 3): ?>
                    <p class="erro-msg">Falha ao processar deposito</p>
                <?php endif; ?>
                <input type="number" placeholder="Insira o valor" id="valor-transacao" name="valor" min="0" step="0.01" required>
                <div class="botoes">
                    <button type="submit" class="btn-style" name="action" value="depositar">Depositar</button>
                    <button type="submit" class="btn-alt" name="action" value="sacar">Sacar</button>
                </div>
            </form>

            <div class="logout-btn">
                <form method="post" action="usuario_logout.php" onsubmit="return confirm('Tem certeza que deseja continuar?');">
                    <button type="submit" name="action" value="logout">Log-out</button>
                    <button type="submit" name="action" value="excluir">Excluir conta</button>
                </form>
            </div>
        </aside>
        <main class="main-content">
            <section class="historico">
                <p id="historico">Historico de Transacoes</p>
                <ul id="lista-historico">
                    <?php
                    if (!empty($usuario_atual['historico'])) {
                        foreach ($usuario_atual['historico'] as $item) {
                            $cor = '';
                            if (stripos($item, 'deposito') !== false) $cor = 'green';
                            elseif (stripos($item, 'sacou') !== false) $cor = 'red';
                            echo '<li style="color:' . $cor . ';">' . htmlspecialchars($item) . '</li>';
                        }
                    } else {
                        echo '<li>Nenhuma transação ainda</li>';
                    }
                    ?>
                </ul>
            </section>
        </main>
    </div>
</body>

</html>