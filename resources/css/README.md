# Laravel + Tailwind UI Component Library

Dokumentasi ini merangkum seluruh komponen di dalam UI Component Library berbasis **Laravel Blade Component + Tailwind CSS + Vanilla JS (ES6)**. Library ini dibuat sebagai pengganti Bootstrap — **tidak menggunakan Bootstrap, Alpine.js, Flowbite, DaisyUI, atau framework JS lain**. Semua interaktivitas (accordion, dropdown, modal, dsb) ditangani lewat atribut `data-*` yang dibaca oleh file JS vanilla di `resources/js/*.js` (mis. `components.js`, `alert.js`, `sidebar.js`, `offcanvas.js`, `toast.js`).

Gunakan dokumen ini sebagai referensi lengkap ketika meminta bantuan AI lain untuk membuat halaman/fitur baru — **tanpa perlu melampirkan file Blade aslinya**.

---

## Struktur Direktori Komponen

```
resources/views/components/
├── accordion.blade.php
├── accordion/
│   └── item.blade.php
├── alert.blade.php
├── avatar.blade.php
├── badge.blade.php
├── breadcrumb.blade.php
├── button.blade.php
├── card.blade.php
├── dropdown.blade.php          (versi trigger-slot)
├── dropdown/
│   ├── index.blade.php         (versi align+width, dipakai sbg <x-dropdown>)
│   └── item.blade.php          (<x-dropdown.item>)
├── list-group.blade.php
├── modal.blade.php
├── navbar.blade.php
├── offcanvas.blade.php
├── pagination.blade.php
├── progress.blade.php
├── sidebar.blade.php
├── spinner.blade.php
├── table.blade.php
├── table/
│   ├── cell.blade.php
│   ├── empty.blade.php
│   ├── heading.blade.php
│   └── row.blade.php
├── tabs.blade.php
├── tabs/
│   ├── link.blade.php
│   └── pane.blade.php
├── toast.blade.php
└── form/
    ├── checkbox.blade.php
    ├── input.blade.php
    ├── radio.blade.php
    ├── select.blade.php
    ├── switch.blade.php
    └── textarea.blade.php
```

> **Catatan penting soal Dropdown:** ada dua implementasi dropdown di library ini yang mirip tapi tidak identik:
> - `dropdown.blade.php` — dipanggil `<x-dropdown>`, memakai slot bernama `trigger` + prop `align` (left/right), isi menu bebas (link/button manual atau `<x-dropdown.item>`).
> - `dropdown/index.blade.php` — juga `<x-dropdown>` (nama file `index.blade.php` di subfolder `dropdown/`), memakai slot `trigger` juga tapi dengan prop `align` + `width` (xs–xl), dan struktur class sedikit berbeda (`data-align` di root, padding menu `py-1`).
>
> Kedua file punya nama komponen yang sama (`<x-dropdown>`) — di proyek nyata Laravel hanya akan me-resolve salah satu (tergantung mana yang benar-benar ada di path `resources/views/components/dropdown.blade.php` vs `resources/views/components/dropdown/index.blade.php`, keduanya tidak bisa hidup berdampingan dengan nama yang sama). Saat meminta bantuan AI lain, sebutkan versi mana yang dipakai di proyekmu.

---

## Konvensi Umum

- Semua komponen menerima **atribut HTML tambahan** via `{{ $attributes->class([...]) }}` atau `->merge([...])` — jadi bisa ditambah `class="..."` custom saat pemanggilan.
- Komponen form (`x-form.*`) otomatis membaca `old($name)` dan `$errors->first($name)` (validasi standar Laravel) — menampilkan pesan error merah otomatis kalau field gagal validasi, dan mempertahankan input lama setelah redirect.
- Dark mode didukung penuh lewat class `dark:` Tailwind di semua komponen.
- Komponen yang butuh interaktivitas JS memakai atribut `data-*` (bukan `x-data` Alpine), contoh: `data-modal`, `data-dropdown`, `data-accordion`, `data-tabs`, `data-sidebar`, `data-offcanvas`, `data-toast`, `data-alert`.

---

## Daftar Komponen

### 1. Accordion — `<x-accordion>` + `<x-accordion.item>`
Wadah panel yang bisa dibuka/tutup.
- **`x-accordion`** props: `id` (wajib), `multiple` (bool, default `false` = hanya 1 panel terbuka).
- **`x-accordion.item`** props: `title` (string), `open` (bool, default `false`).
```blade
<x-accordion id="faqAccordion">
    <x-accordion.item title="Apa itu Laravel?" open>Laravel adalah framework PHP.</x-accordion.item>
    <x-accordion.item title="Apakah gratis?">Ya, open source dan gratis.</x-accordion.item>
</x-accordion>
```

