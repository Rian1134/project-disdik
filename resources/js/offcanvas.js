/**
 * offcanvas.js
 * Mengelola buka/tutup panel offcanvas dari sisi layar.
 *
 * Tombol pemicu:
 * - <button data-offcanvas-open="idPanel">Buka</button>
 * - <button data-offcanvas-close>Tutup</button> (di dalam panel)
 */

function openOffcanvas(id) {
    const panel = document.getElementById(id);
    if (!panel) return;

    panel.classList.remove('hidden');
    panel.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');

    // Trigger reflow lalu geser panel masuk (untuk animasi transisi)
    requestAnimationFrame(() => {
        const inner = panel.querySelector('[data-offcanvas-panel]');
        inner?.classList.remove('-translate-x-full', 'translate-x-full');
    });
}

function closeOffcanvas(panelEl) {
    if (!panelEl) return;
    const inner = panelEl.querySelector('[data-offcanvas-panel]');
    const isStart = inner?.classList.contains('left-0');

    inner?.classList.add(isStart ? '-translate-x-full' : 'translate-x-full');

    setTimeout(() => {
        panelEl.classList.add('hidden');
        panelEl.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }, 300);
}

document.addEventListener('click', function (event) {
    const openTrigger = event.target.closest('[data-offcanvas-open]');
    if (openTrigger) {
        openOffcanvas(openTrigger.getAttribute('data-offcanvas-open'));
        return;
    }

    const closeTrigger = event.target.closest('[data-offcanvas-close]');
    if (closeTrigger) {
        closeOffcanvas(closeTrigger.closest('[data-offcanvas]'));
        return;
    }

    const backdrop = event.target.closest('[data-offcanvas-backdrop]');
    if (backdrop) {
        closeOffcanvas(backdrop.closest('[data-offcanvas]'));
    }
});
