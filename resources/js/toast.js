/**
 * toast.js
 * Mengelola auto-close & manual-close pada toast, serta dismiss pada alert.
 *
 * Toast statis (dari <x-toast>) otomatis dijalankan auto-close-nya saat elemen
 * muncul di halaman (lihat initStaticToasts).
 *
 * Untuk memicu toast secara dinamis dari JavaScript, gunakan showToast():
 *
 *   showToast({ type: 'success', message: 'Data berhasil disimpan!' });
 *
 * Wajib menaruh <div id="toast-container"> sekali di layout utama:
 *   <div id="toast-container" class="fixed z-50 top-4 right-4 flex flex-col gap-2
 *        w-full sm:w-auto px-4 sm:px-0"></div>
 */

function dismissToast(toastEl) {
    if (!toastEl) return;
    toastEl.style.transition = 'opacity 200ms ease, transform 200ms ease';
    toastEl.style.opacity = '0';
    toastEl.style.transform = 'translateY(-8px)';
    setTimeout(() => toastEl.remove(), 200);
}

function initStaticToasts() {
    document.querySelectorAll('[data-toast]').forEach((toast) => {
        if (toast.dataset.toastInitialized) return;
        toast.dataset.toastInitialized = 'true';

        const autoClose = toast.getAttribute('data-toast-autoclose') === 'true';
        const duration = parseInt(toast.getAttribute('data-toast-duration'), 10) || 4000;

        if (autoClose) {
            setTimeout(() => dismissToast(toast), duration);
        }
    });
}

// Membuat & menampilkan toast secara dinamis
function showToast({ type = 'info', message = '', autoClose = true, duration = 4000 } = {}) {
    const container = document.getElementById('toast-container');
    if (!container) {
        console.warn('showToast: elemen #toast-container tidak ditemukan di halaman.');
        return;
    }

    const styles = {
        success: 'border-emerald-500 text-emerald-700 dark:text-emerald-300',
        danger: 'border-red-500 text-red-700 dark:text-red-300',
        warning: 'border-yellow-500 text-yellow-700 dark:text-yellow-300',
        info: 'border-indigo-500 text-indigo-700 dark:text-indigo-300',
    };

    const toast = document.createElement('div');
    toast.setAttribute('data-toast', '');
    toast.setAttribute('role', 'alert');
    toast.className = `flex items-center gap-3 rounded-lg border-l-4 bg-white dark:bg-gray-800 px-4 py-3 shadow-lg w-full sm:w-80 ${styles[type] || styles.info}`;
    toast.innerHTML = `
        <div class="flex-1 text-sm text-gray-700 dark:text-gray-200"></div>
        <button type="button" data-dismiss="toast" class="rounded-md p-1 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700" aria-label="Tutup">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    toast.querySelector('div').textContent = message;

    container.appendChild(toast);

    if (autoClose) {
        setTimeout(() => dismissToast(toast), duration);
    }
}

// Tombol dismiss manual (dipakai oleh toast maupun alert)
document.addEventListener('click', function (event) {
    const dismissBtn = event.target.closest('[data-dismiss="toast"]');
    if (dismissBtn) {
        dismissToast(dismissBtn.closest('[data-toast]'));
        return;
    }

    const alertDismissBtn = event.target.closest('[data-dismiss="alert"]');
    if (alertDismissBtn) {
        const alertEl = alertDismissBtn.closest('[data-alert]');
        if (alertEl) {
            alertEl.style.transition = 'opacity 200ms ease';
            alertEl.style.opacity = '0';
            setTimeout(() => alertEl.remove(), 200);
        }
    }
});

document.addEventListener('DOMContentLoaded', initStaticToasts);
// Ekspos agar bisa dipakai ulang bila toast baru disisipkan lewat AJAX
window.showToast = showToast;
window.initStaticToasts = initStaticToasts;
