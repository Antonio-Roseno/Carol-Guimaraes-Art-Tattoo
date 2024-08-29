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
