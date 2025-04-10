import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const dayLinks = document.querySelectorAll('.js-nav-day');

    dayLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            document.querySelector('.page-nav__day_chosen')?.classList.remove('page-nav__day_chosen');

            link.classList.add('page-nav__day_chosen');
        });
    });
});

