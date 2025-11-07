window.onload = function() {
  const botao = document.getElementById("Sortear");
  const slot1 = document.getElementById("slot1");
  const slot2 = document.getElementById("slot2");
  const slot3 = document.getElementById("slot3");
  const msg = document.getElementById("mensagem");
  const simbolos = ["💎", "🥮", "🍒", "🍇", "🔔"];

  botao.onclick = function() {
    const valorAposta = parseFloat(document.getElementById('valorAposta').value) || 0;
    const saldoAtual = parseFloat(document.getElementById('saldo').textContent.replace(/\./g,'').replace(',','.')) || 0;
    if (valorAposta <= 0) {
      alert("Digite um valor válido.");
      return;
    }
    if (valorAposta > saldoAtual) {
      alert("Saldo insuficiente.");
      return;
    }

    botao.disabled = true;
    msg.textContent = "Rodando e Girando Maôi"

    const animacao = setInterval(() => {
      slot1.textContent = simbolos[Math.floor(Math.random() * simbolos.length)];
      slot2.textContent = simbolos[Math.floor(Math.random() * simbolos.length)];
      slot3.textContent = simbolos[Math.floor(Math.random() * simbolos.length)];
    }, 100);

    setTimeout(() => {
      clearInterval(animacao);

      fetch("jackpot_sorteio.php")
        .then(r => r.json())
        .then(resultado => {
          slot1.textContent = resultado[0];
          slot2.textContent = resultado[1];
          slot3.textContent = resultado[2];

          if (resultado[0] === resultado[1] && resultado[1] === resultado[2]) {
            msg.textContent = "JACKPOT! Você ganhou!";
          } else {
            msg.textContent = "Tente novamente!";
          }

          botao.disabled = false;
        });
    }, 1500);
  };
};

function atualizarSaldo(resultado, valor, multiplicador = 1) {
  let body = `action=jogo&resultado=${resultado}&valor=${valor}`;
  if (resultado === 'win') {
    body += `&multiplicador=${multiplicador}`;
  }
  fetch('saldo.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: body
  })
  .then(res => res.json())
  .then(data => {
    if (data.sucesso) {
      document.getElementById('saldo').textContent =
        data.novoSaldo.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
  });
}
