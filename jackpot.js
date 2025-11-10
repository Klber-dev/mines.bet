window.onload = function() {
  const botao = document.getElementById("Sortear");
  const slot1 = document.getElementById("slot1");
  const slot2 = document.getElementById("slot2");
  const slot3 = document.getElementById("slot3");
  const msg = document.getElementById("mensagem");
  const simbolos = ["💎", "🥮", "🍒", "🍇", "🔔"];
  const saldoSpan = document.getElementById("saldo");
  const inputAposta = document.getElementById("valorAposta");

  botao.onclick = function() {
    const aposta = parseFloat(inputAposta.value);
    const saldoAtual = parseFloat(saldoSpan.textContent.replace(/\./g, '').replace(',', '.'));

    if (isNaN(aposta) || aposta <= 0) {
      alert("Digite um valor de aposta válido.");
      return;
    }
    if (aposta > saldoAtual) {
      alert("Saldo insuficiente!");
      return;
    }

    botao.disabled = true;
    msg.textContent = "Girando e Rodando Maôi";

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

          const multiplicador = calcularMultiplicador(resultado);
          let resultadoFinal = "lose";

          if (multiplicador > 0) {
            resultadoFinal = "win";
            msg.textContent = `Você ganhou! x${multiplicador}`;
          } else {
            msg.textContent = "Tente novamente!";
          }

          atualizarSaldo(resultadoFinal, aposta, multiplicador);
        })
        .catch(() => {
          msg.textContent = "Erro ao sortear!";
          botao.disabled = false;
        });
    }, 1500);
  };

  function calcularMultiplicador(resultado) {
    if (resultado[0] === resultado[1] && resultado[1] === resultado[2]) return 3;
    if (
      resultado[0] === resultado[1] ||
      resultado[0] === resultado[2] ||
      resultado[1] === resultado[2]
    ) return 1.5;
    return 0;
  }

  function atualizarSaldo(resultado, valor, multiplicador = 1) {
    const body = `action=jogo&valor=${valor}&resultado=${resultado}&multiplicador=${multiplicador}`;
    fetch("saldo.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: body
    })
      .then(res => res.json())
      .then(data => {
        if (data.sucesso) {
          saldoSpan.textContent = data.novoSaldo
            .toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        } else {
          alert("Erro: " + (data.erro || "desconhecido"));
        }
        botao.disabled = false;
      })
      .catch(() => {
        alert("Erro ao atualizar saldo.");
        botao.disabled = false;
      });
  }
};
