document.getElementById("contactForm").addEventListener("submit", function(event){
  event.preventDefault();

  let nome = document.getElementById("nome").value.trim();
  let apelido = document.getElementById("apelido").value.trim();
  let dataNasc = document.getElementById("dataNasc").value;
  let telefone = document.getElementById("telefone").value.trim();
  let email = document.getElementById("email").value.trim();
  let mensagem = document.getElementById("mensagem").value.trim();
  let msgBox = document.getElementById("formMessage");

  let emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

  if(nome === "" || apelido === "" || dataNasc === "" || telefone === "" || email === "" || mensagem === ""){
    msgBox.innerHTML = `<div class="alert alert-danger">⚠️ Preencha todos os campos!</div>`;
    return;
  }

  if(!emailRegex.test(email)){
    msgBox.innerHTML = `<div class="alert alert-danger">⚠️ Insira um email válido!</div>`;
    return;
  }

  if(telefone.length < 9 || isNaN(telefone)){
    msgBox.innerHTML = `<div class="alert alert-danger">⚠️ O telefone deve ter 9 dígitos numéricos.</div>`;
    return;
  }

  msgBox.innerHTML = `<div class="alert alert-success">✅ Mensagem enviada com sucesso!</div>`;
  document.getElementById("contactForm").reset();
});

