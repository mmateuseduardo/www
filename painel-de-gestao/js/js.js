const   btn = document.getElementById('btn');

function toogleMenu() {
    const   nav = document.getElementById('nav');
    nav.classList.toggle('active');    
}

btn.addEventListener('click', toggleMenu);