### 2. Alert — `<x-alert>`
Pesan notifikasi statis di halaman.
- Props: `type` (primary/success/warning/danger/info, default `info`), `dismissible` (bool), `icon` (bool, default `true`), `autoDismiss` (int ms, opsional — otomatis membuat alert dismissible).
```blade
<x-alert type="success" dismissible>Data berhasil disimpan.</x-alert>
<x-alert type="danger" :auto-dismiss="5000">Terjadi kesalahan.</x-alert>
```

### 3. Avatar — `<x-avatar>`
Foto profil atau inisial nama.
- Props: `src` (url, opsional), `name` (untuk generate inisial jika `src` kosong), `size` (xs/sm/md/lg/xl, default `md`), `status` (online/offline/busy/away, opsional), `rounded` (full/md, default `full`).
```blade
<x-avatar src="/img/user.jpg" size="lg" status="online" />
<x-avatar name="Budi Santoso" size="md" />
```

### 4. Badge — `<x-badge>`
Label kecil untuk status/jumlah/kategori.
- Props: `variant` (primary/secondary/success/danger/warning/info/dark/light, default `primary`), `pill` (bool), `outline` (bool).
```blade
<x-badge variant="success">Aktif</x-badge>
<x-badge variant="danger" pill>99+</x-badge>
```

### 5. Breadcrumb — `<x-breadcrumb>`
Jejak navigasi halaman.
- Props: `items` (array `['label' => ..., 'url' => ...]`; item terakhir tanpa `url` = halaman aktif).
```blade
<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => '/'],
    ['label' => 'Pengguna', 'url' => '/users'],
    ['label' => 'Detail'],
]" />
```

### 6. Button — `<x-button>`
Tombol aksi (`<button>`) atau navigasi (`<a>` jika `href` diisi).
- Props: `variant` (primary/secondary/success/danger/warning/info/dark/light/outline-*/link, default `primary`), `size` (xs/sm/md/lg/xl, default `md`), `type` (submit/button/reset, diabaikan jika `href` diisi), `href` (render sebagai `<a>`), `disabled` (bool — selalu jadi `<button disabled>` walau `href` diisi), `loading` (bool, auto-disable + spinner), `active` (bool, tandai `data-active`), `fullWidth` (bool), `icon` (string HTML mentah, tampil di kiri teks).
```blade
<x-button type="submit" variant="primary">Simpan</x-button>
<x-button href="{{ route('user.show', $item->id) }}" variant="info" size="xs">
    <i class="bi bi-eye-fill"></i>
</x-button>
<x-button variant="danger" loading>Menghapus...</x-button>
```

### 7. Card — `<x-card>`
Kontainer konten dengan header/body/footer opsional.
- Slot: `header` (opsional), `footer` (opsional), `$slot` (body).
```blade
<x-card>
    <x-slot:header>Judul Card</x-slot:header>
    Isi konten card.
    <x-slot:footer><x-button size="sm">Aksi</x-button></x-slot:footer>
</x-card>
```

### 8. Dropdown — `<x-dropdown>` (+ `<x-dropdown.item>`)
Menu melayang dari tombol pemicu.
- Props: `align` (left/right, default `left`); versi `dropdown/index.blade.php` menambah `width` (auto/xs/sm/md/lg/xl).
- Slot: `trigger` (elemen pemicu, biasanya `<x-button>`), `$slot` (isi menu).
- `<x-dropdown.item>` props: `danger` (bool), `type` (button/link, default `button`).
```blade
<x-dropdown align="right">
    <x-slot:trigger><x-button variant="light">Opsi</x-button></x-slot:trigger>
    <x-dropdown.item>Edit</x-dropdown.item>
    <x-dropdown.item>Duplikat</x-dropdown.item>
    <x-dropdown.item danger>Hapus</x-dropdown.item>
</x-dropdown>
```

### 9. List Group — `<x-list-group>`
Daftar item vertikal dalam kotak (tidak ada props, isi manual dengan class `list-group-item` / `active`).
```blade
<x-list-group>
    <a href="#" class="list-group-item active">Item Aktif</a>
    <a href="#" class="list-group-item">Item Biasa</a>
</x-list-group>
```

