{{--
    Komponen input foto profil.
    Pakai: <x-foto-upload /> (form tambah) atau <x-foto-upload :user="$user" /> (form edit)

    Field yang dikirim ke server:
      - foto        : file gambar baru (opsional)
      - hapus_foto  : "1" jika foto lama ingin dihapus (hanya ada di form edit)
--}}
@props(['user' => null])

@php
    $uid = 'foto-' . \Illuminate\Support\Str::random(6);
    $punyaFoto = (bool) $user?->foto;

    // Placeholder siluet abu-abu (SVG inline) bila belum ada foto.
    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96"><rect width="96" height="96" fill="#e5e7eb"/><circle cx="48" cy="36" r="17" fill="#9ca3af"/><path d="M14 96c0-20 15-32 34-32s34 12 34 32z" fill="#9ca3af"/></svg>'
    );

    $fotoAwal = $punyaFoto ? $user->foto_url : $placeholder;
    $hapusAwal = $punyaFoto && old('hapus_foto') ? '1' : '0';
@endphp

<div id="{{ $uid }}"
     class="col-span-full flex flex-col items-center gap-4 text-center"
     data-punya-foto="{{ $punyaFoto ? '1' : '0' }}"
     data-max-mb="2">

    {{-- Area avatar: klik atau seret foto ke sini --}}
    <div data-zone
         role="button"
         tabindex="0"
         aria-label="Pilih foto profil"
         class="group relative h-36 w-36 cursor-pointer rounded-full outline-none focus-visible:ring-4 focus-visible:ring-gray-400/60">
        <img data-preview
             src="{{ $fotoAwal }}"
             data-awal="{{ $fotoAwal }}"
             data-placeholder="{{ $placeholder }}"
             alt="Pratinjau foto profil"
             class="h-full w-full rounded-full object-cover shadow-md ring-4 ring-white transition group-data-[drag=true]:scale-105 group-data-[drag=true]:ring-gray-400 dark:ring-gray-800">

        {{-- Lapisan saat kursor di atas avatar --}}
        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center gap-1 rounded-full bg-black/55 text-white opacity-0 transition group-hover:opacity-100 group-focus-visible:opacity-100 group-data-[drag=true]:opacity-100">
            <i class="bi bi-camera text-2xl"></i>
            <span class="text-xs font-medium">Ganti logo</span>
        </div>

        {{-- Tanda kamera di pojok --}}
        <span class="pointer-events-none absolute bottom-1 right-1 flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 text-white shadow ring-2 ring-white dark:bg-gray-100 dark:text-gray-900 dark:ring-gray-800">
            <i class="bi bi-camera-fill text-sm"></i>
        </span>
    </div>

    <input type="file"
           name="foto"
           data-input
           accept="image/png,image/jpeg,image/webp"
           class="sr-only"
           tabindex="-1">

    @if ($punyaFoto)
        <input type="hidden" name="hapus_foto" value="{{ $hapusAwal }}" data-hapus>
    @endif

    {{-- Tombol aksi (yang tampil berubah sesuai keadaan) --}}
    <div class="flex flex-wrap items-center justify-center gap-2">
        <button type="button" data-pick
                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
            <i class="bi bi-upload"></i> <span data-pick-label>Pilih logo</span>
        </button>

        <button type="button" data-cancel hidden
                class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="bi bi-arrow-counterclockwise"></i> Batalkan pilihan
        </button>

        @if ($punyaFoto)
            <button type="button" data-remove hidden
                    class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400 dark:text-red-400 dark:hover:bg-red-950/40">
                <i class="bi bi-trash3"></i> Hapus logo
            </button>

            <button type="button" data-undo-remove hidden
                    class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 dark:text-gray-300 dark:hover:bg-gray-700">
                <i class="bi bi-arrow-counterclockwise"></i> Batal hapus
            </button>
        @endif
    </div>

    <p data-status class="min-h-5 text-sm text-gray-600 dark:text-gray-300" aria-live="polite"></p>

    <p class="max-w-56 text-xs leading-relaxed text-gray-500 dark:text-gray-400">
        JPG, PNG, atau WebP, maksimal 2 MB. Foto dipotong persegi dan disimpan sebagai WebP 400 x 400 px.
    </p>

    <p data-error class="hidden max-w-56 text-sm text-red-600 dark:text-red-400" role="alert"></p>

    @error('foto')
        <p class="max-w-56 text-sm text-red-600 dark:text-red-400" role="alert">{{ $message }}</p>
    @enderror
