/**
 * components.js
 * Titik masuk (entry point) tunggal untuk seluruh interaksi UI Component Library.
 *
 * Cara pakai:
 * 1) Jika pakai Vite (bawaan Laravel 13), import file ini di resources/js/app.js:
 *
 *      import './components.js';
 *
 * 2) Atau jika ingin tanpa build tool, muat langsung di layout dengan urutan berikut
 *    sebelum tag </body> (pakai <script defer src="...">):
 *
 *      modal.js, dropdown.js, accordion.js, tabs.js,
 *      navbar.js, sidebar.js, offcanvas.js, toast.js, theme.js
 *
 * Semua file di atas bekerja mandiri (self-executing, memasang event listener
 * sendiri) sehingga cukup di-import sekali saja di sini.
 *
 * Khusus dark mode (theme.js): tetap perlu SATU script inline tambahan di
 * <head> layout untuk menghindari "flash" warna salah saat halaman pertama
 * kali dimuat — lihat komentar di bagian atas resources/js/theme.js.
 */

import "./modal.js";
import "./dropdown.js";
import "./accordion.js";
import "./tabs.js";
import "./navbar.js";
import "./sidebar.js";
import "./offcanvas.js";
import "./toast.js";
import "./theme.js";
import "./alert.js";
