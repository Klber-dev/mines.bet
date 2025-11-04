document.addEventListener("DOMContentLoaded", () => {
    const botao = document.getElementById("Sortear");
    const slots = [
      document.getElementById("slot1"),
      document.getElementById("slot2"),
      document.getElementById("slot3")
    ];
    const mensagem = document.getElementById("mensagem");
  
    botao.addEventListener("click", async () => {
      botao.disabled = true;
      mensagem.textContent = "Girando...";
      const anim = setInterval(() => {
        slots.forEach(s => {
          const pool = ["💎","🍒","🍇","🥮","🔔","🍀","💰","⭐","🎁"];
          s.textContent = pool[Math.floor(Math.random() * pool.length)];
        });
      }, 100);
  
      // busca do php
      const response = await fetch("sorteio.php");
      const resultado = await response.json();
  
      // animação
      setTimeout(() => {
        clearInterval(anim);
        slots[0].textContent = resultado[0];
        slots[1].textContent = resultado[1];
        slots[2].textContent = resultado[2];
  
        if (resultado[0] === resultado[1] && resultado[1] === resultado[2]) {
          mensagem.textContent = "JACKPOT";
        } else {
          mensagem.textContent = "Tente novamente!";
        }
  
        botao.disabled = false;
      }, 1500);
    });
  });
  