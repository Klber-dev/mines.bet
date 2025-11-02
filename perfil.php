<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'] ?? "User";
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
                <h3 id="usuario-nome">ID: <?= htmlspecialchars($usuario_id) ?></h3>
            </div>

            <div class="saldo">
                <span>Saldo: <a id="saldo">R$ 0,00</a></span>
            </div>

            <form class="acoes" method="post" action='saldo.php'>
                <input type="number" placeholder="Insira o valor" id="valor-transacao" name="valor">
                <div class="botoes">
                    <button type="submit" class="btn-style" name="action" value="depositar">Depositar</button>
                    <button type="submit" class="btn-alt" name="action" value="sacar">Sacar</button>
                </div>
            </form>
        </aside>

        <section class="main-content">

            <div class="historico">
                <div id="historico">
                    <label>Historico de Transacoes:</label>
                </div>
                <ul id="lista-historico">
                    <li>Teste</li>
                    <li>Teste</li>
                </ul>
            </div>
        </section>
    </div>
</body>
</html>