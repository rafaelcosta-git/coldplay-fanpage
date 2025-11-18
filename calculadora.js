// ================================
// 1. Carregar produtos do catálogo
// ================================

let produtos = [];

async function loadProdutos() {
  try {
    const response = await fetch("js/catalogo.json");
    const data = await response.json();
    produtos = data.produtos || [];

    preencherDropdown();

  } catch (e) {
    console.error("Erro ao carregar catálogo:", e);
  }
}

// ================================
// 2. Preencher o dropdown
// ================================

function preencherDropdown() {
  const select = document.getElementById("produto-select");

  produtos.forEach((p) => {
    const option = document.createElement("option");
    option.value = p.id; // guardar ID
    option.textContent = `${p.nome} — ${p.preco.toFixed(2)} €`;
    select.appendChild(option);
  });
}

// ================================
// 3. Calcular o valor total
// ================================

function calcularTotal() {
  const select = document.getElementById("produto-select");
  const quantidadeInput = document.getElementById("quantidade");
  const resultado = document.getElementById("resultado");

  const idProduto = select.value;
  const quantidade = Number(quantidadeInput.value);

  // VALIDAR PRODUTO
  if (!idProduto) {
    resultado.classList.remove("d-none");
    resultado.classList.remove("alert-info");
    resultado.classList.add("alert-danger");
    resultado.textContent = "Selecione um produto primeiro.";
    return;
  }

  // VALIDAR QUANTIDADE
  if (quantidade <= 0 || isNaN(quantidade)) {
    resultado.classList.remove("d-none");
    resultado.classList.remove("alert-info");
    resultado.classList.add("alert-danger");
    resultado.textContent = "Insira uma quantidade válida (maior que zero).";
    return;
  }

  // ENCONTRAR PRODUTO
  const produto = produtos.find((p) => p.id == idProduto);

  if (!produto) return;

  const total = produto.preco * quantidade;

  resultado.classList.remove("d-none");
  resultado.classList.remove("alert-danger");
  resultado.classList.add("alert-info");

  resultado.innerHTML = `
    <strong>Produto:</strong> ${produto.nome} <br>
    <strong>Preço unitário:</strong> ${produto.preco.toFixed(2)} € <br>
    <strong>Quantidade:</strong> ${quantidade} <br><br>
    <strong>Total:</strong> ${total.toFixed(2)} € 
  `;
}

// ================================
// Inicializar ao carregar a página
// ================================

document.addEventListener("DOMContentLoaded", loadProdutos);


