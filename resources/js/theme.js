/**
 * theme.js
 * Mengelola toggle dark mode dan menyimpan preferensinya di localStorage.
 *
 * Cara pakai — taruh tombol ini di mana saja (navbar, sidebar, dll):
 *
 *   <button data-theme-toggle aria-label="Ganti tema">
 *       <i class="bi bi-moon-stars-fill" data-theme-icon-dark></i>
 *       <i class="bi bi-sun-fill hidden" data-theme-icon-light></i>
 *   </button>
 *
 * PENTING: script inisialisasi tema (menghindari "flash" warna salah saat
 * halaman pertama kali dimuat) HARUS ditaruh inline di <head>, SEBELUM
 * @vite/CSS dimuat — karena fungsi applyStoredTheme() di bawah baru jalan
 * setelah components.js selesai di-load lewat Vite (lebih lambat dari render
 * pertama). Salin blok berikut ke <head> layout kamu:
 *
 *   <script>
 *     (function () {
 *       const stored = localStorage.getItem('theme');
 *       const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
 *       if (stored === 'dark' || (!stored && prefersDark)) {
 *         document.documentElement.classList.add('dark');
 *       }
 *     })();
 *   </script>
 *
 * Selain itu, Tailwind v4 butuh baris berikut di resources/css/app.css agar
 * dark: dibaca dari class ".dark" (bukan preferensi sistem browser):
 *
 *   @import "tailwindcss";
 *   @custom-variant dark (&:where(.dark, .dark *));
 */

function setTheme(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateThemeIcons(isDark);
}

function updateThemeIcons(isDark) {
    document.querySelectorAll('[data-theme-icon-dark]').forEach((icon) => {
        icon.classList.toggle('hidden', isDark);
    });
    document.querySelectorAll('[data-theme-icon-light]').forEach((icon) => {
        icon.classList.toggle('hidden', !isDark);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Sinkronkan ikon dengan state yang sudah diterapkan oleh script inline di <head>
    updateThemeIcons(document.documentElement.classList.contains('dark'));
});

document.addEventListener('click', function (event) {
    const toggle = event.target.closest('[data-theme-toggle]');
    if (!toggle) return;

    const isDark = document.documentElement.classList.contains('dark');
    setTheme(!isDark);
});
