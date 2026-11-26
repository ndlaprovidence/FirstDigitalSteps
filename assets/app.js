import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

function toggleDropdown(toggle) {
    const dropdown = toggle.closest('.dropdown');
    const menu = dropdown?.querySelector('.dropdown-menu');

    if (!dropdown || !menu) {
        return;
    }

    const isOpen = menu.classList.contains('show');

    document.querySelectorAll('.dropdown-menu.show').forEach((openMenu) => {
        openMenu.classList.remove('show');
        openMenu.closest('.dropdown')?.querySelector('[data-bs-toggle="dropdown"]')
            ?.setAttribute('aria-expanded', 'false');
    });

    if (!isOpen) {
        menu.classList.add('show');
        toggle.classList.add('show');
        toggle.setAttribute('aria-expanded', 'true');
        menu.dataset.bsPopper = 'static';
    } else {
        toggle.classList.remove('show');
        toggle.setAttribute('aria-expanded', 'false');
        delete menu.dataset.bsPopper;
    }
}

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-bs-toggle="dropdown"]');

    if (toggle) {
        event.preventDefault();
        toggleDropdown(toggle);
        return;
    }

    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu.show').forEach((menu) => {
            menu.classList.remove('show');
            menu.closest('.dropdown')?.querySelector('[data-bs-toggle="dropdown"]')
                ?.setAttribute('aria-expanded', 'false');
        });
    }
});

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
