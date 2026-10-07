/**
 * alert.js
 * Auto-dismiss untuk komponen <x-alert>.
 *
 * Cara pakai (lihat resources/views/components/alert.blade.php):
 *   <x-alert type="success" :auto-dismiss="5000">Data berhasil disimpan.</x-alert>
 *
 * File ini TIDAK menutup alert secara langsung (mis. classList.add('hidden')).
 * Sebagai gantinya, setelah waktu yang ditentukan habis, ia men-trigger klik
 * pada tombol close bawaan alert (`[data-dismiss="alert"]`) — supaya animasi
 * & logic tutup-nya tetap satu sumber kebenaran di resources/js/components.js,
 * tidak dobel-duplikat di sini.
 */

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-alert-auto-dismiss]').forEach(function (alertEl) {
        const durasi = parseInt(alertEl.getAttribute('data-alert-auto-dismiss'), 10);
        if (!durasi || durasi <= 0) {
            return;
        }

        setTimeout(function () {
            // Kalau user sudah menutupnya sendiri duluan (elemen sudah
            // dilepas dari DOM), tidak usah ngapa-ngapain lagi
            if (!document.body.contains(alertEl)) {
                return;
            }

            const closeBtn = alertEl.querySelector('[data-dismiss="alert"]');
            if (closeBtn) {
                closeBtn.click();
            } else {
                // Jaga-jaga kalau alert auto-dismiss tapi ternyata tidak
                // punya tombol close (seharusnya tidak terjadi karena
                // alert.blade.php otomatis set dismissible saat autoDismiss
                // diisi) — langsung sembunyikan saja sebagai fallback.
                alertEl.remove();
            }
        }, durasi);
    });
});