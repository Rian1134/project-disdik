<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMANDIK-SMP</title>
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

        {{-- ===== Panel merek (hanya layar lebar) ===== --}}
        <section
            class="relative hidden flex-col justify-between overflow-hidden bg-linear-to-br from-emerald-600 via-emerald-700 to-teal-800 p-12 text-white lg:flex">
            {{-- Hiasan latar --}}
            <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-white/10"
                aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-16 h-96 w-96 rounded-full bg-black/10"
                aria-hidden="true"></div>

            <div class="relative flex items-center gap-3">
                <span
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 text-2xl ring-1 ring-white/30">
                    <i class="bi bi-building"></i>
                </span>
                <span class="text-lg font-bold tracking-wide">SIMANDIK-SMP</span>
            </div>

            <div class="relative max-w-md">
                <h2 class="text-3xl font-bold leading-tight">Kelola Data Siswa.</h2>
        
            </div>

            <p class="relative text-xs text-emerald-100/80">&copy; {{ date('Y') }} SIMANDIK-SMP</p>
        </section>

        {{-- ===== Form login ===== --}}
        <section class="relative flex items-center justify-center p-4 sm:p-8">

            {{-- Tombol ganti tema --}}
            <button type="button" id="themeToggle" title="Ganti tema" aria-label="Ganti tema terang/gelap"
                class="absolute right-4 top-4 inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-emerald-300">
                <i class="bi bi-moon-stars dark:hidden"></i>
                <i class="bi bi-sun hidden dark:inline"></i>
            </button>

            <div class="w-full max-w-sm">

                {{-- Merek untuk layar kecil --}}
                <div class="mb-8 text-center lg:hidden">
                    <span
                        class="mx-auto mb-3 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-linear-to-br from-emerald-500 to-teal-600 text-3xl text-white shadow-md">
                        <i class="bi bi-building"></i>
                    </span>
                    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">SIMANDIK-SMP</h1>
                </div>

                <div class="mb-6 hidden lg:block">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Selamat datang</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Silakan login untuk melanjutkan.</p>
                </div>
                <p class="mb-6 text-center text-sm text-gray-500 dark:text-gray-400 lg:hidden">
                    Silakan login untuk melanjutkan.
                </p>

                {{-- Pesan sukses / error dari server (mis. setelah logout atau akun ditolak) --}}
                @if (session('success'))
                    <x-alert type="success" dismissible class="mb-4">{{ session('success') }}</x-alert>
                @endif
                @if (session('error'))
                    <x-alert type="danger" dismissible class="mb-4">{{ session('error') }}</x-alert>
                @endif

                <x-card>
                    <form id="formLogin" action="{{ route('login.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf

                        <x-form.input name="email" label="Email" type="email" placeholder="nama@email.com"
                            autocomplete="username" autofocus required />

                        {{-- Tombol mata memakai slot suffix milik x-form.input --}}
                        <x-form.input name="password" label="Password" type="password" placeholder="Masukkan password"
                            autocomplete="current-password" required>
                            <x-slot:suffix>
                                <button type="button" id="tombolMata" title="Tampilkan password"
                                    aria-label="Tampilkan password" aria-pressed="false"
                                    class="inline-flex items-center justify-center text-gray-500 transition hover:text-emerald-600 focus:outline-none focus-visible:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-300">
                                    <i class="bi bi-eye text-lg"></i>
                                </button>
                            </x-slot:suffix>
                        </x-form.input>

                        <x-button type="submit" id="tombolLogin" full-width>
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </x-button>
                    </form>
                </x-card>

                <p class="mt-6 text-center text-xs text-gray-400 dark:text-gray-600 lg:hidden">
                    &copy; {{ date('Y') }} SIMANDIK-SMP
                </p>
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
