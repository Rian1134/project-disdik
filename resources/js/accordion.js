/**
 * accordion.js
 * Mengelola buka/tutup panel accordion.
 *
 * Jika data-accordion-multiple="false" (default), membuka satu panel akan
 * menutup panel lain dalam grup yang sama.
 */

document.addEventListener('click', function (event) {
    const trigger = event.target.closest('[data-accordion-trigger]');
    if (!trigger) return;

    const item = trigger.closest('[data-accordion-item]');
    const group = trigger.closest('[data-accordion]');
    const content = item.querySelector('[data-accordion-content]');
    const icon = item.querySelector('[data-accordion-icon]');
    const isMultiple = group.getAttribute('data-accordion-multiple') === 'true';
    const isOpen = trigger.getAttribute('aria-expanded') === 'true';

    if (!isMultiple) {
        group.querySelectorAll('[data-accordion-item]').forEach((otherItem) => {
            if (otherItem === item) return;
            const otherTrigger = otherItem.querySelector('[data-accordion-trigger]');
            const otherContent = otherItem.querySelector('[data-accordion-content]');
            const otherIcon = otherItem.querySelector('[data-accordion-icon]');
            otherTrigger.setAttribute('aria-expanded', 'false');
            otherContent.classList.add('hidden');
            otherIcon?.classList.remove('rotate-180');
        });
    }

    trigger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
    content.classList.toggle('hidden', isOpen);
    icon?.classList.toggle('rotate-180', !isOpen);
});
