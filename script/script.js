// menu
function menuShow() {
    let menuMobile = document.querySelector('.mobile-menu');
    if (menuMobile.classList.contains('open')) {
        menuMobile.classList.remove('open');
        document.querySelector('.icon').src = "./imagem/menu.png";
    } else {
        menuMobile.classList.add('open');
        document.querySelector('.icon').src = "./imagem/fechar.png";
    }
}

function closeMenuOnOptionClick() {
    const menuItems = document.querySelectorAll('.mobile-menu .nav-item a');
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            if (window.innerWidth < 600 && document.querySelector('.mobile-menu').classList.contains('open')) {
                menuShow(); // Fecha o menu apenas se estiver aberto
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    closeMenuOnOptionClick(); // Garantir que os eventos sejam adicionados ao carregar a página
});

const header = document.querySelector('header');
const headerOffset = header.offsetTop;

window.addEventListener('scroll', function() {
    if (window.pageYOffset > headerOffset) {
        header.classList.add('scroll');
    } else {
        header.classList.remove('scroll');
    }
});
