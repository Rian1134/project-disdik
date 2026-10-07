/**
 * dropdown.js
 * Mengelola buka/tutup menu dropdown.
 *
 * Struktur HTML (dihasilkan oleh <x-dropdown>):
 * <div data-dropdown>
 *   <div data-dropdown-trigger>...</div>
 *   <div data-dropdown-menu class="hidden">...</div>
 * </div>
 */

function closeAllDropdowns(except = null) {
    document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => {
        if (menu !== except) menu.classList.add('hidden');
    });
}

document.addEventListener('click', function (event) {
    const trigger = event.target.closest('[data-dropdown-trigger]');

    if (trigger) {
        const wrapper = trigger.closest('[data-dropdown]');
        const menu = wrapper?.querySelector('[data-dropdown-menu]');
        if (!menu) return;

        const isHidden = menu.classList.contains('hidden');
        closeAllDropdowns();
        if (isHidden) menu.classList.remove('hidden');
        return;
    }

    // BUG FIX: klik pada item di dalam menu (link/tombol) harus menutup dropdown.
    // Sebelumnya ini tidak tertangani karena closest('[data-dropdown]') selalu
    // truthy untuk klik di dalam menu, sehingga cabang "klik di luar" di bawah
    // tidak pernah tereksekusi dan menu tetap terbuka setelah item dipilih.
    const item = event.target.closest('[data-dropdown-menu] a, [data-dropdown-menu] button');
    if (item) {
        closeAllDropdowns();
        return;
    }

    // Klik di luar dropdown menutup semua menu yang terbuka
    if (!event.target.closest('[data-dropdown]')) {
        closeAllDropdowns();
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') closeAllDropdowns();
});
