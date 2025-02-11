// Selecionando os elementos
const userImg = document.getElementById('user'); // Correção: usa querySelector para selecionar a classe
const dropdownMenu = document.getElementById('dropdownMenu');

// Função para exibir/ocultar o menu
function toggleMenu() {
  // Verifica se o menu está visível ou não e alterna o estado
  if (dropdownMenu.style.display === 'none') {
    dropdownMenu.style.display = 'flex';  // Se oculto, exibe
  } else {
    dropdownMenu.style.display = 'none';  // Se visível, oculta
  }
}

// Adicionando o evento de clique
if (userImg && dropdownMenu) { // Verifica se os elementos existem
  userImg.addEventListener('click', toggleMenu);  // Alterna a visibilidade do menu ao clicar na imagem
} else {
  console.error('Elemento não encontrado!');
}