const range = document.getElementById('rangeBombas');
const valorBombas = document.getElementById('valor-bombas');
const multiplicadorTexto = document.getElementById('multiplicador');
let btnApostar = document.querySelector('.btn-action');

let matrizAtual = [];
let jogoAtivo = false;
let acertos = 0;
let bombas = 3;

range.addEventListener('input', () => {
    valorBombas.textContent = range.value;
    bombas = parseInt(range.value);
    const multiplicador = (3 / bombas) * 3.9;
    multiplicadorTexto.textContent = 'x' + multiplicador.toFixed(2);
});

function mostrarResultado(tipo) {
    const overlay = document.getElementById('overlayResultado');
    const mensagem = overlay.querySelector('.mensagem');
    overlay.classList.remove('hidden', 'vitoria', 'derrota', 'show');

    if (tipo === 'vitoria') {
        overlay.classList.add('vitoria');
        mensagem.textContent = "Voce venceu!";
    } else {
        overlay.classList.add('derrota');
        mensagem.textContent = "Voce perdeu";
    }

    requestAnimationFrame(() => overlay.classList.add('show'));

    setTimeout(() => {
        overlay.classList.remove('show');
        setTimeout(() => overlay.classList.add('hidden'), 400);
    }, 1000);
}

btnApostar.addEventListener('click', async (event) => {
    event.preventDefault();

    const valorAposta = parseFloat(document.getElementById('valorAposta').value) || 0;
    const saldoAtual = parseFloat(document.getElementById('saldo').textContent.replace(/\./g,'').replace(',','.')) || 0;

    if (valorAposta <= 0) {
        alert("Digite um valor de aposta válido.");
        return;
    }

    if (valorAposta > saldoAtual) {
        alert("Saldo insuficiente para esta aposta.");
        return;
    }

    const qtdBombas = parseInt(range.value);

    try {
        const response = await fetch('campo_sorteio.php?bombas=' + qtdBombas);
        const data = await response.json();
        matrizAtual = data.matriz;
        jogoAtivo = true;
        acertos = 0;
        bombas = qtdBombas;
        
        const cells = document.querySelectorAll('.cell');
        cells.forEach(cell => {
            cell.classList.remove('bomba', 'diamante');
            cell.style.pointerEvents = 'auto';
        });

        document.querySelector('.campo-minado').classList.add('ativo');

    } catch (error) {
        console.error("Erro ao iniciar o jogo:", error);
    }
});

function revelarCampoCompleto() {
    const cells = document.querySelectorAll('.cell');
    cells.forEach((cell, index) => {
        const linha = Math.floor(index / 3);
        const coluna = index % 3;
        const valor = matrizAtual[linha][coluna];

        if (valor === 1) {
            cell.classList.add('bomba');
        } else {
            cell.classList.add('diamante');
        }

        cell.style.pointerEvents = 'none';
    });

    document.querySelector('.campo-minado').classList.remove('ativo');
}

function atualizarSaldo(resultado) {
    const valorAposta = parseFloat(document.getElementById('valorAposta').value) || 0;
    const multiplicador = parseFloat(multiplicadorTexto.textContent.replace('x','')) || 1;
    let body = `action=jogo&resultado=${resultado}&valor=${valorAposta}`;
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
            document.getElementById('saldo').textContent = data.novoSaldo.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        } else {
            console.error('Erro ao atualizar saldo:', data.erro);
        }
    })
    .catch(console.error);
}

document.querySelectorAll('.cell').forEach((cell, index) => {
    cell.addEventListener('click', () => {
        if (!jogoAtivo) return;
        const linha = Math.floor(index / 3);
        const coluna = index % 3;
        const valor = matrizAtual[linha][coluna];

        if (valor === 1) {
            cell.classList.add('bomba');
            jogoAtivo = false;
            mostrarResultado('derrota');
            revelarCampoCompleto();
            atualizarSaldo('lose');
        } else {
            cell.classList.add('diamante');
            acertos++;
            cell.style.pointerEvents = 'none';

            if (acertos === 9 - bombas) {
                jogoAtivo = false;
                mostrarResultado('vitoria');
                revelarCampoCompleto();
                atualizarSaldo('win');
            }
        }
    });
});
