 function proximaEtapa() {
  const nome = document.getElementById("nome").value.trim();
  const nascimento = document.getElementById("nascimento").value.trim();
  const erro1 = document.getElementById("erro1");

  if (!nome || !nascimento) {
    erro1.textContent = "Preencha todos os campos.";
  } else {
    window.location.href = "cadastro2.html";
  }
}

 function validarFormulario() {
  const nome = document.getElementById("nome").value.trim();
  const nascimento = document.getElementById("nascimento").value.trim();
  const erro = document.getElementById("mensagemErro");

  if (!nome || !nascimento) {
    erro.textContent = "Preencha todos os campos corretamente.";
    return false;
  } else {
    window.location.href = "cadastro3.html";
    return false;
  }
}

 function irParaCadastro4() {
  window.location.href = "cadastro4.html";
}

 function irParaEmail() {
  window.location.href = "email.html";
 
}

 function redirecionarParaDashboard() {
  setTimeout(() => {
    window.location.href = "dashboard.html";
  }, 2000);

}

 document.addEventListener("DOMContentLoaded", () => {
  const homeBtn = document.getElementById("nav-home");
  const backBtn = document.getElementById("nav-back");
  const forwardBtn = document.getElementById("nav-forward");

  if (homeBtn) homeBtn.onclick = () => window.location.href = "cadastro1.html";
  if (backBtn) backBtn.onclick = () => history.back();
  if (forwardBtn) forwardBtn.onclick = () => history.forward();
});

function irParaTela2() {
  const nome = document.getElementById('nome').value.trim();
  const nascimento = document.getElementById('nascimento').value;

  if (nome === "" || nascimento === "") {
    alert("Por favor, preencha todos os campos.");
    return;
  }

  document.getElementById('tela1').classList.add('hidden');
  document.getElementById('tela2').classList.remove('hidden');
}

function enviarCadastro() {
  const email = document.getElementById('email').value.trim();
  const senha = document.getElementById('senha').value;

  if (email === "" || senha === "") {
    alert("Por favor, preencha todos os campos.");
    return;
  }


  alert("Cadastro concluído com sucesso!");
}

function validarLogin() {
  const usuario = document.getElementById("usuario").value.trim();
  const senha = document.getElementById("senha").value.trim();
  const mensagemErro = document.getElementById("mensagemErro");

  mensagemErro.textContent = "";


  if (usuario === "admin" && senha === "1234") {
    window.location.href = "menu.html";
  } else {
    mensagemErro.textContent = "Usuário ou senha inválidos.";
  }
}

function irParaTela(num) {
  document.querySelectorAll('.tela').forEach(t => t.classList.remove('ativa'));
  document.getElementById(`tela${num}`).classList.add('ativa');
}

function voltar(num) {
  irParaTela(num);
}

function validarTela1() {
  const nome = document.getElementById("nome").value.trim();
  const nasc = document.getElementById("nascimento").value;
  const erro = document.getElementById("erro1");

  if (nome === "" || nasc === "") {
    erro.textContent = "Preencha todos os campos.";
    return;
  }

  erro.textContent = "";
  irParaTela(2);
}

function validarTela2() {
  const email = document.getElementById("email").value.trim();
  const senha = document.getElementById("senha").value;
  const erro = document.getElementById("erro2");

  const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  if (!emailValido || senha.length < 6) {
    erro.textContent = "E-mail inválido ou senha muito curta.";
    return;
  }

  erro.textContent = "";
  irParaTela(3);
}

function finalizar() {
  alert("Cadastro finalizado com sucesso!");
}

function proximaTela(num) {
  if (num === 1) {
    document.getElementById('tela1').classList.add('hidden');
    document.getElementById('tela2').classList.remove('hidden');
  } else if (num === 2) {
    document.getElementById('tela2').classList.add('hidden');
    document.getElementById('tela3').classList.remove('hidden');
  }
}

function voltarTela(num) {
  if (num === 1) {
    document.getElementById('tela2').classList.add('hidden');
    document.getElementById('tela1').classList.remove('hidden');
  } else if (num === 2) {
    document.getElementById('tela3').classList.add('hidden');
    document.getElementById('tela2').classList.remove('hidden');
  }
}
