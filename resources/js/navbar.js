/**
 * navbar.js
 * Mengelola toggle menu hamburger pada navbar mobile.
 */

document.addEventListener('click', function (event) {
    const toggle = event.target.closest('[data-navbar-toggle]');
    if (!toggle) return;

    const navbar = toggle.closest('[data-navbar]');
    const menu = navbar.querySelector('[data-navbar-menu]');
    const iconOpen = navbar.querySelector('[data-navbar-icon-open]');
    const iconClose = navbar.querySelector('[data-navbar-icon-close]');

    menu.classList.toggle('hidden');
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
});
