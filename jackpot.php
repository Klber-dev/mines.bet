<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CraftingLucky 🎰</title>
  <link rel="stylesheet" href="jackpot.css">
  <script src="jackpot.js" defer></script>
</head>
<body>
  <div class="crafting-container">
    <h1>CraftingLucky</h1>

    <div class="crafting-border">
      <div class="crafting-grid">
        <!-- Linha de cima -->
        <div class="slot"></div>
        <div class="slot"></div>
        <div class="slot"></div>

        <!-- Linha do meio (será atualizada pelo JS) -->
        <div class="slot" id="slot1">❔</div>
        <div class="slot" id="slot2">❔</div>
        <div class="slot" id="slot3">❔</div>

        <!-- Linha de baixo -->
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
</body>
</html>
