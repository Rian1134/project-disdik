<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMADIK</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/img/icon-web.webp') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Terapkan tema sebelum halaman dirender agar tidak berkedip (flash) --}}
    <script>
        (function() {
            try {
                var tersimpan = localStorage.getItem('theme');
                var gelap = tersimpan ? tersimpan === 'dark' : window.matchMedia('(prefers-color-scheme: dark)')
                    .matches;
                document.documentElement.classList.toggle('dark', gelap);
            } catch (e) {}
        })();
    </script>
    <style>
        :root {
            color-scheme: light;
        }

        :root.dark {
            color-scheme: dark;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 antialiased dark:bg-gray-900 dark:text-gray-100">
    <main class="grid min-h-dvh lg:grid-cols-2">

        {{-- ===== Panel merek (layar lebar): foto gedung + overlay biru ===== --}}
        <section class="relative isolate hidden flex-col justify-between overflow-hidden p-12 text-white lg:flex">
            <img src="{{ asset('assets/img/foto-disdik.webp') }}" alt="" aria-hidden="true"
                class="absolute inset-0 -z-20 h-full w-full object-cover object-[center_40%]">
            <div class="absolute inset-0 -z-10 bg-linear-to-b from-blue-950/80 via-blue-900/60 to-blue-950/90"></div>

            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white p-1.5 shadow-lg">
                    <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo Tut Wuri Handayani"
                        class="h-full w-full object-contain">
                </span>
                <span class="text-xl font-extrabold tracking-wide">SIMADIK</span>
            </a>

            <div class="max-w-md">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur">
                    <i class="bi bi-building"></i> Disdikbud Kabupaten Lahat
                </span>
                <h2 class="mt-4 text-3xl font-bold leading-tight drop-shadow">
                    Sistem Informasi Manajemen Akademik &amp; Pendidikan
                </h2>
                <p class="mt-3 text-blue-100">
                    Kelola data sekolah, siswa, dan pegawai dalam satu aplikasi yang sederhana dan terintegrasi.
                </p>
            </div>

            <p class="text-xs text-blue-200">&copy; {{ date('Y') }} SIMADIK. Seluruh hak cipta dilindungi.</p>
        </section>

        {{-- ===== Sisi form ===== --}}
        <section class="relative flex flex-col">

            {{-- Tombol ganti tema (di mobile berada di atas banner, jadi putih) --}}
            <button type="button" id="themeToggle" title="Ganti tema" aria-label="Ganti tema terang/gelap"
                class="absolute right-4 top-4 z-20 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white/15 text-white backdrop-blur transition hover:bg-white/25 lg:bg-transparent lg:text-gray-500 lg:backdrop-blur-none lg:hover:bg-blue-50 lg:hover:text-blue-600 dark:lg:text-gray-400 dark:lg:hover:bg-gray-800 dark:lg:hover:text-blue-300">
                <i class="bi bi-moon-stars dark:hidden"></i>
                <i class="bi bi-sun hidden dark:inline"></i>
            </button>

            {{-- Banner untuk layar kecil --}}
            <div class="relative isolate overflow-hidden text-center text-white lg:hidden">
                <img src="{{ asset('assets/img/foto-disdik.webp') }}" alt="" aria-hidden="true"
                    class="absolute inset-0 -z-20 h-full w-full object-cover object-[center_40%]">
                <div class="absolute inset-0 -z-10 bg-linear-to-b from-blue-950/75 via-blue-900/65 to-blue-950/90">
                </div>

                <div class="px-4 pb-20 pt-10 sm:pb-24 sm:pt-12">
                    <span
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white p-2 shadow-xl ring-4 ring-white/30">
                        <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo Tut Wuri Handayani"
                            class="h-full w-full object-contain">
                    </span>
                    <h1 class="mt-3 text-2xl font-extrabold tracking-wide drop-shadow">SIMADIK</h1>
                    <p class="mx-auto mt-1 max-w-xs text-xs text-blue-100 sm:text-sm">
                        Sistem Informasi Manajemen Akademik &amp; Pendidikan
                    </p>
                </div>
            </div>

            {{-- Konten form: di mobile kartu naik menimpa banner --}}
            <div
                class="relative z-10 -mt-12 flex flex-1 justify-center px-4 pb-8 sm:-mt-16 lg:mt-0 lg:items-center lg:p-8">
                <div class="w-full max-w-sm">

                    <div class="mb-6 hidden lg:block">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Selamat datang</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Silakan login untuk melanjutkan.</p>
                    </div>

                    {{-- Pesan sukses / error dari server (mis. setelah logout atau akun ditolak) --}}
                    @if (session('success'))
                        <x-alert type="success" dismissible class="mb-4">{{ session('success') }}</x-alert>
                    @endif
                    @if (session('error'))
                        <x-alert type="danger" dismissible class="mb-4">{{ session('error') }}</x-alert>
                    @endif

                    <x-card class="shadow-xl lg:shadow-md">
                        <div class="mb-4 text-center lg:hidden">
                            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Selamat datang</h2>
                            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Silakan login untuk melanjutkan.
                            </p>
                        </div>

                        <form id="formLogin" action="{{ route('login.store') }}" method="POST"
                            class="flex flex-col gap-4">
                            @csrf

                            <x-form.input name="email" label="Email" type="email" placeholder="nama@email.com"
                                autocomplete="username" inputmode="email" autofocus required />

                            {{-- Tombol mata memakai slot suffix milik x-form.input --}}
                            <x-form.input name="password" label="Password" type="password"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                                <x-slot:suffix>
                                    <button type="button" id="tombolMata" title="Tampilkan password"
                                        aria-label="Tampilkan password" aria-pressed="false"
                                        class="inline-flex items-center justify-center p-1 text-gray-500 transition hover:text-blue-600 focus:outline-none focus-visible:text-blue-600 dark:text-gray-400 dark:hover:text-blue-300">
                                        <i class="bi bi-eye text-lg"></i>
                                    </button>
                                </x-slot:suffix>
                            </x-form.input>

                            <x-button type="submit" id="tombolLogin" size="lg" full-width>
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </x-button>
                        </form>
                    </x-card>

                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-1 text-sm text-gray-500 transition hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-300">
                            <i class="bi bi-arrow-left"></i> Kembali ke beranda
                        </a>
                        <p class="mt-3 text-xs text-gray-400 dark:text-gray-600 lg:hidden">
                            &copy; {{ date('Y') }} SIMADIK
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Ganti tema terang/gelap
        document.getElementById('themeToggle')?.addEventListener('click', function() {
            var gelap = document.documentElement.classList.toggle('dark');
            try {
                localStorage.setItem('theme', gelap ? 'dark' : 'light');
            } catch (e) {}
        });

        // Tampilkan / sembunyikan password lewat tombol mata (slot suffix)
        (function() {
            var kolom = document.querySelector('#formLogin input[name="password"]');
            var tombol = document.getElementById('tombolMata');
            if (!kolom || !tombol) return;

            tombol.addEventListener('click', function() {
                var tampil = kolom.type === 'password';
                kolom.type = tampil ? 'text' : 'password';
                tombol.innerHTML = '<i class="bi ' + (tampil ? 'bi-eye-slash' : 'bi-eye') + ' text-lg"></i>';
                tombol.setAttribute('aria-pressed', tampil ? 'true' : 'false');
                var teks = tampil ? 'Sembunyikan password' : 'Tampilkan password';
                tombol.setAttribute('aria-label', teks);
                tombol.title = teks;
                kolom.focus();
            });
        })();

        // Cegah klik ganda: nonaktifkan tombol Login setelah form dikirim
        document.getElementById('formLogin')?.addEventListener('submit', function() {
            var tombol = document.getElementById('tombolLogin');
            if (!tombol) return;
            setTimeout(function() {
                tombol.disabled = true;
                tombol.innerHTML =
                    '<i class="bi bi-arrow-repeat me-1 inline-block animate-spin"></i> Memproses...';
            }, 0);
        });
    </script>
</body>

</html>