</div>

<script>
    (function () {
        const root = document.getElementById(@json($uid));
        if (!root) return;

        const zone = root.querySelector('[data-zone]');
        const input = root.querySelector('[data-input]');
        const img = root.querySelector('[data-preview]');
        const hapus = root.querySelector('[data-hapus]');
        const btnPick = root.querySelector('[data-pick]');
        const pickLabel = root.querySelector('[data-pick-label]');
        const btnCancel = root.querySelector('[data-cancel]');
        const btnRemove = root.querySelector('[data-remove]');
        const btnUndo = root.querySelector('[data-undo-remove]');
        const status = root.querySelector('[data-status]');
        const errorBox = root.querySelector('[data-error]');

        const punyaFoto = root.dataset.punyaFoto === '1';
        const maxBytes = parseInt(root.dataset.maxMb, 10) * 1024 * 1024;
        const tipeBoleh = ['image/jpeg', 'image/png', 'image/webp'];
        let objectUrl = null;

        function tampilkanError(pesan) {
            errorBox.textContent = pesan;
            errorBox.classList.toggle('hidden', !pesan);
        }

        function lepasObjectUrl() {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        }

        function ukuranTeks(bytes) {
            return bytes >= 1048576
                ? (bytes / 1048576).toFixed(1) + ' MB'
                : Math.round(bytes / 1024) + ' KB';
        }

        // Tiga keadaan: default, ada file baru, atau foto lama akan dihapus.
        function atur(keadaan, file) {
            const baru = keadaan === 'baru';
            const hapusFoto = keadaan === 'hapus';

            btnCancel.hidden = !baru;
            if (btnRemove) btnRemove.hidden = baru || hapusFoto || !punyaFoto;
            if (btnUndo) btnUndo.hidden = !hapusFoto;
            if (hapus) hapus.value = hapusFoto ? '1' : '0';

            pickLabel.textContent = baru ? 'Pilih logo lain' : (punyaFoto && !hapusFoto ? 'Ganti logo' : 'Pilih logo');

            if (baru) {
                lepasObjectUrl();
                objectUrl = URL.createObjectURL(file);
                img.src = objectUrl;
                status.textContent = file.name + ' (' + ukuranTeks(file.size) + ')';
            } else if (hapusFoto) {
                lepasObjectUrl();
                img.src = img.dataset.placeholder;
                status.textContent = 'logo akan dihapus saat Anda menyimpan.';
            } else {
                lepasObjectUrl();
                img.src = img.dataset.awal;
                status.textContent = '';
            }
        }

        function tanganiFile(file) {
            tampilkanError('');

            if (!file) return;

            if (!tipeBoleh.includes(file.type)) {
                input.value = '';
                tampilkanError('Format logo harus JPG, PNG, atau WebP.');
                return;
            }
            if (file.size > maxBytes) {
                input.value = '';
                tampilkanError('Ukuran logo ' + ukuranTeks(file.size) + ' melebihi batas 2 MB.');
                return;
            }
            atur('baru', file);
        }

        // Pilih lewat dialog file
        input.addEventListener('change', () => tanganiFile(input.files[0]));
        btnPick.addEventListener('click', () => input.click());
        zone.addEventListener('click', () => input.click());
        zone.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                input.click();
            }
        });

        // Seret & lepas
        ['dragenter', 'dragover'].forEach((nama) =>
            zone.addEventListener(nama, (e) => {
                e.preventDefault();
                zone.dataset.drag = 'true';
            })
        );
        ['dragleave', 'drop'].forEach((nama) =>
            zone.addEventListener(nama, (e) => {
                e.preventDefault();
                zone.dataset.drag = 'false';
            })
        );
        zone.addEventListener('drop', (e) => {
            const file = e.dataTransfer.files[0];
            if (!file) return;
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            tanganiFile(file);
        });

        // Tombol aksi
        btnCancel.addEventListener('click', () => {
            input.value = '';
            tampilkanError('');
            atur('default');
        });
        if (btnRemove) {
            btnRemove.addEventListener('click', () => {
                input.value = '';
                tampilkanError('');
                atur('hapus');
            });
        }
        if (btnUndo) {
            btnUndo.addEventListener('click', () => atur('default'));
        }

        // Keadaan awal (mis. setelah validasi gagal dan checkbox hapus sempat dicentang)
        atur(hapus && hapus.value === '1' ? 'hapus' : 'default');
    })();
</script>