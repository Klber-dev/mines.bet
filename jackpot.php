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
  <title>CraftingLucky 🎰</title>
  <link href="./assets/jackpot.css" rel="stylesheet">
  <script src="jackpot.js" defer></script>
</head>
<body>

<!-- HEADER -->
<header class="header-container">
    <div class="logo">
        <a href="index.php">
            <img src="./assets/imagens/logo_minecraft.png" alt="Logo Mine">
        </a>
    </div>
    <div class="header-buttons">
        <a href="jogos.php" class="btn-style">Outros Jogos</a>
        <a href="perfil.php" class="btn-style">Meu Perfil</a>
    </div>
</header>

<!-- PAINEL DE APOSTA -->
<div class="aposta-container">
    <p>Aposta:</p>
    <input type="number" id="valorAposta" placeholder="Valor da aposta" required>
    <p>Saldo: R$ <span id="saldo"><?php echo number_format($usuario['saldo'], 2, ',', '.'); ?></span></p>
</div>

<!-- WRAPPER CENTRAL -->
<div class="crafting-wrapper">
    <div class="crafting-container">
        <h1>CraftingLucky</h1>

        <div class="crafting-border">
            <div class="crafting-grid">
                <div class="slot"></div>
                <div class="slot"></div>
                <div class="slot"></div>
                <div class="slot" id="slot1">❔</div>
                <div class="slot" id="slot2">❔</div>
                <div class="slot" id="slot3">❔</div>
                <div class="slot"></div>
                <div class="slot"></div>
                <div class="slot"></div>
            </div>

            <div style="text-align:center; margin-top:20px;">
                <button id="Sortear">Girar</button>
            </div>
            <p id="mensagem"></p>
        </div>
    </div>
</div>

</body>
</html>