### 10. Modal — `<x-modal>`
Dialog overlay. Dibuka/ditutup via JS (`data-modal`, `data-modal-close`).
- Props: `id`, `size` (sm–5xl, default `md`), `centered` (bool), `scrollable` (bool).
- Slot: `header` (opsional, ada tombol close otomatis), `footer` (opsional), `$slot` (body).
```blade
<x-modal id="confirmModal" size="lg" centered>
    <x-slot:header>Konfirmasi</x-slot:header>
    Yakin ingin menghapus data ini?
    <x-slot:footer>
        <x-button variant="light" data-modal-close>Batal</x-button>
        <x-button variant="danger">Hapus</x-button>
    </x-slot:footer>
</x-modal>
```

### 11. Navbar — `<x-navbar>`
Header navigasi responsif (desktop menu + mobile collapse).
- Props: `fixed` (bool, posisi fixed di atas).
- Slot: `brand`, `menu` (opsional), `actions` (opsional).
```blade
<x-navbar fixed>
    <x-slot:brand><a href="/">MyApp</a></x-slot:brand>
    <x-slot:menu><a href="/dashboard">Dashboard</a></x-slot:menu>
    <x-slot:actions><x-button size="sm">Login</x-button></x-slot:actions>
</x-navbar>
```

### 12. Offcanvas — `<x-offcanvas>`
Panel drawer dari sisi layar. Dibuka via `data-offcanvas-open="{id}"`.
- Props: `id` (wajib), `placement` (start/end, default `end`).
- Slot: `header` (opsional), `$slot` (isi).
```blade
<button data-offcanvas-open="filterPanel">Buka Filter</button>
<x-offcanvas id="filterPanel" placement="end">
    <x-slot:header>Filter Produk</x-slot:header>
    Isi form filter di sini.
</x-offcanvas>
```

### 13. Pagination — `<x-pagination>`
Navigasi halaman untuk `LengthAwarePaginator` Laravel.
- Props: `paginator` (wajib, instance paginator).
```blade
<x-pagination :paginator="$users" />
```

### 14. Progress — `<x-progress>`
Progress bar.
- Props: `value` (0–100, default `0`), `variant` (primary/success/danger/warning/info), `striped` (bool), `animated` (bool, butuh `striped`), `label` (bool, tampilkan %).
```blade
<x-progress :value="65" variant="success" label />
```

### 15. Sidebar — `<x-sidebar>`
Navigasi samping, drawer di mobile, bisa collapse (icon-only) di desktop.
- Props: `id` (wajib), `collapsed` (bool default `false`), `toggle` (bool, tampilkan tombol collapse, default `true`).
- Isi: link dengan class `sidebar-link`, teks dibungkus `<span data-sidebar-label>` agar hilang saat collapse.
```blade
<x-sidebar id="mainSidebar">
    <a href="/dashboard" class="sidebar-link active">
        <svg class="h-5 w-5 shrink-0">...</svg>
        <span data-sidebar-label>Dashboard</span>
    </a>
</x-sidebar>
```

### 16. Spinner — `<x-spinner>`
Indikator loading berputar.
- Props: `size` (xs/sm/md/lg/xl), `color` (primary/secondary/success/danger/warning/info/light/dark).
```blade
<x-spinner size="lg" color="primary" />
```

### 17. Table — `<x-table>` (+ `.row`, `.cell`, `.heading`, `.empty`)
Tabel data responsif (scroll horizontal otomatis), mendukung header berlapis (rowspan/colspan) dan tfoot.
- **`x-table`** props: `striped` (bool), `hover` (bool, default `true`), `bordered` (bool).
- Slot: `head` (isi `<thead>`, tulis `<tr>` sendiri), `$slot` (isi `<tbody>`), `foot` (opsional, isi `<tfoot>`).
- **`x-table.heading`** = `<th>`. **`x-table.row`** = `<tr>`. **`x-table.cell`** = `<td>`. **`x-table.empty`** props: `colspan` (wajib), `message` (default "Belum ada data.") — dipakai sebagai satu-satunya baris saat data kosong.
```blade
<x-table striped hover>
    <x-slot:head>
        <tr>
            <x-table.heading>Nama</x-table.heading>
            <x-table.heading>Email</x-table.heading>
            <x-table.heading class="text-right">Aksi</x-table.heading>
        </tr>
    </x-slot:head>
    @forelse($users as $user)
        <x-table.row>
            <x-table.cell>{{ $user->name }}</x-table.cell>
            <x-table.cell>{{ $user->email }}</x-table.cell>
            <x-table.cell class="text-right"><x-button size="xs">Edit</x-button></x-table.cell>
        </x-table.row>
    @empty
        <x-table.empty colspan="3" />
    @endforelse
</x-table>
<x-pagination :paginator="$users" class="mt-4" />
```

