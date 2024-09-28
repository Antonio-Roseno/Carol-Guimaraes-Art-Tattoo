document.addEventListener('DOMContentLoaded', function() {
  // Seleciona o botão de menu (burger), a navegação, o overlay e os links da navegação
  const burger = document.querySelector('.burger');
  const nav = document.querySelector('.nav-links');
  const overlay = document.querySelector('.overlay');
  const navLinks = document.querySelectorAll('.nav-links a');

  // Função para alternar o menu, o overlay e o estado de rolagem da página
  function toggleMenu() {
    nav.classList.toggle('active'); // Exibe ou oculta o menu
    burger.classList.toggle('toggle'); // Anima o botão burger
    overlay.classList.toggle('active'); // Exibe ou oculta o overlay
    document.body.classList.toggle('no-scroll'); // Impede a rolagem da página
  }

  // Adiciona evento de clique no botão burger para alternar o menu
  burger.addEventListener('click', toggleMenu);

  // Adiciona evento de clique no overlay para fechar o menu
  overlay.addEventListener('click', toggleMenu);

  // Fecha o menu ao clicar em um link, caso o menu esteja ativo e a tela seja menor ou igual a 768px
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (nav.classList.contains('active') && window.innerWidth <= 768) {
        toggleMenu();
      }
    });
  });

  // Adiciona rolagem suave para links internos
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault(); // Previne o comportamento padrão do link

      // Rolagem suave até o elemento de destino
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });

  // Ajusta o menu ao redimensionar a tela
  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      nav.classList.remove('active'); // Exibe o menu na visualização desktop
      burger.classList.remove('toggle'); // Reseta a animação do botão burger
      overlay.classList.remove('active'); // Oculta o overlay
      document.body.classList.remove('no-scroll'); // Permite a rolagem da página
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const flowerCount = 50; // Quantidade de flores
  const hero = document.querySelector(".hero");

  // Função para criar uma flor com propriedades aleatórias
  function createFlower() {
    const flower = document.createElement("div");
    flower.classList.add("flower");

    // Posição e estilo aleatórios
    const randomLeft = Math.random() * 100; // Posição horizontal aleatória
    const randomDuration = Math.random() * 7 + 3; // Duração aleatória da queda
    const randomDelay = Math.random() * 5; // Atraso aleatório para evitar sincronização
    const randomSize = Math.random() * 30 + 20; // Tamanho aleatório das flores

    flower.style.left = `${randomLeft}vw`;
    flower.style.animationDuration = `${randomDuration}s`;
    flower.style.animationDelay = `${randomDelay}s`;
    flower.style.width = `${randomSize}px`;
    flower.style.height = `${randomSize}px`;

    // Adiciona o SVG de flor ao elemento
    flower.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-flower">
        <path d="M12 2l1.41 4.91L18 7.27l-3.54 3.45L15.91 16l-4.91-1.41L7.27 18l1.41-4.91L2 12l4.91-1.41L7.27 6l4.91 1.41z"></path>
      </svg>
    `;

    hero.appendChild(flower);

    // Remove a flor após a animação para evitar acúmulo de elementos
    flower.addEventListener("animationend", () => {
      flower.remove();
    });
  }

  // Cria múltiplas flores
  for (let i = 0; i < flowerCount; i++) {
    createFlower();
  }

  // Loop para adicionar mais flores ao longo do tempo
  setInterval(() => {
    createFlower();
  }, 1000); // Adiciona uma nova flor a cada segundo
});

