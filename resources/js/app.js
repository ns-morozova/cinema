import './bootstrap';

import Alpine from 'alpinejs';

import '../css/client/styles.css';
import '../css/admin/styles.css'

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

document.addEventListener('focusin', function (e) {
    const el = e.target;

    const isTextInput =
        (el.tagName === 'INPUT' &&
            ['text', 'number', 'email', 'tel', 'url', 'search', 'password'].includes(el.type)) ||
        el.tagName === 'TEXTAREA';

    if (isTextInput && !el.dataset.selectedOnce) {
        el.select();
        el.dataset.selectedOnce = 'true';

        el.addEventListener('blur', () => {
            delete el.dataset.selectedOnce;
        }, { once: true });
    }
});

