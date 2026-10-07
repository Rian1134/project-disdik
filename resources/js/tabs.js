/**
 * tabs.js
 * Mengelola perpindahan antar tab.
 *
 * Struktur HTML (dihasilkan oleh <x-tabs>, <x-tabs.link>, <x-tabs.pane>):
 * <div data-tabs>
 *   <div data-tabs-nav>
 *     <button data-tabs-link data-target="tab-a">A</button>
 *   </div>
 *   <div data-tabs-content>
 *     <div data-tabs-pane id="tab-a">...</div>
 *   </div>
 * </div>
 */

document.addEventListener('click', function (event) {
    const link = event.target.closest('[data-tabs-link]');
    if (!link) return;

    const group = link.closest('[data-tabs]');
    const targetId = link.getAttribute('data-target');
    const targetPane = document.getElementById(targetId);
    if (!targetPane) return;

    // Nonaktifkan semua link & pane dalam grup ini
    group.querySelectorAll('[data-tabs-link]').forEach((el) => {
        el.setAttribute('aria-selected', 'false');
        el.classList.remove('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
        el.classList.add('border-transparent', 'text-gray-500');
    });

    group.querySelectorAll('[data-tabs-pane]').forEach((pane) => {
        pane.classList.add('hidden');
    });

    // Aktifkan link & pane yang dipilih
    link.setAttribute('aria-selected', 'true');
    link.classList.remove('border-transparent', 'text-gray-500');
    link.classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
    targetPane.classList.remove('hidden');
});
