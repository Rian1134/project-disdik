/**
 * sidebar.js
 * Mengelola sidebar sebagai drawer di layar mobile, dan mode collapse (icon-only) di desktop.
 *
 * Tombol pemicu:
 * - <button data-sidebar-open="idSidebar">Buka</button>              (mobile drawer)
 * - <button data-sidebar-close="idSidebar">Tutup</button>            (otomatis ada di dalam komponen)
 * - <button data-sidebar-collapse-toggle="idSidebar">Ciutkan</button> (otomatis ada di dalam komponen, desktop)
 */

function openSidebar(id) {
    const sidebar = document.getElementById(id);
    const backdrop = document.querySelector(`[data-sidebar-backdrop="${id}"]`);
    if (!sidebar) return;

    sidebar.classList.remove('-translate-x-full');
    backdrop?.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeSidebar(id) {
    const sidebar = document.getElementById(id);
    const backdrop = document.querySelector(`[data-sidebar-backdrop="${id}"]`);
    if (!sidebar) return;

    sidebar.classList.add('-translate-x-full');
    backdrop?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

/**
 * Sinkronkan visibilitas label menu ("data-sidebar-label") sesuai kondisi
 * SEKARANG: mode collapse itu HANYA berlaku untuk layar desktop (>=640px).
 * Di layar mobile (drawer), label HARUS selalu tampil apapun status
 * collapsed-nya di desktop — makanya visibilitasnya dihitung ulang tiap kali,
 * bukan cuma di-toggle sekali saat tombol collapse diklik.
 */
function syncSidebarLabels(sidebar) {
    const isDesktop = window.innerWidth >= 640;
    const isCollapsed = sidebar.getAttribute('data-sidebar-collapsed') === 'true';
    const shouldHide = isDesktop && isCollapsed;

    sidebar.querySelectorAll('[data-sidebar-label]').forEach((label) => {
        label.classList.toggle('hidden', shouldHide);
    });
}

function syncAllSidebarLabels() {
    document.querySelectorAll('[data-sidebar]').forEach(syncSidebarLabels);
}

function toggleSidebarCollapse(id) {
    const sidebar = document.getElementById(id);
    if (!sidebar) return;

    const isCollapsed = sidebar.getAttribute('data-sidebar-collapsed') === 'true';
    const nextState = !isCollapsed;

    sidebar.classList.toggle('sm:w-16', nextState);
    sidebar.classList.toggle('sm:w-64', !nextState);
    sidebar.setAttribute('data-sidebar-collapsed', nextState ? 'true' : 'false');

    // Sembunyikan teks label menu (sisakan ikon saja) — TAPI cuma kalau
    // sedang di layar desktop, lihat syncSidebarLabels()
    syncSidebarLabels(sidebar);

    // Putar ikon panah toggle sebagai penanda arah
    const icon = sidebar.querySelector('[data-sidebar-collapse-icon]');
    icon?.classList.toggle('rotate-180', nextState);
}

document.addEventListener('click', function (event) {
    const openTrigger = event.target.closest('[data-sidebar-open]');
    if (openTrigger) {
        openSidebar(openTrigger.getAttribute('data-sidebar-open'));
        return;
    }

    const closeTrigger = event.target.closest('[data-sidebar-close]');
    if (closeTrigger) {
        closeSidebar(closeTrigger.getAttribute('data-sidebar-close'));
        return;
    }

    const collapseTrigger = event.target.closest('[data-sidebar-collapse-toggle]');
    if (collapseTrigger) {
        toggleSidebarCollapse(collapseTrigger.getAttribute('data-sidebar-collapse-toggle'));
        return;
    }

    const backdrop = event.target.closest('[data-sidebar-backdrop]');
    if (backdrop) {
        closeSidebar(backdrop.getAttribute('data-sidebar-backdrop'));
        return;
    }

    // Auto-close sidebar saat sebuah link menu diklik, khusus layar mobile (< 640px)
    const link = event.target.closest('[data-sidebar] a');
    if (link && window.innerWidth < 640) {
        const sidebar = link.closest('[data-sidebar]');
        if (sidebar) closeSidebar(sidebar.id);
    }
});

// Saat layar di-resize melewati breakpoint desktop (ke arah manapun), pastikan:
// 1. Drawer & backdrop mobile tertutup rapi begitu masuk ukuran desktop
// 2. Label menu disinkronkan ulang — FIX: sebelumnya fungsi ini berhenti total
//    kalau layar < 640px, jadi label yang kepenceng ke-hide (dari mode
//    collapse desktop) tidak pernah dikembalikan saat balik ke mobile.
window.addEventListener('resize', function () {
    if (window.innerWidth >= 640) {
        document.querySelectorAll('[data-sidebar]').forEach((sidebar) => {
            sidebar.classList.remove('-translate-x-full');
        });
        document.querySelectorAll('[data-sidebar-backdrop]').forEach((backdrop) => {
            backdrop.classList.add('hidden');
        });
        document.body.classList.remove('overflow-hidden');
    }

    syncAllSidebarLabels();
});

// Pastikan label sudah sinkron begitu halaman pertama kali dimuat juga
// (mis. kalau prop 'collapsed' di-set true dari server untuk desktop, tapi
// halaman dibuka pertama kali di HP)
document.addEventListener('DOMContentLoaded', syncAllSidebarLabels);