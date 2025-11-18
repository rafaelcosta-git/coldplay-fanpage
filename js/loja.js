// ========================================
// CONFIGURAÇÃO DO LOCALSTORAGE
// ========================================
const CART_KEY = "coldplay_cart";
const FILTER_KEY = "coldplay_filtro"; // <-- ADICIONADO AQUI

function loadCart() {
  try {
    const data = localStorage.getItem(CART_KEY);
    return data ? JSON.parse(data) : [];
  } catch (e) {
    console.error("Erro ao carregar carrinho:", e);
    return [];
  }
}

function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

let produtos = [];
let cart = loadCart();

// ========================================
// 1. CARREGAR PRODUTOS
// ========================================
async function loadProdutos() {
  try {
    const response = await fetch("js/catalogo.json");
    if (!response.ok) throw new Error("Erro ao carregar catálogo");

    const data = await response.json();
    produtos = data.produtos || [];

    renderProdutos();
    initDropdownFiltro();  // FILTRO DO DROPDOWN
  } catch (err) {
    console.error(err);
    document.getElementById("produtos-container").innerHTML =
      `<p class="text-danger">Erro ao carregar os produtos.</p>`;
  }
}

// ========================================
// 2. RENDERIZAR PRODUTOS
// ========================================
function renderProdutos() {
  const container = document.getElementById("produtos-container");
  const countEl = document.getElementById("produtos-count");

  if (!produtos.length) {
    container.innerHTML = `<p class="text-muted">Nenhum produto disponível.</p>`;
    countEl.textContent = "";
    return;
  }

  countEl.textContent = `${produtos.length} produto(s) disponível(eis)`;

  container.innerHTML = produtos
    .map(
      (p) => `
      <div class="col-md-6 produto-card fade-scale" data-categoria="${p.categoria}">
        <div class="card h-100 shadow-sm">
          <img src="${p.imagem}" class="card-img-top" alt="${p.nome}">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">${p.nome}</h5>
            <p class="card-text small text-muted">${p.descricao}</p>
            <p class="fw-bold mb-2">${p.preco.toFixed(2)} €</p>

            <div class="d-flex gap-2 mt-auto">
              <button class="btn btn-secondary w-50" onclick="abrirLightbox(${p.id})">
                Ver detalhes
              </button>

              <button class="btn btn-primary w-50" onclick="addToCart(${p.id})">
                <i class="fa-solid fa-cart-plus me-1"></i> Adicionar
              </button>
            </div>

          </div>
        </div>
      </div>
    `
    )
    .join("");
}

// ========================================
// 3. FILTRAGEM – USANDO DROPDOWN (COM D1)
// ========================================
function initDropdownFiltro() {
  const select = document.getElementById("categoria-select");
  if (!select) return;

  // 1️⃣ Carregar filtro guardado no LocalStorage
  const filtroGuardado = localStorage.getItem(FILTER_KEY);
  if (filtroGuardado) {
    select.value = filtroGuardado;
    aplicarFiltroDropdown(filtroGuardado);
  }

  // 2️⃣ Guardar o filtro sempre que mudar
  select.addEventListener("change", () => {
    const categoria = select.value;
    localStorage.setItem(FILTER_KEY, categoria); 
    aplicarFiltroDropdown(categoria);
  });
}

function aplicarFiltroDropdown(categoriaFiltro) {
  const cards = document.querySelectorAll(".produto-card");

  cards.forEach((card) => {
    const categoria = card.dataset.categoria;

    if (categoriaFiltro === "todos" || categoriaFiltro === categoria) {
      card.classList.remove("hidden");
      setTimeout(() => (card.style.display = "block"), 100);
    } else {
      card.classList.add("hidden");
      setTimeout(() => (card.style.display = "none"), 300);
    }
  });

  window.scrollTo({
    top: 300,
    behavior: "smooth",
  });
}

