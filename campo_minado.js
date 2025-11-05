const form = document.getElementById('form-jogo');
const campo = document.querySelector('.campo');
let matriz = [];
let jogoAtivo = false;

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const bombas = parseInt(document.getElementById('bombas').value);
    const aposta = parseFloat(document.getElementById('aposta').value);

    if (isNaN(aposta) || aposta <= 0) {
        alert("Digite um valor de aposta válido!");
        return;
    }

    if (bombas < 3 || bombas > 8) {
        alert("A quantidade de bombas deve ser entre 3 e 8.");
        return;
    }

    const response = await fetch(`campo_sorteio.php?bombas=${bombas}`);
    const data = await response.json();
    matriz = data.matriz;
    jogoAtivo = true;

    gerarCampo();
});

function gerarCampo() {
    campo.innerHTML = '';
    for (let i = 0; i < 3; i++) {
        for (let j = 0; j < 3; j++) {
            const cell = document.createElement('div');
            cell.classList.add('celula');
            cell.dataset.valor = matriz[i][j];
            cell.addEventListener('click', () => revelar(cell));
            campo.appendChild(cell);
        }
    }
}

function revelar(cell) {
    if (!jogoAtivo) return;
    const valor = parseInt(cell.dataset.valor);

    if (valor === 1) {
        cell.classList.add('bomba');
        jogoAtivo = false;
        alert("Perdeu");
        revelarTodas();
    } else {
        cell.classList.add('diamante');
        cell.removeEventListener('click', revelar);
    }
}

function revelarTodas() {
    const cells = document.querySelectorAll('.celula');
    cells.forEach(c => {
        const valor = parseInt(c.dataset.valor);
        if (valor === 1) c.classList.add('bomba');
        else c.classList.add('diamante');
    });
}

