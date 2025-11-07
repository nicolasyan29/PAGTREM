// Funções de validação de formulários
function validarCamposObrigatorios(campos) {
  for (const campo of campos) {
    if (!campo.value.trim()) {
      return false;
    }
  }
  return true;
}

function mostrarErro(elemento, mensagem) {
  elemento.textContent = mensagem;
}

function limparErro(elemento) {
  elemento.textContent = "";
}

// Validação de login
function validarLogin() {
  const usuario = document.getElementById("usuario").value.trim();
  const senha = document.getElementById("senha").value.trim();
  const mensagemErro = document.getElementById("mensagemErro");

  limparErro(mensagemErro);

  if (usuario === "admin" && senha === "1234") {
    window.location.href = "menu.html";
  } else {
    mostrarErro(mensagemErro, "Usuário ou senha inválidos.");
  }
}

// Navegação entre telas
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

  if (!validarCamposObrigatorios([document.getElementById("nome"), document.getElementById("nascimento")])) {
    mostrarErro(erro, "Preencha todos os campos.");
    return;
  }

  limparErro(erro);
  irParaTela(2);
}

function validarTela2() {
  const email = document.getElementById("email").value.trim();
  const senha = document.getElementById("senha").value;
  const erro = document.getElementById("erro2");

  const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  if (!emailValido || senha.length < 6) {
    mostrarErro(erro, "E-mail inválido ou senha muito curta.");
    return;
  }

  limparErro(erro);
  irParaTela(3);
}

function finalizar() {
  alert("Cadastro finalizado com sucesso!");
}

// Navegação de menu
document.addEventListener("DOMContentLoaded", () => {
  const homeBtn = document.getElementById("nav-home");
  const backBtn = document.getElementById("nav-back");
  const forwardBtn = document.getElementById("nav-forward");

  if (homeBtn) homeBtn.onclick = () => window.location.href = "cadastro1.html";
  if (backBtn) backBtn.onclick = () => history.back();
  if (forwardBtn) forwardBtn.onclick = () => history.forward();
});
