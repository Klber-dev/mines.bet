//Função desse script:
// 1 - Tem funções pra mostrar ou esconder o popup de login
// 2 - Faz requisições fetch pra verificar se o usuário ta logado ou não
// 3 - Atualiza o header do cabeçalho baseado na linha acima
// 4 - Intercepta a comunicação entre front e backend

const btnJogar = document.querySelector('.btn-play');
const btnLogin = document.querySelector('.btn-login');
const btnPerfil = document.getElementById('btn-perfil');
const conteudo = document.getElementById('conteudo');
const popup = document.getElementById('pop-up');
const formPopup = document.getElementById('form-popup');

function abrirPopup() {
  popup.classList.add('ativo');
  conteudo.classList.add('blur');
}

function fecharPopup() {
  popup.classList.remove('ativo');
  conteudo.classList.remove('blur');
}

popup.addEventListener('click', (e) => {
  if (e.target === popup) {
    fecharPopup();
  }
});

async function atualizarHeader() {
  try {
    const res = await fetch('verificar_login.php');
    const data = await res.json(); //converte para objeto
    if (data.logado) {
      btnLogin.style.display = 'none';
      btnPerfil.style.display = 'inline-block';
    } else {
      btnLogin.style.display = 'inline-block';
      btnPerfil.style.display = 'none';
    }
  } catch (err) {
    console.error('Erro ao atualizar header:', err);
  }
}

btnJogar.addEventListener('click', async (e) => {
  e.preventDefault();
  try {
    const res = await fetch('verificar_login.php');
    const data = await res.json();
    if (data.logado) {
      window.location.href = 'mines.php';
    } else {
      abrirPopup();
    }
  } catch (err) {
    console.error('Erro ao verificar login:', err);
    abrirPopup();
  }
});


btnLogin.addEventListener('click', (e) => {
  e.preventDefault();
  abrirPopup();
});


formPopup.addEventListener('submit', async (e) => {
  e.preventDefault();

  const clickedButton = document.activeElement; // Coleta a ação
  const formData = new FormData(formPopup); // Coleta dados do form
  formData.set('action', clickedButton.value); //Cria um novo campo no objeto (ou substitui se já existir)

  try {
    const res = await fetch('autenticar.php', { method: 'POST', body: formData }); //Envia dados pro PHP
    const data = await res.json(); //Pega o resultado e converte para objeto

    if (!data.success) {
      alert(data.msg);
      return;
    }
    
    atualizarHeader();
    fecharPopup();

    if (clickedButton.value === 'jogar') {
      window.location.href = 'mines.php';
      return;
    }


  } catch (err) {
    console.error('Erro ao processar login/cadastro', err);
    alert('Ocorreu um erro. Tente novamente!');
  }
});

window.addEventListener('DOMContentLoaded', atualizarHeader);

//Em suma o código usa o fetch pra consultar o servidor sem atualizar a página 