<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./assets/style.css" rel="stylesheet">
  <title>Mine$ - Início</title>
</head>

<body>
  <div id="conteudo">
    <header>
      <div class="header-container">
        <div class="logo"><img src="./assets/imagens/logo_minecraft.png" alt="Logo Mine">
        </div>
        <nav>
          <a href="#" class="btn-login btn-style">Login</a>
          <a href="perfil.php" class="btn-style" id="btn-perfil" style="display:none;">Meu Perfil</a>
        </nav>
      </div>
    </header>

    <main class="main-container">
      <h1>Desafie a sorte no <br><span>campo minado</span></h1>
      <p>Encontre os diamantes e evite as minas para multiplicar seu saldo.</p>
      <a href="jogos.php" class="btn-play">Jogar Agora</a>
    </main>
  </div>

  <div id="pop-up">

    <form id="form-popup" class="popup-content">
      <span class="bem-vindo">Bem-Vindo <img src="./assets/imagens/creeper-icon.jpg" alt="picareta mine"></span>
  
      <label for="cpf">CPF:</label>
      <input class="input-style" type="number" id="cpf" placeholder="insira o CPF" name="cpf" required>

      <label for="password">Senha:</label>
      <input class="input-style" type="password" id="password" placeholder="insira senha" name="password" required>

      <button class="btn-button" type="submit" name="action" value="entrar">Entrar</button>
      <button class="btn-button" type="submit" name="action" value="cadastrar">Cadastrar</button>
    </form>

  </div>


  <script src="script.js"></script>
</body>

</html>