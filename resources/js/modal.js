/**
 * modal.js
 * Mengelola buka/tutup modal menggunakan atribut data-*.
 *
 * Cara pakai di HTML/Blade:
 * - Tombol buka  : <button data-modal-open="idModal">Buka</button>
 * - Tombol tutup : <button data-modal-close>Tutup</button> (di dalam modal)
 * - Modal        : <div id="idModal" data-modal>...</div>
 *
 * Modal dengan atribut data-modal-static="true" tidak akan tertutup saat backdrop diklik.
 */

function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');

    // Fokuskan panel modal untuk aksesibilitas
    const panel = modal.querySelector('[data-modal-panel]');
    if (panel) panel.focus?.();
}

function closeModal(modalEl) {
    if (!modalEl) return;
    modalEl.classList.add('hidden');
    modalEl.setAttribute('aria-hidden', 'true');

    // Hanya hilangkan scroll lock jika tidak ada modal lain yang masih terbuka
    const anyOpen = document.querySelectorAll('[data-modal]:not(.hidden)').length > 0;
    if (!anyOpen) document.body.classList.remove('overflow-hidden');
}

document.addEventListener('click', function (event) {
    // Buka modal
    const openTrigger = event.target.closest('[data-modal-open]');
    if (openTrigger) {
        openModal(openTrigger.getAttribute('data-modal-open'));
        return;
    }

    // Tutup modal via tombol close
    const closeTrigger = event.target.closest('[data-modal-close]');
    if (closeTrigger) {
        closeModal(closeTrigger.closest('[data-modal]'));
        return;
    }

    // Tutup modal via klik backdrop (kecuali static)
    const backdrop = event.target.closest('[data-modal-backdrop]');
    if (backdrop) {
        const modal = backdrop.closest('[data-modal]');
        if (modal && modal.getAttribute('data-modal-static') !== 'true') {
            closeModal(modal);
        }
    }
});

// Tutup modal teratas dengan tombol Escape
document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    const openModals = document.querySelectorAll('[data-modal]:not(.hidden)');
    const lastModal = openModals[openModals.length - 1];
    if (lastModal && lastModal.getAttribute('data-modal-static') !== 'true') {
        closeModal(lastModal);
    }
});