// ========================================
// SISTEMA DE CARRINHO (INALTERADO)
// ========================================
function addToCart(id) {
  const produto = produtos.find((p) => p.id === id);
  if (!produto) return;

  const existente = cart.find((item) => item.id === id);

  if (existente) {
    existente.quantidade++;
  } else {
    cart.push({
      id: produto.id,
      nome: produto.nome,
      preco: produto.preco,
      imagem: produto.imagem,
      quantidade: 1,
    });
  }

  saveCart(cart);
  renderCart();
}

function renderCart() {
  const container = document.getElementById("cart-items");
  const totalEl = document.getElementById("cart-total");
  const badge = document.getElementById("cart-count");

  if (!cart.length) {
    container.innerHTML = `<p class="text-muted">Ainda não há itens no carrinho.</p>`;
    totalEl.textContent = "0 €";
    badge.textContent = "0";
    disableCartButtons();
    return;
  }

  let total = 0;

  container.innerHTML = cart
    .map((item) => {
      const subtotal = item.preco * item.quantidade;
      total += subtotal;

      return `
        <div class="d-flex align-items-center mb-3">
          <img src="${item.imagem}" class="me-3 rounded" style="width:60px;height:60px;object-fit:cover;">
          
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between">
              <strong>${item.nome}</strong>
              <span>${subtotal.toFixed(2)} €</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-1">
              <small class="text-muted">Preço: ${item.preco.toFixed(2)} €</small>

              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-light" onclick="updateQuantity(${item.id}, -1)">-</button>
                <button class="btn btn-outline-light disabled">${item.quantidade}</button>
                <button class="btn btn-outline-light" onclick="updateQuantity(${item.id}, 1)">+</button>
              </div>

              <button class="btn btn-link text-danger" onclick="removeFromCart(${item.id})">
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
      `;
    })
    .join("");

  totalEl.textContent = `${total.toFixed(2)} €`;
  badge.textContent = cart.reduce((sum, item) => sum + item.quantidade, 0);

  enableCartButtons();
}

function enableCartButtons() {
  document.getElementById("btn-finalizar").disabled = false;
  document.getElementById("btn-limpar").disabled = false;
}

function disableCartButtons() {
  document.getElementById("btn-finalizar").disabled = true;
  document.getElementById("btn-limpar").disabled = true;
}

function updateQuantity(id, delta) {
  const item = cart.find((i) => i.id === id);
  if (!item) return;

  item.quantidade += delta;

  if (item.quantidade <= 0) cart = cart.filter((i) => i.id !== id);

  saveCart(cart);
  renderCart();
}

function removeFromCart(id) {
  cart = cart.filter((i) => i.id !== id);
  saveCart(cart);
  renderCart();
}

function clearCart() {
  cart = [];
  saveCart(cart);
  renderCart();
}

// ========================================
// 7. EVENTOS GERAIS
// ========================================
document.addEventListener("DOMContentLoaded", () => {
  loadProdutos();
  renderCart();

  document.getElementById("btn-limpar").addEventListener("click", () => {
    if (confirm("Deseja limpar o carrinho?")) clearCart();
  });

  document.getElementById("btn-finalizar").addEventListener("click", () => {
    if (!cart.length) return;
    alert("Compra simulada! Obrigado ❤️");
    clearCart();
  });
});

// ========================================
// 8. LIGHTBOX PROFISSIONAL
// ========================================
function abrirLightbox(id) {
  const produto = produtos.find(p => p.id === id);
  if (!produto) return;

  const box = document.getElementById("lightbox");
  const content = document.getElementById("lightbox-content");

  content.innerHTML = `
    <img src="${produto.imagem}" class="img-fluid mb-3">
    <h3>${produto.nome}</h3>
    <p class="text-muted">${produto.descricao}</p>
    <p class="fw-bold fs-3">${produto.preco.toFixed(2)} €</p>
  `;

  box.style.display = "flex";
  document.body.style.overflow = "hidden";
}

document.getElementById("lightbox-close")?.addEventListener("click", fecharLightbox);
document.getElementById("lightbox")?.addEventListener("click", (e) => {
  if (e.target.id === "lightbox") fecharLightbox();
});

function fecharLightbox() {
  document.getElementById("lightbox").style.display = "none";
  document.body.style.overflow = "auto";
}
