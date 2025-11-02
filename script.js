//Tentativa (talvez equivocada) de explicar a função desse script:
// 1 - Tem funções pra mostrar ou esconder o popup de login
// 2 - Faz requisições fetch pra verificar se o usuário ta logado ou não
// 3 - Atualiza o header do cabeçalho baseado nisso ^

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

//Funcao pra quando clicar fora do popup ele fechar ( no container externo da parada)
popup.addEventListener('click', (e) => {
  if (e.target === popup) {
    fecharPopup();
  }
});

//Com essa funcao eu troco o botão de login para botão de "Perfil"
async function atualizarHeader() {
  try {
    const res = await fetch('verificar_login.php');
    const data = await res.json(); //transforma a resposta em um arquivo json ( eu acho)
    if (data.logado) {
      btnLogin.style.display = 'none';
      btnPerfil.style.display = 'inline-block';
    } else {
      btnLogin.style.display = 'inline-block';
      btnPerfil.style.display = 'none';
    }
  } catch (err) {
    //Pra caso algum erro aconteça no try{}, transforma o erro na variável de parametro "err" e mostra no console
    console.error('Erro ao atualizar header:', err);
  }
}

//Assim que vc clicar em jogar....
btnJogar.addEventListener('click', async (e) => {
  e.preventDefault();
  try {
    const res = await fetch('verificar_login.php');
    const data = await res.json();
    if (data.logado) {
      //Se logado for verdadeiro, te encaminha pro jogo
      window.location.href = 'mines.php';
    } else {
      //Se não, abre o popup de login
      abrirPopup();
    }
  } catch (err) {
    //Mesma coisa que expliquei antes
    console.error('Erro ao verificar login:', err);
    abrirPopup();
  }
});

//E se a essa altura você já se perguntou o que é esse preventDefault...
//Básicamente é pra tirar as "funções" padrão do navegador
//Tipo href que vai te levar pra outra página
//Agora o que esse eventlistener ta fazendo é bem óbvio né
btnLogin.addEventListener('click', (e) => {
  e.preventDefault();
  abrirPopup();
});

//
formPopup.addEventListener('submit', async (e) => {
  e.preventDefault();
  //Aqui ele define que o botão que foi enviado é igual ao documento que foi ativado, no caso o valor dele (login ou cadastrar)
  const clickedButton = document.activeElement;
  //Aqui ele pega os dados do formulario e transforma em dados para serem enviados pro php
  const formData = new FormData(formPopup);
  //E claro, muda o valor baseado no botão que foi clicado
  formData.set('action', clickedButton.value);

  try {
    //o fetch faz a requisição HTTP, nesse caso ele ta enviando as coisas pro php
    //Se vc ta se perguntando o que é o await, é eu especificando pro js esperar a resposta do php pra continuar o programa
    const res = await fetch('autenticar.php', { method: 'POST', body: formData });
    //Ai aqui o php retorna um true ou false na variavel success
    const data = await res.json();

    if (!data.success) {
      alert(data.msg);
      return;
    }

    atualizarHeader();
    fecharPopup();

    if (clickedButton.value === 'jogar') {
      window.location.href = 'mines.php';
    }

  } catch (err) {
    console.error('Erro ao processar login/cadastro', err);
    alert('Ocorreu um erro. Tente novamente!');
  }
});

window.addEventListener('DOMContentLoaded', atualizarHeader);