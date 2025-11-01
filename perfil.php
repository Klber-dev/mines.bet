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
                <a href='mines.php' class="btn-style">Jogar</a>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <div class="side-bar">

        </div>
        <div class="main-content">
            <form>
                <input placeholder="Insira o valor"></input>
            </form>
        </div>
    </div>
</body>

</html>