### 18. Tabs — `<x-tabs>` (+ `.link`, `.pane`)
Navigasi antar konten, horizontal/vertikal.
- **`x-tabs`** props: `id` (wajib), `orientation` (horizontal/vertical, default `horizontal`).
- Slot: `nav` (kumpulan `<x-tabs.link>`), `$slot` (kumpulan `<x-tabs.pane>`).
- **`x-tabs.link`** props: `target` (wajib, harus sama dengan id pane), `active` (bool).
- **`x-tabs.pane`** props: `id` (wajib), `active` (bool).
```blade
<x-tabs id="profileTabs">
    <x-slot:nav>
        <x-tabs.link target="tab-akun" active>Akun</x-tabs.link>
        <x-tabs.link target="tab-keamanan">Keamanan</x-tabs.link>
    </x-slot:nav>
    <x-tabs.pane id="tab-akun" active>Konten akun...</x-tabs.pane>
    <x-tabs.pane id="tab-keamanan">Konten keamanan...</x-tabs.pane>
</x-tabs>
```

### 19. Toast — `<x-toast>`
Notifikasi sementara di pojok layar. Untuk pemicu dinamis dari JS gunakan `showToast({ type, message })` di `resources/js/toast.js`. Wajib ada `<div id="toast-container">` sekali di layout utama.
- Props: `type` (success/danger/warning/info, default `info`), `autoClose` (bool, default `true`), `duration` (ms, default `4000`).
```blade
<x-toast type="success">Data berhasil disimpan!</x-toast>
```

### 20. Form Components — `<x-form.*>`
Semua komponen form otomatis terintegrasi dengan `old()` dan `$errors` Laravel.

| Komponen | Props utama |
|---|---|
| `x-form.input` | `name` (wajib), `label`, `type` (default `text`), `helper`, `required`, `disabled`, `readonly`; slot `prefix`/`suffix` |
| `x-form.textarea` | `name` (wajib), `label`, `rows` (default `4`), `helper`, `required`, `disabled` |
| `x-form.select` | `name` (wajib), `label`, `options` (array asosiatif), `placeholder`, `helper`, `required`, `disabled` |
| `x-form.checkbox` | `name` (wajib), `label`, `value` (default `"1"`), `checked`, `helper`, `disabled` |
| `x-form.radio` | `name` (wajib), `value` (wajib), `label`, `checked`, `disabled` — beberapa radio dengan `name` sama = satu grup |
| `x-form.switch` | `name` (wajib), `label`, `value` (default `"1"`), `checked`, `disabled` |

```blade
<x-form.input name="email" label="Email" type="email" required placeholder="nama@email.com" />
<x-form.input name="harga" label="Harga" helper="Masukkan tanpa titik">
    <x-slot:prefix>Rp</x-slot:prefix>
</x-form.input>
<x-form.select name="kota" label="Kota" placeholder="Pilih kota" :options="['jkt' => 'Jakarta', 'bdg' => 'Bandung']" />
<x-form.checkbox name="setuju" label="Saya menyetujui syarat & ketentuan" required />
<x-form.radio name="gender" value="L" label="Laki-laki" checked />
<x-form.radio name="gender" value="P" label="Perempuan" />
<x-form.switch name="notifikasi" label="Aktifkan Notifikasi" checked />
<x-form.textarea name="deskripsi" label="Deskripsi" rows="5" />
```

---

## Ketergantungan JavaScript

Komponen berikut butuh handler JS vanilla (bukan Alpine/Bootstrap) yang membaca atribut `data-*`-nya masing-masing — pastikan file JS terkait sudah di-load di layout:
- `data-accordion` / `data-accordion-item` / `data-accordion-trigger`
- `data-dropdown` / `data-dropdown-trigger` / `data-dropdown-menu`
- `data-modal` / `data-modal-close`
- `data-offcanvas` / `data-offcanvas-open` / `data-offcanvas-close`
- `data-sidebar` / `data-sidebar-open` / `data-sidebar-close` / `data-sidebar-collapse-toggle`
- `data-tabs` / `data-tabs-link` / `data-tabs-pane`
- `data-alert` / `data-dismiss="alert"` / `data-alert-auto-dismiss`
- `data-toast` / `data-dismiss="toast"` / fungsi global `showToast()`
- `data-navbar` / `data-navbar-menu` (toggle menu mobile)
- `data-table-striped` / `data-table-hover` (styling via CSS selector, bukan JS)

---

## Cara Pakai Dokumen Ini

Salin seluruh isi file ini (atau cukup bagian komponen yang relevan) ke AI lain sebagai konteks, lalu minta AI tersebut membuat halaman/fitur baru dengan memakai komponen `<x-...>` di atas — tanpa perlu melampirkan file `.blade.php` aslinya satu per satu.
